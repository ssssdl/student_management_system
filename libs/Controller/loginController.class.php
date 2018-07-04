<?php
//控制器只负责模型和视图之间的交流 数据交换  这个写的有点复杂
//登陆后跳转欢迎界面   登陆前判断是否有cookie 有的话直接跳转
    class loginController{
        public function login(){
            //调用模型取出数据库数据进行比对
            session_start();
            if(isset($_SESSION['userno'])){
                $url = "./index.php?controller=index&method=index";  
                header('Location:' . $url);
            }
            else{
                if(isset($_POST['Username'])){
                //取到用户名
                    if(isset($_POST['Password'])){
                    //同时获取到用户名和密码  用户名长度定义为八位或十位只能是数字(正则匹配+长度判断，需要的话写一些waf)  长度定义为类私有静态变量  密码MD5加密
                    //模型读取数据库
                    if(is_array($_POST['Password']))
                        die('<script language="javascript">  
                        alert("用户名或密码错误");  
                        window.history.back(-1);     
                    </script>');
                        $_Uno = $_POST['Username'];
                        require_once('/function/waf.php');
                    if(nochar($_Uno)){
                        if(howLeng($_Uno)){ //判断长度是否符合要求
                            $_Pword = $_POST['Password'];
                            //调用视图查询
                            require_once('/function/function.php');
                            $_m_login = M("login");
                            if(strcmp($_m_login->islogin($_Uno),md5($_Pword))==0){
                                echo '<script>alert(\'登陆成功\')</script>';//启动session 跳转 设置session 
                                session_start();
                                $_SESSION['userno'] = $_Uno;
                                $_SESSION['whoisit'] = whoisit($_Uno);//SESSION+函数灵活调用
                                session_write_close();
                                $url = "./index.php?controller=index&method=index";  
                                header('Location:' . $url);
                            }else{ 
                                echo '<script language="javascript">  
                                alert("用户名或密码错误");  
                                window.history.back(-1);     
                            </script>  ';
                            }
                        }else{//长度错误
                            echo '<script language="javascript">  
                        alert("用户名或密码错误");  
                        window.history.back(-1);     
                    </script>  ';
                        }
                    }else{//用户名只能是数字
                        echo '<script language="javascript">  
                        alert("用户名或密码错误");  
                        window.history.back(-1);     
                    </script>  ';
                    }

                }else{//密码不能为空
                    echo '<script language="javascript">  
                    alert("用户名或密码错误");  
                    window.history.back(-1);     
             </script>  ';
                }
            }else {
                //没有取到用户名
                //视图调用显示
                $login = V('login');
                $head = V('head');
                $head->html_head('学生学籍管理系统','学生学籍管理系统');
                $login->showLogin();
                $head->html_end();
            }
        }
    }
    function unlogin(){
        session_start();
        session_destroy();
        $url = "./index.php?controller=login&method=login";  
        header('Location:' . $url);
    }
    }
?>