<?php
    //登录模型 查询对应用户密码
    require_once('config/sqlconfig.php');
    class loginModel{
        function isLogin($_Uname){
            $mysql = mysqli_connect(SQL_HOST,SQL_USER,SQL_PASSWORD,SQL_DATABASE,SQL_PORT) or die('<script language="javascript">  
            alert("数据库繁忙");  
            window.history.back(-1);     
        </script>  ');
            $sql = "select spass from login where Sno = ".$_Uname;
            $results = $mysql -> query($sql);
            $_f = 0;
            while ($row = mysqli_fetch_array($results)){
                $_f = 1;
                $_str = $row['spass'];
            }
            mysqli_free_result($results);
            mysqli_close($mysql); 
            if($_f == 1){
                return $_str;
            }else{
                return "";
            }
        }
    }
?>