<?php
    //存放各种错误视图
    class errorView{
        function notFound(){
            //这个函数可以优化一下获取ip和路径
            ?><!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
            <html><head>
            <title>404 Not Found</title>
            </head><body>
            <h1>Not Found</h1>
            <p>The requested was not found on this server.</p>
            <hr>
            <address>Apache/2.4.23 (Win64) PHP/5.6.25 Server at 10.203.87.61 Port 80</address>
            </body></html>
            <?php
        }
    }
?>