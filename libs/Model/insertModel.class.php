<?php
    class insertModel{
        //向数据库中插入数据
        function insertstu_cour($_sno,$_cno){
            //选课
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'Insert into stu_cour (Sno,Cno) values ("'.$_sno.'","'.$_cno.'");';
            if(mysqli_query($mysql,$sql)){
                //插入数据成功
                $_f = true;
            }else{
                //插入失败
                //echo "Error:".$sql."<br>".mysqli_error($mysql);
                $_f = false;
            }
            mysqli_close($mysql);
            return $_f;
        }
        function insertcourse($_cname,$_chour,$_ccredit,$_tno){
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            //先找到数据库最后一个课程号 然后再添加进去
            $sql = "select cno from course";
            $results = $mysql -> query($sql);
            $_f = false;
            while ($row = mysqli_fetch_array($results)){
                $_f = true;
                $_str = $row['cno'];
            }
            mysqli_free_result($results);
            if($_f == false){
                $_cno = "2016001";
            }else{//intval
                $_cno = strval(intval($_str)+1);
            }
            $sql = 'insert into course (Cno,Cteacherno,Cname,Chour,Ccredit) values ("'.$_cno.'","'.$_tno.'","'.$_cname.'","'.$_chour.'","'.$_ccredit.'");';
            if(mysqli_query($mysql,$sql)){
                //插入数据成功
                $_f = true;
            }else{
                //插入失败
                //echo "Error:".$sql."<br>".mysqli_error($mysql);
                $_f = false;
            }
            mysqli_close($mysql); 
            return $_f;
        }
        function insert_student($sql){
            //选课
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
            </script>  ');
            mysqli_query($mysql,"set names utf8");
            if(mysqli_query($mysql,$sql)){
                //插入数据成功
                $_f = true;
            }else{
                //插入失败
                //echo "Error:".$sql."<br>".mysqli_error($mysql);
                $_f = false;
            }
            mysqli_close($mysql);
            return $_f;
        }
    }
?>