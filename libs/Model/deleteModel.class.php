<?php
    class deleteModel{
        function delete_course($_cno){
            //删除课程  提前判断还有没有学生选这个课 
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'delete from course where cno = "'.$_cno.'"';
            if(mysqli_query($mysql,$sql))
                $_fl = true;
            else
                $_fl = false;
            mysqli_close($mysql);
            return $_fl;
        }
        function delete_user($_no){
            //删除学生
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'delete from '.whoisit($_no).' where '.whoisno($_no).' = "'.$_no.'"';
            if(mysqli_query($mysql,$sql))
                $_fl = true;
            else
                $_fl = false;
            mysqli_close($mysql);
            return $_fl;
        }
        function delete_scour($_sno,$_cno){
            //删除选课
            require_once('config/sqlconfig.php');
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript"> alert("数据库繁忙"); window.history.back(-1); </script>  ');
            mysqli_query($mysql,"set names utf8");
            $sql = 'delete from stu_cour where sno = "'.$_sno.'" and cno ="'.$_cno.'"';
            echo $sql;
            if(mysqli_query($mysql,$sql))
                $_fl = true;
            else
                $_fl = false;
            mysqli_close($mysql);
            return $_fl;
        }
    }
?>