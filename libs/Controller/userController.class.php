<?php
    class userController{
        //用于管理员管理全部用户信息  
        //读取全部教师信息+统计老师开设的课程数  对老师进行修改和删除和添加
        //读取全部学生信息+统计学生选的课程数    对学生进行修改和删除和添加
        //读取全部选课信息  对选课信息进行增删改查   成绩的修改
        function adminuser(){
            session_start();
            if(isset($_SESSION['userno'])){
                $_userInfo = M('user') -> selectuser($_SESSION['userno']);//变量传给视图显示
                if(isset($_userInfo["Tposit"])&&$_userInfo["Tposit"]=="系统管理员"){
                    //进入模型读取全部数据
                    //学生 基本信息(不包括密码)+学分
                    $_allstudent = M('user') -> selectallstudent();
                    //教师 基本信息(不包括密码)+开设的课程数  可以用那个whoitis那个函数
                    $_allteacher = M('user') -> selectallteacher();
                    //全部选课信息  学生名+学号+课程名+课程号+教师名+工号+成绩
                    $_allstucou = M('user') -> selectalllcourse();
                    $head = V("head");
                    $_user = V("user");
                    $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                    V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                    V("titlesearch")->title_html_small("管理用户");
                    //调用示图显示
                    $_tongji = M('user')->selectstudenttongji();
                    V('tabs')->adminstucour($_allstudent,$_allteacher,$_allstucou,$_tongji);
                    $head -> html_end();
                    //数据处理
                    if(isset($_POST['submit'])){
                        //如果点击了六个中的任意按钮  先判断密码
                        if(isset($_POST['password'])){//验证密码
                            if(is_array($_POST['password']))//防止MD5漏洞
                                die('<script language="javascript">  
                                alert("用户名或密码错误");  
                                window.history.back(-1);     
                                </script>');
                            $_m_login = M("login");//验证密码
                            if(strcmp($_m_login->islogin($_SESSION['userno']),md5($_POST['password']))==0){
                        switch ($_POST['submit']) {
                            case '删除学籍':
                                if($_allstudent!=""){
                                    $j = 0;
                                    foreach ($_allstudent as $key => $value) {//Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass,allcredit
                                        if(isset($_POST['chstu'][$j]))
                                        if($_POST['chstu'][$j]=='choose'){
                                            $info = M('user')->selectBasic_results($value['sno']);
                                            if($info['coucourse'] == 0){//课程数等于0
                                                //删除模型删除
                                                if(!M('delete')->delete_user($value['sno'] ))
                                                    echo '<script language="javascript">  
                                                    alert("学号为：'.$value['sno'].'的学生信息由于数据库错误删除失败");    
                                                    </script>  ';
                                            }else{
                                                echo '<script language="javascript">  
                                                alert("学号为：'.$value['sno'].'的学生信息由于未清除选课记录删除失败");    
                                                </script>  ';
                                            }
                                        }
                                        $j++;
                                    } 
                                    echo '<script language="javascript">  
                                                window.location.replace("./index.php?controller=user&method=adminuser") 
                                                </script>  ';
                                }else{
                                    echo '<script language="javascript">  
                                    alert("没有这个按钮");  
                                    window.history.back(-1);     
                                    </script>  ';
                                }
                                break;
                            case '修改或添加学籍信息':
                                //添加学籍或者修改
                                if($_allstudent!=""){
                                    $j = 0;
                                    foreach ($_allstudent as $key => $value) {//Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass,allcredit
                                        if(isset($_POST['chstu'][$j]))
                                            if($_POST['chstu'][$j]=='choose'){
                                                //过滤调用模型模型修改sname,ssex,sage,sarea,seducational,snation,sleave sreward,stele,spass,spolitical
                                                if(isset($_POST['sname'][$j],$_POST['ssex'][$j],$_POST['sage'][$j],$_POST['sarea'][$j],$_POST['seducational'][$j],$_POST['spolitical'][$j],$_POST['stele'][$j])){
                                                    if(!empty($_POST['sname'][$j])&&!empty($_POST['ssex'][$j])&&!empty($_POST['sage'][$j])&&!empty($_POST['sarea'][$j])&&!empty($_POST['seducational'][$j])&&!empty($_POST['spolitical'][$j])&&!empty($_POST['stele'][$j])){
                                                        //判断关键字Sleave,Sreward,Stele,Spass是否符合要求
                                                        if(whatname($_POST['sname'][$j])&&whatsex($_POST['ssex'][$j])&&whatage($_POST['sage'][$j])&&!whatarea($_POST['sarea'][$j])&&!whatcname($_POST['seducational'][$j])&&whatpolitical($_POST['spolitical'][$j])&&whattele($_POST['stele'][$j])){
                                                            //可以直接送如数据库$value['sno'],$_POST['sname'][$j],$_POST['ssex'][$j],$_POST['sage'][$j],$_POST['sarea'][$j],$_POST['seducational'][$j],$_POST['spolitical'][$j],$_POST['stele'][$j]
                                                            //处理密码 民族 休复选退 奖惩记录直接构造sql语句到数据库中执行
                                                            $_spass = isset($_POST['spass'][$j])? md5($_POST['spass'][$j]):$value['spass'];
                                                            $_nation = isset($_POST['snation'][$j])? (whatarea($_POST['snation'][$j])? "aa":$_POST['snation'][$j]):"";
                                                            $_sleave = isset($_POST['sleave'][$j])? (whatarea($_POST['sleave'][$j])? "":$_POST['sleave'][$j]):"";
                                                            $_sreward = isset($_POST['sreward'][$j])? (whatarea($_POST['sreward'][$j])? "":$_POST['sreward'][$j]):"";
                                                            $sql = 'update student set Sname = "'.$_POST['sname'][$j].'",Ssex = "'.$_POST['ssex'][$j].'",Sage = '.$_POST['sage'][$j].',Sarea = "'.$_POST['sarea'][$j].'",
                                                            Seducational = "'.$_POST['seducational'][$j].'",Spolitical = "'.$_POST['spolitical'][$j].'",Snation = "'.$_nation.'",Sleave = "'.$_sleave.'",Sreward = "'.$_sreward.'",Stele = "'.$_POST['stele'][$j].'",Spass = "'.$_spass.'" where sno = "'.$value['sno'].'"';
                                                            //到数据库执行$sql
                                                            if(!M('updateinfo')->update_student($sql))
                                                                echo '<script language="javascript">  
                                                            alert("学号为'.$value['sno'].'的学生信息由于数据库原因，修改失败");    
                                                            </script>  ';
                                                        }else{
                                                            echo '<script language="javascript">  
                                                    alert("学号为'.$value['sno'].'的学生信息不符合要求，修改失败");    
                                                    </script>  ';
                                                        }
                                                    }else{
                                                        echo '<script language="javascript">  
                                                    alert("学号为'.$value['sno'].'的学生信息不全，修改失败");    
                                                    </script>  ';
                                                    }                                               
                                                }else{
                                                    echo '<script language="javascript">  
                                                alert("学号为'.$value['sno'].'的学生信息不全，修改失败");    
                                                </script>  ';
                                                }
                                            }
                                        $j++;
                                        $_str = $value['sno'];
                                    } 
                                    $_str = strval(intval($_str)+1);
                                    //获取序号为j的文本框信息 学号为$_str 添加学生
                                    if($_POST['chstu'][$j]=='choose'){
                                        //过滤调用模型模型修改sname,ssex,sage,sarea,seducational,snation,sleave sreward,stele,spass,spolitical
                                        if(isset($_POST['sname'][$j],$_POST['ssex'][$j],$_POST['sage'][$j],$_POST['sarea'][$j],$_POST['seducational'][$j],$_POST['spolitical'][$j],$_POST['stele'][$j])){
                                            if(!empty($_POST['sname'][$j])&&!empty($_POST['ssex'][$j])&&!empty($_POST['sage'][$j])&&!empty($_POST['sarea'][$j])&&!empty($_POST['seducational'][$j])&&!empty($_POST['spolitical'][$j])&&!empty($_POST['stele'][$j])){
                                                //判断关键字Sleave,Sreward,Stele,Spass是否符合要求
                                                if(whatname($_POST['sname'][$j])&&whatsex($_POST['ssex'][$j])&&whatage($_POST['sage'][$j])&&!whatarea($_POST['sarea'][$j])&&!whatcname($_POST['seducational'][$j])&&whatpolitical($_POST['spolitical'][$j])&&whattele($_POST['stele'][$j])){
                                                    //可以直接送如数据库$value['sno'],$_POST['sname'][$j],$_POST['ssex'][$j],$_POST['sage'][$j],$_POST['sarea'][$j],$_POST['seducational'][$j],$_POST['spolitical'][$j],$_POST['stele'][$j]
                                                    //处理密码 民族 休复选退 奖惩记录直接构造sql语句到数据库中执行
                                                    $_spass = isset($_POST['spass'][$j])? md5($_POST['spass'][$j]):$value['spass'];
                                                    $_nation = isset($_POST['snation'][$j])? (whatarea($_POST['snation'][$j])? "aa":$_POST['snation'][$j]):"";
                                                    $_sleave = isset($_POST['sleave'][$j])? (whatarea($_POST['sleave'][$j])? "":$_POST['sleave'][$j]):"";
                                                    $_sreward = isset($_POST['sreward'][$j])? (whatarea($_POST['sreward'][$j])? "":$_POST['sreward'][$j]):"";
                                                    $sql = 'Insert into STUDENT (Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass) 
                                                    values ("'.$_str.'","'.$_POST['sname'][$j].'","'.$_POST['ssex'][$j].'",'.intval($_POST['sage'][$j]).',"'.$_POST['sarea'][$j].'","'.$_POST['seducational'][$j].'","'.$_POST['spolitical'][$j].'","'.$_nation.'","'.$_sleave.'","'.$_sreward.'","'.$_POST['stele'][$j].'","'.$_spass.'")';
                                                    //到数据库执行$sql
                                                    if(!M('insert')->insert_student($sql))
                                                        echo '<script language="javascript">  
                                                    alert("新建学生信息由于数据库原因，修改失败");    
                                                    </script>  ';
                                                }else{
                                                    echo '<script language="javascript">  
                                            alert("新建学生信息不符合要求，修改失败");    
                                            </script>  ';
                                                }
                                            }else{
                                                echo '<script language="javascript">  
                                            alert("新建学生信息不全，修改失败");    
                                            </script>  ';
                                            }                                               
                                        }else{
                                            echo '<script language="javascript">  
                                        alert("新建学生信息不全，修改失败");    
                                        </script>  ';
                                        }
                                    }
                                    echo '<script language="javascript">  
                                                window.location.replace("./index.php?controller=user&method=adminuser")     
                                                </script>  ';
                                }else{
                                    //学号从2016083101开始 获取[0]文本框信息添加学生
                                    if($_POST['chstu'][0]=='choose'){
                                        //过滤调用模型模型修改sname,ssex,sage,sarea,seducational,snation,sleave sreward,stele,spass,spolitical
                                        if(isset($_POST['sname'][0],$_POST['ssex'][0],$_POST['sage'][0],$_POST['sarea'][0],$_POST['seducational'][0],$_POST['spolitical'][0],$_POST['stele'][0])){
                                            if(!empty($_POST['sname'][0])&&!empty($_POST['ssex'][0])&&!empty($_POST['sage'][0])&&!empty($_POST['sarea'][0])&&!empty($_POST['seducational'][0])&&!empty($_POST['spolitical'][0])&&!empty($_POST['stele'][0])){
                                                //判断关键字Sleave,Sreward,Stele,Spass是否符合要求
                                                if(whatname($_POST['sname'][0])&&whatsex($_POST['ssex'][0])&&whatage($_POST['sage'][0])&&!whatarea($_POST['sarea'][0])&&!whatcname($_POST['seducational'][0])&&whatpolitical($_POST['spolitical'][0])&&whattele($_POST['stele'][0])){
                                                    //可以直接送如数据库$value['sno'],$_POST['sname'][$j],$_POST['ssex'][$j],$_POST['sage'][$j],$_POST['sarea'][$j],$_POST['seducational'][$j],$_POST['spolitical'][$j],$_POST['stele'][$j]
                                                    //处理密码 民族 休复选退 奖惩记录直接构造sql语句到数据库中执行
                                                    $_spass = isset($_POST['spass'][0])? md5($_POST['spass'][0]):$value['spass'];
                                                    $_nation = isset($_POST['snation'][0])? (whatarea($_POST['snation'][0])? "aa":$_POST['snation'][0]):"";
                                                    $_sleave = isset($_POST['sleave'][0])? (whatarea($_POST['sleave'][0])? "":$_POST['sleave'][0]):"";
                                                    $_sreward = isset($_POST['sreward'][0])? (whatarea($_POST['sreward'][0])? "":$_POST['sreward'][0]):"";
                                                    $sql = 'Insert into STUDENT (Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass) 
                                                    values ("2016083101","'.$_POST['sname'][0].'","'.$_POST['ssex'][0].'",'.intval($_POST['sage'][0]).',"'.$_POST['sarea'][0].'","'.$_POST['seducational'][0].'","'.$_POST['spolitical'][0].'","'.$_nation.'","'.$_sleave.'","'.$_sreward.'","'.$_POST['stele'][0].'","'.$_spass.'")';
                                                    //到数据库执行$sql
                                                    if(!M('insert')->insert_student($sql))
                                                        echo '<script language="javascript">  
                                                    alert("新建学生信息由于数据库原因，修改失败");    
                                                    </script>  ';
                                                    else 
                                                    echo '<script language="javascript">  
                                                    window.location.replace("./index.php?controller=user&method=adminuser")     
                                                    </script>  ';
                                                }else{
                                                    echo '<script language="javascript">  
                                            alert("新建学生信息不符合要求，修改失败");    
                                            </script>  ';
                                                }
                                            }else{
                                                echo '<script language="javascript">  
                                            alert("新建学生信息不全，修改失败");    
                                            </script>  ';
                                            }                                               
                                        }else{
                                            echo '<script language="javascript">  
                                        alert("新建学生信息不全，修改失败");    
                                        </script>  ';
                                        }
                                    }
                                }
                                break;
                            case '删除职工':
                                if($_allteacher!=""){
                                    $j = 0;
                                    foreach ($_allteacher as $key => $value) {//Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass,allcredit
                                        if(isset($_POST['chtea'][$j]))
                                            if($_POST['chtea'][$j]=='choose'){
                                                if($value['ccou'] == 0){
                                                    if(!M('delete')->delete_user($value['tno'] ))
                                                        echo '<script language="javascript">  
                                                        alert("学号为：'.$value['tno'].'的学生信息由于数据库错误删除失败");    
                                                        </script>  ';
                                                }else{
                                                    echo '<script language="javascript">  
                                                    alert("工号为：'.$value['tno'].'的职工信息由于未清除课程记录删除失败");    
                                                    </script>  ';
                                                }
                                            }
                                        $j++;
                                    } 
                                    echo '<script language="javascript">  
                                            window.location.replace("./index.php?controller=user&method=adminuser")     
                                            </script>  ';
                                }else{
                                    echo '<script language="javascript">  
                                        alert("没有这个按钮");  
                                        window.history.back(-1);     
                                    </script>  ';
                                }
                                break;
                            case '修改或添加职工信息':
	                            if($_allteacher!=""){
                                    $j = 0;
                                    foreach ($_allteacher as $key => $value) {
                                        if(isset($_POST['chtea'][$j]))
                                            if($_POST['chtea'][$j]=='choose'){
                                                    if(isset($_POST['tname'][$j],$_POST['tsex'][$j],$_POST['tage'][$j],$_POST['tposit'][$j],$_POST['tpolitical'][$j],$_POST['ttele'][$j])){
                                                            if(!empty($_POST['tname'][$j])&&!empty($_POST['tsex'][$j])&&!empty($_POST['tage'][$j])&&!empty($_POST['tposit'][$j])&&!empty($_POST['tpolitical'][$j])&&!empty($_POST['ttele'][$j])){
                                                                    if(whatname($_POST['tposit'][$j])&&whatname($_POST['tname'][$j])&&whatsex($_POST['tsex'][$j])&&whatage($_POST['tage'][$j])&&whatpolitical($_POST['tpolitical'][$j])&&whattele($_POST['ttele'][$j])){
                                                                        $_tpass = isset($_POST['tpass'][$j])? md5($_POST['tpass'][$j]):$value['tpass'];//Tno,Tname,Tsex,Tage,Tposit,Tpolitical,Ttele,Tpass
                                                                        $sql = 'update teacher set Tname = "'.$_POST['tname'][$j].'",Tsex = "'.$_POST['tsex'][$j].'",Tage = '.$_POST['tage'][$j].',Tposit = "'.$_POST['tposit'][$j].'",
                                                                        Tpolitical = "'.$_POST['tpolitical'][$j].'",Ttele = "'.$_POST['ttele'][$j].'",Tpass = "'.$_tpass.'" where tno = "'.$value['tno'].'"';
                                                                        if(!M('updateinfo')->update_student($sql))
                                                                                echo '<script language="javascript">  
                                                                                    alert("工号为'.$value['tno'].'的职工信息由于数据库原因，修改失败");    
                                                                                    </script>  ';
                                                                    }else{
                                                                        echo '<script language="javascript">  
                                                                            alert("工号为'.$value['tno'].'的职工信息不符合要求，修改失败");    
                                                                            </script>  ';
                                                                    }
                                                            }else{
                                                                echo '<script language="javascript">  
                                                                    alert("工号为'.$value['tno'].'的职工信息不全，修改失败");    
                                                                </script>  ';
                                                            }                                               
                                                    }else{
                                                        echo '<script language="javascript">  
                                                            alert("工号为'.$value['tno'].'的职工信息不全，修改失败");    
                                                            </script>  ';
                                                    }
                                                }
                                                $j++;
                                                 $_str = $value['tno'];
                                        } 
                                        $_str = strval(intval($_str)+1);
                                        //获取序号为j的文本框信息 工号为$_str 添加职工
                                        if($_POST['chtea'][$j]=='choose'){
                                            if(isset($_POST['tname'][$j],$_POST['tsex'][$j],$_POST['tage'][$j],$_POST['tposit'][$j],$_POST['tpolitical'][$j],$_POST['ttele'][$j])){
                                                if(!empty($_POST['tname'][$j])&&!empty($_POST['tsex'][$j])&&!empty($_POST['tage'][$j])&&!empty($_POST['tposit'][$j])&&!empty($_POST['tpolitical'][$j])&&!empty($_POST['ttele'][$j])){
                                                    if(whatname($_POST['tposit'][$j])&&whatname($_POST['tname'][$j])&&whatsex($_POST['tsex'][$j])&&whatage($_POST['tage'][$j])&&whatpolitical($_POST['tpolitical'][$j])&&whattele($_POST['ttele'][$j])){
                                                        $_tpass = isset($_POST['tpass'][$j])? md5($_POST['tpass'][$j]):$value['tpass'];//Tno,Tname,Tsex,Tage,Tposit,Tpolitical,Ttele,Tpass
                                                        $sql = 'insert into teacher (Tno,Tname,Tsex,Tage,Tposit,Tpolitical,Ttele,Tpass) 
                                                             values ("'.$_str.'","'.$_POST['tname'][$j].'","'.$_POST['tsex'][$j].'",'.$_POST['tage'][$j].',"'.$_POST['tposit'][$j].'","'.$_POST['tpolitical'][$j].'","'.$_POST['ttele'][$j].'","'.$_tpass.'")';
                                                        if(!M('insert')->insert_student($sql))
                                                            echo '<script language="javascript">  
                                                                alert("新建职工信息由于数据库原因，添加失败");    
                                                                </script>  ';
                                                    }else{
                                                        echo '<script language="javascript">  
                                                            alert("新建职工信息不符合要求，添加失败");    
                                                            </script>  ';
                                                    }
                                                }else{
                                                    echo '<script language="javascript">  
                                                        alert("新建职工信息不全，建立失败");    
                                                    </script>  ';
                                                }                                               
                                            }else{
                                                echo '<script language="javascript">  
                                                    alert("新建职工信息不全，建立失败");    
                                                    </script>  ';
                                            }
                                        }
                                        echo '<script language="javascript">  
                                            window.location.replace("./index.php?controller=user&method=adminuser")     
                                            </script>  ';
                                }else{
                                    if($_POST['chtea'][0]=='choose'){
                                        if(isset($_POST['tname'][0],$_POST['tsex'][0],$_POST['tage'][0],$_POST['tposit'][0],$_POST['tpolitical'][0],$_POST['ttele'][0])){
                                            if(!empty($_POST['tname'][0])&&!empty($_POST['tsex'][0])&&!empty($_POST['tage'][0])&&!empty($_POST['tposit'][0])&&!empty($_POST['tpolitical'][0])&&!empty($_POST['ttele'][0])){
                                                if(whatname($_POST['tposit'][0])&&whatname($_POST['tname'][0])&&whatsex($_POST['tsex'][0])&&whatage($_POST['tage'][0])&&whatpolitical($_POST['tpolitical'][0])&&whattele($_POST['ttele'][0])){
                                                    $_tpass = isset($_POST['tpass'][0])? md5($_POST['tpass'][0]):$value['tpass'];//Tno,Tname,Tsex,Tage,Tposit,Tpolitical,Ttele,Tpass
                                                    $sql = 'insert into teacher (Tno,Tname,Tsex,Tage,Tposit,Tpolitical,Ttele,Tpass) 
                                                            values ("20160001","'.$_POST['tname'][0].'","'.$_POST['tsex'][0].'",'.$_POST['tage'][0].',"'.$_POST['tposit'][0].'","'.$_POST['tpolitical'][0].'","'.$_POST['ttele'][0].'","'.$_tpass.'")';
                                                            if(!M('insert')->insert_student($sql))
                                                                echo '<script language="javascript">  
                                                                    alert("新建职工信息由于数据库原因，添加失败");    
                                                                    </script>  ';
                                                        }else{
                                                             echo '<script language="javascript">  
                                                                    alert("新建职工信息不符合要求，添加失败");    
                                                                    </script>  ';
                                                        }
                                                    }else{
                                                        echo '<script language="javascript">  
                                                            alert("新建职工信息不全，建立失败");    
                                                            </script>  ';
                                                    }                                               
                                                }else{
                                                    echo '<script language="javascript">  
                                                            alert("新建职工信息不全，建立失败");    
                                                        </script>  ';
                                                }
                                            }
                                            echo '<script language="javascript">  
                                                window.location.replace("./index.php?controller=user&method=adminuser")     
                                                </script>  ';
                                            }
                                break;
                            case '删除选课':
                                if($_allstucou!=""){
                                    $j = 0;
                                    foreach ($_allstucou as $key => $value) {//Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass,allcredit
                                        if(isset($_POST['chscou'][$j]))
                                        if($_POST['chscou'][$j]=='choose'){
                                            if(!M('delete')->delete_scour($value['sno'],$value['cno']))//删除重写
                                                echo '<script language="javascript">  
                                                alert("学号为：'.$value['sno'].'课程号为'.$value['cno'].'的信息由于数据库错误删除失败");    
                                                </script>  ';
                                        }
                                        $j++;
                                    } 
                                    echo '<script language="javascript">  
                                            window.location.replace("./index.php?controller=user&method=adminuser") 
                                            </script>  ';
                                }else{
                                    echo '<script language="javascript">  
                                        alert("没有这个按钮");  
                                        window.history.back(-1);     
                                        </script>  ';
                                }
                                break;
                            case '修改成绩':
                            if($_allstucou!=""){
                                $j = 0;
                                foreach ($_allstucou as $key => $value) {
                                    if(isset($_POST['chscou'][$j]))
                                        if($_POST['chscou'][$j]=='choose'){
                                            if(isset($_POST['grade'][$j]))
                                                if(!empty($_POST['grade'][$j])&&whatage($_POST['grade'][$j])){
                                                    $sql = 'update stu_cour set grade = '.$_POST['grade'][$j].' where cno = "'.$value['cno'].'" and sno = "'.$value['sno'].'"';
                                                    if(!M('updateinfo')->update_student($sql))
                                                        echo '<script language="javascript">  
                                                        alert("学号为：'.$value['sno'].'课程号为'.$value['cno'].'的信息由于数据库错误修改失败");    
                                                         </script>  ';
                                                }
                                            }
                                        $j++;
                                    }
                                }
                                echo '<script language="javascript">  
                                            window.location.replace("./index.php?controller=user&method=adminuser") 
                                            </script>  ';
                                break;
                            case '添加选课':
                                    if (isset($_POST['addcno'],$_POST['addsno'])) {
                                        if(!empty($_POST['addcno'])&&!empty($_POST['addsno'])&&nochar($_POST['addcno'])&&nochar($_POST['addsno'])){//这里缺一个判断是不是课程号和学号符合要求
                                            $sql = 'Insert into stu_cour (Sno,Cno) 
                                            values ("'.$_POST['addsno'].'","'.$_POST['addcno'].'")';
                                            if(!M('insert')->insert_student($sql))
                                                echo '<script language="javascript">  
                                                alert("选课信息添加失败");    
                                                 </script>  ';
                                        }
                                    }
                                    echo '<script language="javascript">  
                                            window.location.replace("./index.php?controller=user&method=adminuser") 
                                            </script>  ';   
                                break;
                            default:
                            echo '<script language="javascript">  
                            alert("没有这个按钮");  
                            window.history.back(-1);     
                        </script>  ';
                                break;
                            }
                        }else{
                                echo '<script language="javascript">  
                                alert("密码错误修改失败");  
                                window.history.back(-1);     
                                </script>  ';
                            }
                        }else{
                            echo '<script language="javascript">  
                            alert("请输入密码");  
                            window.history.back(-1);     
                        </script>  ';
                        }
                    }
                }else{
                    V('error')->notFound();
                }
            }else{
                V('error')->notFound();
            }
        }
    }
?>