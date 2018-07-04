<?php
    //用户模型 ，用于用户基本信息的增删改查
    class userModel{
        function selectuser($_userno){
            //查询返回各种用户基本信息 数组
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
        </script>  ');
            mysqli_query($mysql,"set names utf8");//防止中文乱码 统一使用utf8
            $sql = "select* from ".whoisit($_userno)." where ".whoisno($_userno)." = ".$_userno;
            $results = $mysql -> query($sql);
            $_f = 0;
            if($row = mysqli_fetch_array($results)){
                $_f = 1;
            }
            mysqli_free_result($results);
            mysqli_close($mysql); 
            if($_f == 1){
                //foreach($row as $key=>$value)
                    //echo '<br>'.$value; 
                return $row;
            }else{
                return "";
            }
        }
        function selectBasic_results($_userno){
            //查询返回学生基础成绩$arr['name']='hello';
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
        </script>  ');
            mysqli_query($mysql,"set names utf8");//防止中文乱码 统一使用utf8
            //学分credit  总共修的课程数coucourse  及格以上课程数Pcourse  优秀课程数fcourse
            $sql = "select sum(Ccredit) credit,count(Ccredit) Pcourse from course,stu_cour where course.cno=stu_cour.cno and stu_cour.Grade>=60 and stu_cour.sno=".$_userno;//学分 和 及格的课程数
            $sql1 = "select count(Ccredit) fcourse from course,stu_cour where course.cno=stu_cour.cno and stu_cour.Grade>=90 and stu_cour.sno=".$_userno;//优秀课程数
            $sql2 = "select count(Ccredit) coucourse from course,stu_cour where course.cno=stu_cour.cno and stu_cour.sno=".$_userno;//总课程数
            $results = $mysql -> query($sql);
            if($row = mysqli_fetch_array($results)){
                $_f = $row;
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql1);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql2);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            mysqli_close($mysql); 
            return $_f;
        }
        function selectcourse($_userno){
            //根据学号  工号 （返回课程名  学生姓名  成绩）
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");//防止中文乱码 统一使用utf8
            $sql = "select sname,cname,grade,tname  from stu_cour,student,course,teacher where teacher.tno=course.Cteacherno and course.cno=stu_cour.cno and stu_cour.sno=student.sno and ".whoisit($_userno).".".whoisno($_userno)." = ".$_userno;
            //echo $sql;
            $results = $mysql -> query($sql);
            $_i = 0;
            while($row = mysqli_fetch_array($results)){//mysqli_fetch_array这个函数只能取一行array_push
                if($_i == 0){
                    $_f =  array(array('sname'=>$row['sname'],'tname'=>$row['tname'],'cname'=>$row['cname'],'grade'=>$row['grade']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('sname'=>$row['sname'],'tname'=>$row['tname'],'cname'=>$row['cname'],'grade'=>$row['grade'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            /*foreach ($_f as $key => $value) {
                echo '<br>';
				echo $value['sname']." ".$value['tname']." ".$value['cname']." ".$value['grade'];
            }*/
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function selectnograde($_userno){
            //根据教师号查询当前教师的没有成绩的课程 (返回学生名+课程名)
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");//防止中文乱码 统一使用utf8
            $sql = "select sname,student.sno sno,cname,course.cno cno  from stu_cour,student,course,teacher where teacher.tno=course.Cteacherno and course.cno=stu_cour.cno and stu_cour.sno=student.sno and stu_cour.grade is NULL and teacher.tno = ".$_userno." order by student.sno" ;
            //echo $sql;
            $results = $mysql -> query($sql);
            $_i = 0;
            while($row = mysqli_fetch_array($results)){//mysqli_fetch_array这个函数只能取一行array_push
                if($_i == 0){
                    $_f =  array(array('sname'=>$row['sname'],'sno'=>$row['sno'],'cname'=>$row['cname'],'cno'=>$row['cno']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('sname'=>$row['sname'],'sno'=>$row['sno'],'cname'=>$row['cname'],'cno'=>$row['cno'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function selectchcourse($_userno){
            //查询学生未选课程 //只有确认是学生可以调用
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            //sql 课程名  课程号  课程老师  课时  学分  在course表中 当课程号不再（查询课程号 在stu——cour 当学号为￥userno时） 存入二维数组
            // select cname,cno,tname,chour,ccredit from teacher,course where teacher.tno = course.cteacherno and cno not in (select cno from stu_cour where sno = "2016083101");
            $sql = 'select cname,cno,tname,chour,ccredit from teacher,course where teacher.tno = course.cteacherno and cno not in (select cno from stu_cour where sno = "'.$_userno.'")';
            $results = $mysql -> query($sql);
            $_i = 0;
            while($row = mysqli_fetch_array($results)){//mysqli_fetch_array这个函数只能取一行array_push
                if($_i == 0){
                    $_f =  array(array('cname'=>$row['cname'],'cno'=>$row['cno'],'tname'=>$row['tname'],'chour'=>$row['chour'],'ccredit'=>$row['ccredit']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('cname'=>$row['cname'],'cno'=>$row['cno'],'tname'=>$row['tname'],'chour'=>$row['chour'],'ccredit'=>$row['ccredit'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function selectallcourse(){
            //查询所有课程  ，统计选课人数
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            //sql 课程名(可修改)cname  课程号cno  课程老师(tname tno)  课时(可修改)chour  学分(可修改)ccredit 选课人数count(sno)snum  
            // select cname,cno,tname,chour,ccredit from teacher,course where teacher.tno = course.cteacherno and cno not in (select cno from stu_cour where sno = "2016083101");
            $sql = 'select course.*,teacher.tname tname,count(sno) snum 
                        from teacher,course,stu_cour 
                        where teacher.tno=course.cteacherno and course.cno=stu_cour.cno 
                        group by stu_cour.cno 
                    union select course.*,teacher.tname,0 
                        from course,teacher         
                        where teacher.tno=course.cteacherno and cno not in (select cno from stu_cour)';
            $results = $mysql -> query($sql);
            $_i = 0;// Cno     | Cteacherno | Cname    | Chour | Ccredit | count(sno)
            while($row = mysqli_fetch_array($results)){//mysqli_fetch_array这个函数只能取一行array_push
                if($_i == 0){
                    $_f =  array(array('cname'=>$row['Cname'],'cno'=>$row['Cno'],'tname'=>$row['tname'],'tno'=>$row['Cteacherno'],'chour'=>$row['Chour'],'ccredit'=>$row['Ccredit'],'snum'=>$row['snum']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('cname'=>$row['Cname'],'cno'=>$row['Cno'],'tname'=>$row['tname'],'tno'=>$row['Cteacherno'],'chour'=>$row['Chour'],'ccredit'=>$row['Ccredit'],'snum'=>$row['snum'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function selectallstudent(){
            //查询所有学生信息 包括学号，姓名，性别，年龄，家庭住址，学制，政治面貌，民族，休复转退情况，奖惩记录，电话，以修学分 共计12项
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            //一步都查出来
            $sql = 'select student.*,sum(course.Ccredit) allcredit from student,course,stu_cour where student.sno=stu_cour.sno and stu_cour.cno=course.cno and grade >=60  group by stu_cour.sno
             union select *,0 from student where sno not in (select student.sno from student,course,stu_cour where student.sno=stu_cour.sno and stu_cour.cno=course.cno and grade >=60  group by stu_cour.sno)';
            $results = $mysql -> query($sql);
            $_i = 0;//Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass,allcredit
            while($row = mysqli_fetch_array($results)){//mysqli_fetch_array这个函数只能取一行array_push
                if($_i == 0){
                    $_f =  array(array('sno'=>$row['Sno'],
                                        'sname'=>$row['Sname'],
                                        'ssex'=>$row['Ssex'],
                                        'sage'=>$row['Sage'],
                                        'sarea'=>$row['Sarea'],
                                        'seducational'=>$row['Seducational'],
                                        'spolitical'=>$row['Spolitical'],
                                        'snation'=>$row['Snation'],
                                        'sleave'=>$row['Sleave'],
                                        'sreward'=>$row['Sreward'],
                                        'stele'=>$row['Stele'],
                                        'spass'=>$row['Spass'],
                                        'allcredit'=>$row['allcredit']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('sno'=>$row['Sno'],
                                                    'sname'=>$row['Sname'],
                                                    'ssex'=>$row['Ssex'],
                                                    'sage'=>$row['Sage'],
                                                    'sarea'=>$row['Sarea'],
                                                    'seducational'=>$row['Seducational'],
                                                    'spolitical'=>$row['Spolitical'],
                                                    'snation'=>$row['Snation'],
                                                    'sleave'=>$row['Sleave'],
                                                    'sreward'=>$row['Sreward'],
                                                    'stele'=>$row['Stele'],
                                                    'spass'=>$row['Spass'],
                                                    'allcredit'=>$row['allcredit'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function selectallteacher(){
            //查询所有教师信息 包括工号，姓名，性别，年龄，职务，政治面貌，电话，开设的课程数 共计8项
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'select teacher.*,count(course.Cno) ccou from teacher,course where teacher.tno=course.Cteacherno group by course.Cteacherno union select *,0 from teacher where teacher.tno not in (select distinct Cteacherno from course)';
            $results = $mysql -> query($sql);
            $_i = 0;//Tno,Tname,Tsex,Tage,Tposit,Tpolitical,Ttele,Tpass,ccou)
            while($row = mysqli_fetch_array($results)){//mysqli_fetch_array这个函数只能取一行array_push
                if($_i == 0){
                    $_f =  array(array('tno'=>$row['Tno'],
                                        'tname'=>$row['Tname'],
                                        'tsex'=>$row['Tsex'],
                                        'tage'=>$row['Tage'],
                                        'tposit'=>$row['Tposit'],
                                        'tpolitical'=>$row['Tpolitical'],
                                        'ttele'=>$row['Ttele'],
                                        'tpass'=>$row['Tpass'],
                                        'ccou'=>$row['ccou']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('tno'=>$row['Tno'],
                                                    'tname'=>$row['Tname'],
                                                    'tsex'=>$row['Tsex'],
                                                    'tage'=>$row['Tage'],
                                                    'tposit'=>$row['Tposit'],
                                                    'tpolitical'=>$row['Tpolitical'],
                                                    'ttele'=>$row['Ttele'],
                                                    'tpass'=>$row['Tpass'],
                                                    'ccou'=>$row['ccou'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function selectalllcourse(){
            //查询所有选课信息 包括课程名，课程号，讲课教师工号，姓名，选课学生学号 ，姓名  学生成绩 共计7项
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'select stu_cour.cno cno,course.cname cname,stu_cour.sno sno,student.sname sname,course.Cteacherno tno,teacher.tname tname,stu_cour.grade grade from student,course,teacher,stu_cour where stu_cour.sno=student.sno and stu_cour.cno=course.cno and course.Cteacherno=teacher.tno';
            $results = $mysql -> query($sql);
            $_i = 0;// cno,cname,sno,sname,tno,tname,grade
            while($row = mysqli_fetch_array($results)){//mysqli_fetch_array这个函数只能取一行array_push
                if($_i == 0){
                    $_f =  array(array('cno'=>$row['cno'],
                                        'cname'=>$row['cname'],
                                        'sno'=>$row['sno'],
                                        'sname'=>$row['sname'],
                                        'tno'=>$row['tno'],
                                        'tname'=>$row['tname'],
                                        'grade'=>$row['grade']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('cno'=>$row['cno'],
                                                    'cname'=>$row['cname'],
                                                    'sno'=>$row['sno'],
                                                    'sname'=>$row['sname'],
                                                    'tno'=>$row['tno'],
                                                    'tname'=>$row['tname'],
                                                    'grade'=>$row['grade'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function teacher_statistics($_cno){
            //输入课程号返回课程统计全部信息 选课总人数 优秀 良好 中等 及格 不及格 人数
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql_all = 'select count(sno) allstu from  stu_cour where cno ="'.$_cno.'"';
            $sql_you = 'select count(sno) youa from stu_cour where Grade>=90 and Grade<=100 and cno ="'.$_cno.'"';
            $sql_liang = 'select count(sno) liang from stu_cour where Grade>=80 and Grade<90 and cno ="'.$_cno.'"';
            $sql_zhong = 'select count(sno) zhong from stu_cour where Grade>=70 and Grade<80 and cno ="'.$_cno.'"';
            $sql_ji = 'select count(sno) ji from  stu_cour where Grade>=60 and Grade<70 and cno ="'.$_cno.'"';
            $sql_buji = 'select count(sno) buji from stu_cour where Grade<60 and cno ="'.$_cno.'"';
            $results = $mysql -> query($sql_all);
            if($row = mysqli_fetch_array($results)){
                $_f = $row;
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql_you);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql_liang);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql_zhong);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql_ji);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql_buji);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            mysqli_close($mysql); 
            return $_f;
            
        }
        function teacherAll_statistics($_tno){
            //输入职工号返回课程统计全部信息 课程名 课程号 总人数 优秀 良好 中等 及格 不及格 人数
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'select cno ,cname from course where Cteacherno = "'.$_tno.'"';
            $results = $mysql -> query($sql);
            $_i = 0;
            while($row = mysqli_fetch_array($results)){
                $_s = $this-> teacher_statistics($row['cno']);
                if($_i == 0){
                    $_f =  array(array('cno'=>$row['cno'],
                                        'cname'=>$row['cname'],
                                        'allstu'=>$_s['allstu'],
                                        'youa'=>$_s['youa'],
                                        'liang'=>$_s['liang'],
                                        'zhong'=>$_s['zhong'],
                                        'ji'=>$_s['ji'],
                                        'buji'=>$_s['buji']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('cno'=>$row['cno'],
                'cname'=>$row['cname'],
                'allstu'=>$_s['allstu'],
                'youa'=>$_s['youa'],
                'liang'=>$_s['liang'],
                'zhong'=>$_s['zhong'],
                'ji'=>$_s['ji'],
                'buji'=>$_s['buji'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function andminAll_statistics(){
            //输入职工号返回课程统计全部信息 课程名 课程号 总人数 优秀 良好 中等 及格 不及格 人数
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'select cno ,cname from course ';
            $results = $mysql -> query($sql);
            $_i = 0;
            while($row = mysqli_fetch_array($results)){
                $_s = $this-> teacher_statistics($row['cno']);
                if($_i == 0){
                    $_f =  array(array('cno'=>$row['cno'],
                                        'cname'=>$row['cname'],
                                        'allstu'=>$_s['allstu'],
                                        'youa'=>$_s['youa'],
                                        'liang'=>$_s['liang'],
                                        'zhong'=>$_s['zhong'],
                                        'ji'=>$_s['ji'],
                                        'buji'=>$_s['buji']));
                    $_i++;
                    continue;
                }
                $_f = array_merge($_f,array(array('cno'=>$row['cno'],
                'cname'=>$row['cname'],
                'allstu'=>$_s['allstu'],
                'youa'=>$_s['youa'],
                'liang'=>$_s['liang'],
                'zhong'=>$_s['zhong'],
                'ji'=>$_s['ji'],
                'buji'=>$_s['buji'])));
            }
            mysqli_free_result($results);
            mysqli_close($mysql);
            if($_i != 0)
                return $_f;
            else 
                return "";
        }
        function selectstudenttongji(){
            //查询返回学生基础成绩$arr['name']='hello';
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
        </script>  ');
            mysqli_query($mysql,"set names utf8");//防止中文乱码 统一使用utf8
            //少数民族 人数 shao 年龄小于20 xiao 党员 dang
            $sql = 'select count(sno) shao from student where Snation != "汉族"';
            $sql1 = 'select count(sno) xiao from student where Sage<20;';
            $sql2 = 'select count(sno) dang from student where Spolitical = "共产党员"';
            $results = $mysql -> query($sql);
            if($row = mysqli_fetch_array($results)){
                $_f = $row;
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql1);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            $results = $mysql -> query($sql2);
            if($row = mysqli_fetch_array($results)){
                $_f = array_merge($_f,$row);
            }
            mysqli_free_result($results);
            mysqli_close($mysql); 
            return $_f;
        }
    }
?>