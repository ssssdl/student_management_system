<?php
    class updateinfoModel{

        //更新管理员信息
        function update_admininfo($_info){
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
        </script>  ');
            mysqli_query($mysql,"set names utf8");//防止中文乱码 统一使用utf8
            //Tname Tsex Tage tpolitical ttele
            $sql = "update teacher set Tname = \"".$_info['tname']."\",Tsex = \"".$_info['tsex']."\",Tage =".$_info['tage'].",Tpolitical =\"".$_info['tpolitical']."\",Ttele = \"".$_info['ttele']."\" where Tno = \"".$_info['tno']."\"";
            //echo $sql;
            $results = $mysql -> query($sql);
            if ($results) 
                echo '<script language="javascript">  
                alert("管理员信息更新成功");  
                window.history.back(-1);     
                </script>  ';
            else 
                echo '<script language="javascript">  
                alert("管理员信息更新失败");  
                window.history.back(-1);     
                </script>  ';
            //mysqli_free_result($results);
            mysqli_close($mysql); 
        }

        //更新密码
        function update_pass($_pass){
            /** $_pass['pass'] $_pass['uno']*/
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = "update ".whoisit($_pass['uno'])." set ".whoispass($_pass['uno'])." = \"".$_pass['pass']."\" where ".whoisno($_pass['uno'])." = ".$_pass['uno'];
            $results = $mysql -> query($sql);
            if ($results) 
                echo '<script language="javascript">  
                alert("更新密码成功");  
                window.history.back(-1);     
                </script>  ';
            else 
                echo '<script language="javascript">  
                alert("修改密码失败");  
                window.history.back(-1);     
                </script>  ';
            //mysqli_free_result($results);
            mysqli_close($mysql); 
        }
        function update_tele($_info){
            /**$_info['uno']  $_info['tele']; */
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            //update teacher set ttele = ? where 
            $sql = "update ".whoisit($_info['uno'])." set ".whoistele($_info['uno'])." = \"".$_info['tele']."\" where ".whoisno($_info['uno'])." = ".$_info['uno'];
            $results = $mysql -> query($sql);
            if ($results) 
                echo '<script language="javascript">  
                alert("更新密码成功");  
                window.history.back(-1);     
                </script>  ';
            else 
                echo '<script language="javascript">  
                alert("修改密码失败");  
                window.history.back(-1);     
                </script>  ';
            //mysqli_free_result($results);
            mysqli_close($mysql);
        }
        function update_grade($_sno,$_cno,$_grade){
            //修改和录入成绩
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            //update stu_cour set grade =  where sno =  and cno= 
            $sql = 'update stu_cour set Grade = '.$_grade.' where Sno = "'.$_sno.'" and Cno = "'.$_cno.'"';//语句没问题
            $results = $mysql -> query($sql);
            if ($results)
                $_fl = true;
            else
                $_fl = false;
            //mysqli_free_result($results);
            mysqli_close($mysql);
            return $_fl;
        }
        function update_course($_cno,$_cname,$_chour,$_ccredit){
            //管理员修改课程
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            //update couser set Cname=  ，Chour= ， Ccredit= ， where cno= 
            $sql = 'update course set Cname = "'.$_cname.'",Chour = '.$_chour.',Ccredit = '.$_ccredit.' where cno = "'.$_cno.'"';
            $results = $mysql -> query($sql);
            if ($results)
                $_fl = true;
            else
                $_fl = false;
            //mysqli_free_result($results);
            mysqli_close($mysql);
            return $_fl;
        }
        function update_student($sql){
            //修改用户
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            $results = $mysql -> query($sql);
            if ($results)
                $_fl = true;
            else
                $_fl = false;
            mysqli_close($mysql);
            return $_fl;
        }
    }
?>