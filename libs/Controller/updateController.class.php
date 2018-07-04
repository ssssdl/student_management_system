<?php
    class updateController{
        function updateinfo(){
            session_start();
            if(isset($_SESSION['userno'])){
                $_userInfo = M('user')->selectuser($_SESSION['userno']);//变量传给视图显示
                //调用视图显示   接收传输参数   根据这$_SESSION['whoisit'] $_SESSION['userno']判断修改的参数是否权限足够，并对参数进行过滤或者实例化
                $head = V("head");
                $_user = V("user");
                $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                V("titlesearch")->title_html_small("学籍管理系统");
                if(isset($_userInfo["Tposit"])){//显示菜单
                    if($_userInfo["Tposit"]=="系统管理员"){
                        V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                        V('update')->adminupdate($_userInfo);
                    }
                    else{
                        V('menu')->menu_options(M('menu')->teacherMenu());
                        V('update')->stu_teaupdate($_userInfo);
                    }
                }else{
                    V('menu')->menu_options(M('menu')->studentMenu());
                    $_userInfo['Ttele'] = $_userInfo['Stele'];
                    V('update')->stu_teaupdate($_userInfo);
                }
                $head -> html_end();
                //接收数据过滤  传入模型  
                /* 管理员个人信息全都可以修改
                 * 教师和学生只能改密码电话
                 */
                if(isset($_POST['submit'])&&$_POST['submit']=='确定修改'){
                    //判断身份 根据身份获取信息 用登陆模型判断密码是否正确  提交模型修改数据库 否则返回修改失败
                    if(isset($_POST['password'])){
                        if(is_array($_POST['password']))//防止MD5漏洞
                            die('<script language="javascript">  
                            alert("用户名或密码错误");  
                            window.history.back(-1);     
                        </script>');
                        $_m_login = M("login");//验证密码
                        if(strcmp($_m_login->islogin($_SESSION['userno']),md5($_POST['password']))==0){ //密码验证正确
                            //判断是否修改密码
                            if(isset($_POST['newpass'])&&isset($_POST['repass'])){
                                if(!empty($_POST['newpass'])&&!empty($_POST['repass'])){
                                if(is_array($_POST['newpass'])||is_array($_POST['repass']))//防止MD5漏洞 
                                    die('<script language="javascript">  
                                    alert("两次密码不一致");  
                                    window.history.back(-1);     
                                    </script>');
                                if(strcmp($_POST['newpass'],$_POST['repass'])==0){
                                    $_pass['pass'] = md5($_POST['newpass']);
                                    $_pass['uno'] = $_SESSION['userno'];
                                    //调用模型更新
                                    M("updateinfo")->update_pass($_pass);
                                }else{
                                    echo '<script language="javascript">  
                                                alert("两次密码输入不相同");  
                                                window.history.back(-1);     
                                                </script>  ';
                                }
                            }
                            }
                            if(isset($_userInfo["Tposit"])){
                                if($_userInfo["Tposit"]=="系统管理员"){
                                    //管理员//管理员全部信息都获取 放入数组
                                    //判断所有字段不为空 过滤  输入update
                                    //Tname Tsex Tage tpolitical ttele
                                    if(isset($_POST['tname'],$_POST['tsex'],$_POST['tage'],$_POST['tpolitical'],$_POST['ttele'])){//判断是否定义
                                        //判断全都不为空
                                        if(!empty($_POST['tname'])&&!empty($_POST['tsex'])&&!empty($_POST['tage'])&&!empty($_POST['tpolitical'])&&!empty($_POST['ttele'])){
                                            //过滤  姓名只能是汉字  性别只能是男女  年龄只能是数字0-100  政治面貌只能是群众  共青团员  党员  电话只能是数字和横杠  每个长度也加判断
                                            if(whatname($_POST['tname'])&&whatsex($_POST['tsex'])&&whatage($_POST['tage'])&&whatpolitical($_POST['tpolitical'])&&whattele($_POST['ttele'])){
                                                //全部正确提交模型修改数据库
                                                $_info['tno'] = $_SESSION['userno'];
                                                $_info['tname'] = $_POST['tname'];
                                                $_info['tsex'] = $_POST['tsex'];
                                                $_info['tage'] = $_POST['tage'];
                                                $_info['tpolitical'] = $_POST['tpolitical'];
                                                $_info['ttele'] = $_POST['ttele'];
                                                M("updateinfo")->update_admininfo($_info);
                                            }else{
                                                echo '<script language="javascript">  
                                                alert("格式不正确");  
                                                window.history.back(-1);     
                                                </script>  ';
                                            }
                                        }
                                        else
                                            echo '<script language="javascript">  
                                            alert("信息不全，修改失败");  
                                            window.history.back(-1);     
                                            </script>  ';
                                    }else{
                                        echo '<script language="javascript">  
                                        alert("信息不全，修改失败");  
                                        window.history.back(-1);     
                                        </script>  ';
                                    }
                                }
                                else{
                                    //老师//基础用户只获取电话
                                    if(isset($_POST['Stele']))
                                        if(!empty($_POST['Stele'])){
                                            if(whattele($_POST['Stele'])){
                                                $_info['uno'] = $_SESSION['userno'];
                                                $_info['tele'] = $_POST['Stele'];
                                                //调用模型M("updateinfo")->update_admininfo($_info);
                                                M("updateinfo")->update_tele($_info);
                                            }else{
                                                echo '<script language="javascript">  
                                                alert("格式不正确");  
                                                window.history.back(-1);     
                                                </script>  ';
                                            }
                                        }else{
                                            echo '<script language="javascript">  
                                            alert("密码不能为空");  
                                            window.history.back(-1);     
                                            </script>  ';
                                        }
                                }
                            }else{
                                //学生//基础用户只获取电话
                                if(isset($_POST['Stele']))
                                        if(!empty($_POST['Stele'])){
                                            if(whattele($_POST['Stele'])){
                                                $_info['uno'] = $_SESSION['userno'];
                                                $_info['tele'] = $_POST['Stele'];
                                                //调用模型M("updateinfo")->update_admininfo($_info);
                                                M("updateinfo")->update_tele($_info);
                                            }else{
                                                echo '<script language="javascript">  
                                                alert("格式不正确");  
                                                window.history.back(-1);     
                                                </script>  ';
                                            }
                                        }else{
                                            echo '<script language="javascript">  
                                            alert("密码不能为空");  
                                            window.history.back(-1);     
                                            </script>  ';
                                        }
                            }
                        }else{
                            //提示密码错误 返回当前页
                            echo '<script language="javascript">  
                            alert("密码错误修改失败");  
                            window.history.back(-1);     
                            </script>  ';
                        }
                    }
                    else{
                        echo '<script language="javascript">  
                            alert("密码错误修改失败");  
                            window.history.back(-1);     
                            </script>  ';
                    }
                }
            }else{
                //调用视图notfound
                V('error')->notFound();
            }
        }
    }
?>