<?php
    class insertController{
        function insertcourse(){
            //添加课程
            //判断是不是老师=>调用视图显示=>接收数据=>放到模型中处理
            session_start();
            if(isset($_SESSION['userno'])){
                if($_SESSION['whoisit'] == 'teacher'){
                    //$_usercour传入视图打印
                    $_userInfo = M('user')->selectuser($_SESSION['userno']);//判断菜单
                    $head = V("head");
                    $_user = V("user");
                    $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                    V("titlesearch")->title_html_small("添加课程");
                    V('menu')->menu_options(M('menu')->teacherMenu());
                    V('tabs')->teachercourse(M('user')->teacherAll_statistics($_SESSION['userno']));
                    $head -> html_end();
                    //接收数据过滤传入模型
                    if(isset($_POST['submit'])){//点击确定按钮
                        if(isset($_POST['password'])){
                            //验证密码
                            if(is_array($_POST['password']))//防止MD5漏洞
                            die('<script language="javascript">  
                            alert("用户名或密码错误");  
                            window.history.back(-1);     
                            </script>');
                            $_m_login = M("login");//验证密码
                            if(strcmp($_m_login->islogin($_SESSION['userno']),md5($_POST['password']))==0){
                                //密码正确 判断字段是否都有值 并且不为空
                                if(isset($_POST['addcname'],$_POST['addchour'],$_POST['addccredit'])){
                                    if(!empty($_POST['addcname'])&&!empty($_POST['addchour'])&&!empty($_POST['addccredit'])){
                                        //判断课程名知否有注入关键字  学分和课时数字  课时包括小数  长度限制 一个不符合直接重来
                                        if(whatchour($_POST['addchour'])&&whatccredit($_POST['addccredit'])&&!whatcname($_POST['addcname'])){
                                            //调用模型添加到数据库
                                            M('insert')->insertcourse($_POST['addcname'],$_POST['addchour'],$_POST['addccredit'],$_SESSION['userno']);
                                            echo '<script language="javascript">  
                                            alert("添加成功，现在学生可以选课啦");  
                                            window.location.replace("./index.php?controller=insert&method=insertcourse")     
                                            </script>';
                                        }else{
                                            echo '<script language="javascript">  
                                            alert("输入不符合要求");  
                                            window.history.back(-1);     
                                            </script>';
                                        }
                                    }else{
                                        echo '<script language="javascript">  
                                alert("添加课程的课程号，课时，学分不能为空");  
                                window.history.back(-1);     
                                </script>';
                                    }
                                }else{
                                    echo '<script language="javascript">  
                                alert("添加课程的课程号，课时，学分不能为空");  
                                window.history.back(-1);     
                                </script>';
                                }
                            }else{
                                echo '<script language="javascript">  
                            alert("密码不正确");  
                            window.history.back(-1);     
                            </script>';
                            }
                        }else{
                            echo '<script language="javascript">  
                            alert("请输入密码");  
                            window.history.back(-1);     
                            </script>';
                        }
                    }
                }else{
                    V('error')->notFound();
                }
            }else{
                V('error')->notFound();
            }
        }
        function insertadmincourse(){
            //添加课程
            //判断是不是老师=>调用视图显示=>接收数据=>放到模型中处理
            session_start();
            if(isset($_SESSION['userno'])){
                $_userInfo = M('user')->selectuser($_SESSION['userno']);//判断菜单
                if($_userInfo["Tposit"]=="系统管理员"){
                    //$_usercour传入视图打印
                    $_allcourse = M('user')->selectallcourse();
                    $head = V("head");
                    $_user = V("user");
                    $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                    V("titlesearch")->title_html_small("添加课程");
                    V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                    V('tabs')->admincourse($_allcourse,M('user')->andminAll_statistics());
                    $head -> html_end();
                    //接收数据过滤传入模型
                    if(isset($_POST['submit'])){//点击确定按钮
                        if(isset($_POST['password'])){
                            //验证密码
                            if(is_array($_POST['password']))//防止MD5漏洞
                            die('<script language="javascript">  
                            alert("用户名或密码错误");  
                            window.history.back(-1);     
                            </script>');
                            $_m_login = M("login");//验证密码
                            if(strcmp($_m_login->islogin($_SESSION['userno']),md5($_POST['password']))==0){
                                //密码正确 判断点击的是那个按钮
                                switch ($_POST['submit']) {
                                    case '确定添加':
                                    if(isset($_POST['addcname'],$_POST['addchour'],$_POST['addccredit'])){
                                        if(!empty($_POST['addcname'])&&!empty($_POST['addchour'])&&!empty($_POST['addccredit'])){
                                            //判断课程名知否有注入关键字  学分和课时数字  课时包括小数  长度限制 一个不符合直接重来
                                            if(whatchour($_POST['addchour'])&&whatccredit($_POST['addccredit'])&&!whatcname($_POST['addcname'])){
                                                //调用模型添加到数据库
                                                M('insert')->insertcourse($_POST['addcname'],$_POST['addchour'],$_POST['addccredit'],$_SESSION['userno']);
                                                echo '<script language="javascript">  
                                                alert("添加成功，现在学生可以选课啦");  
                                                window.location.replace("./index.php?controller=insert&method=insertadmincourse")     
                                                </script>';
                                            }else{
                                                echo '<script language="javascript">  
                                                alert("输入不符合要求");  
                                                window.history.back(-1);     
                                                </script>';
                                            }
                                        }else{
                                            echo '<script language="javascript">  
                                    alert("添加课程的课程号，课时，学分不能为空");  
                                    window.history.back(-1);     
                                    </script>';
                                        }
                                    }else{
                                        echo '<script language="javascript">  
                                    alert("添加课程的课程号，课时，学分不能为空");  
                                    window.history.back(-1);     
                                    </script>';
                                    }
                                        break;
                                    case '修改课程':
                                    //获取选中行 过滤更改到数据库 $_allcourse
                                        if(isset($_POST['chcour'])){
                                            $_i = 0;
                                            if($_allcourse == ""){
                                                echo '<script language="javascript">  
                                                alert("瞎传参是没用的 本大人写的站也是你想日就能日的");  
                                                window.history.back(-1);     
                                                </script>';
                                            }else{
                                                foreach ($_allcourse as $key => $value) {//checkbox的name 和value单选
                                                    if($_POST['chcour'][$_i]=='choose'){//如果点击了单选框并且点了确定
                                                        //没课如果
                                                        //根据$value['cno'] 把$_POST['tname'][$_i],$_POST['chour'][$_i],$_POST['ccredit'][$_i],写进数据库
                                                        if(whatchour($_POST['chour'][$_i])&&whatccredit($_POST['ccredit'][$_i])&&!whatcname($_POST['cname'][$_i])){
                                                            if(!M('updateinfo')->update_course($value['cno'],$_POST['cname'][$_i],$_POST['chour'][$_i],$_POST['ccredit'][$_i])){
                                                                echo '<script language="javascript">  
                                                                    alert("课程号为'.$value['cno'].'的课程修改失败");  
                                                                    </script>';
                                                            }
                                                        }else{
                                                            echo '<script language="javascript">  
                                                                    alert("修改内容不符合要求");  
                                                                    window.location.replace("./index.php?controller=insert&method=insertadmincourse")    
                                                                    </script>';
                                                        }
                                                    }
                                                    $_i++;
                                                }
                                                echo '<script language="javascript">  
                                                                    alert("课程修改完成");  
                                                                    window.location.replace("./index.php?controller=insert&method=insertadmincourse")    
                                                                    </script>';
                                            }
                                        }
                                        break;
                                    case '删除课程':
                                    //获取选中行  输入课程号到数据库
                                    if(isset($_POST['chcour'])){
                                        $_i = 0;
                                        if($_allcourse == ""){
                                            echo '<script language="javascript">  
                                            alert("瞎传参是没用的 本大人写的站也是你想日就能日的");  
                                            window.history.back(-1);     
                                            </script>';
                                        }else{
                                            foreach ($_allcourse as $key => $value) {//checkbox的name 和value单选
                                                if($_POST['chcour'][$_i]=='choose'){//如果点击了单选框并且点了确定
                                                    //调用删除模型删除当前课程号的课程$value['cno']
                                                    if($value['snum']==0){
                                                        if(!M('delete')->delete_course($value['cno']))
                                                            echo '<script language="javascript">  
                                                                alert("课程号为'.$value['cno'].'的课程删除失败");  
                                                                </script>';
                                                    }else{
                                                        echo '<script language="javascript">  
                                                                alert("课程号为'.$value['cno'].'的课程还有学生在学习，清楚课程选课记录才可以删除");  
                                                                </script>';
                                                    }
                                                }
                                                $_i++;
                                            }
                                            echo '<script language="javascript">  
                                                                alert("课程修改完成");  
                                                                window.location.replace("./index.php?controller=insert&method=insertadmincourse")    
                                                                </script>';
                                        }
                                    }
                                        break;
                                    default:
                                    echo '<script language="javascript">  
                                alert("瞎传参是没用的 本大人写的站也是你想日就能日的");  
                                window.history.back(-1);     
                                </script>';
                                        break;
                                }
                                
                            }else{
                                echo '<script language="javascript">  
                            alert("密码不正确");  
                            window.history.back(-1);     
                            </script>';
                            }
                        }else{
                            echo '<script language="javascript">  
                            alert("请输入密码");  
                            window.history.back(-1);     
                            </script>';
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