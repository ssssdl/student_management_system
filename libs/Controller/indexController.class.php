<?php
    class indexController{
        function index(){
            session_start();
            if(isset($_SESSION['userno'])){
                $_userInfo = M('user')->selectuser($_SESSION['userno']);//变量传给视图显示
                //这里要把权限分开
                $head = V("head");
                $_user = V("user");
                $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                if(isset($_userInfo["Tposit"])){//显示菜单
                    if($_userInfo["Tposit"]=="系统管理员")
                        V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                    else
                        V('menu')->menu_options(M('menu')->teacherMenu());
                }else{
                    V('menu')->menu_options(M('menu')->studentMenu());
                }
                $_user -> showuserhello($_userInfo);
                $head -> html_end();
            }else{
                //调用视图notfound
                V('error')->notFound();
            }
        }
        function userinfo(){
            session_start();
            if(isset($_SESSION['userno'])){
                $_userInfo = M('user')->selectuser($_SESSION['userno']);//变量传给视图显示
                //这里要把权限分开
                $head = V("head");
                $_user = V("user");
                $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                if(isset($_userInfo["Tposit"])){//显示菜单
                    if($_userInfo["Tposit"]=="系统管理员")
                        V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                    else
                        V('menu')->menu_options(M('menu')->teacherMenu());
                }else{
                    V('menu')->menu_options(M('menu')->studentMenu());
                    $_userInfo = array_merge($_userInfo,M('user')->selectBasic_results($_SESSION['userno']));
                }
                $_user -> showuserinfo($_userInfo);//这个界面切换  后面还可以加一个学分  总共修的课程数  优秀课程数  绩点等
                $head -> html_end();
            }else{
                //调用视图notfound
                V('error')->notFound();
            }
        }
        function searchadmin(){
            session_start();
            if(isset($_SESSION['userno'])){
                $_userInfo = M('user')->selectuser($_SESSION['userno']);//变量传给视图显示
                if(isset($_userInfo["Tposit"])){//显示菜单
                    if($_userInfo["Tposit"]=="系统管理员"){
                        //这里要把权限分开
                        $head = V("head");
                        $_user = V("user");
                        $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                        V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                        //来个搜索框
                        
                        if(isset($_POST['search'])){
                            if(nochar($_POST['search'])&&howLeng($_POST['search'])){
                                $_searchInfo = M('user')->selectuser($_POST['search']);
                                if(strlen($_POST['search']) == 10)
                                    $_searchInfo = array_merge($_searchInfo,M('user')->selectBasic_results($_POST['search']));
                                $_user -> showuserinfo($_searchInfo);
                            }else
                                V("titlesearch")->title_html_small("搜索用户");
                        }else
                            V("titlesearch")->title_html_small("搜索用户");
                        $_user -> search();
                        $head -> html_end();
                        
                    }else{
                        V('error')->notFound();
                    }
                }else{
                    V('error')->notFound();
                }
            }else{
                V('error')->notFound();
            }
        }
        function selectcourse(){//查询成绩  如果是学生的话就查询所有课程的成绩  如果是老师就查询老师所有课的成绩
            session_start();
            if(isset($_SESSION['userno'])){
                //直接把$_SESSION['userno']传入模型 （返回课程名  学生姓名  成绩）学生的话就显示课程名  成绩  老师的话就是  课程  学生名  成绩   学生的话按学号分组  老师的话按课程号分组
                $_usercour = M('user')->selectcourse($_SESSION['userno']);
                $_userInfo = M('user')->selectuser($_SESSION['userno']);//变量传给视图显示
                if($_usercour == ""){
                    echo '<script language="javascript">  
                    alert("你没有课程记录");  
                    window.history.back(-1);     
                    </script>  ';
                }else{
                    //$_usercour传入视图打印
                    $head = V("head");
                    $_user = V("user");
                    $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                    V("titlesearch")->title_html_small("学籍管理系统");
                    if(isset($_userInfo["Tposit"])){//显示菜单
                        if($_userInfo["Tposit"]=="系统管理员")
                            V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                        else
                            V('menu')->menu_options(M('menu')->teacherMenu());
                        V('showcourse')->teachercourse($_usercour);
                    }else{
                        V('menu')->menu_options(M('menu')->studentMenu());
                        //学生在这里 $_usercour传入视图打印
                        V('showcourse')->studentcourse($_usercour);
                    }
                    $head -> html_end();
                }
            }else{
                //调用视图notfound
                V('error')->notFound();
            }
        }
        function entryscore(){
            //录入学生成绩
            session_start();
            if(isset($_SESSION['userno'])){
                if($_SESSION['whoisit'] == 'teacher'){//提前判断身份 避免多余查询  添加课程的时候也要这么做
                    $_usercour = M('user')->selectnograde($_SESSION['userno']);//查询当前用户课程
                    $_userInfo = M('user')->selectuser($_SESSION['userno']);//查询当前用户信息
                    if($_usercour == ""){
                        echo '<script language="javascript">  
                        alert("你的已有课程成绩录入完成");  
                        window.location.replace("./index.php?controller=index&method=index")     
                        </script>  ';
                    }else{
                        $head = V("head");
                        $_user = V("user");
                        $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                        V("titlesearch")->title_html_small("录入课程成绩");
                        if($_userInfo["Tposit"]=="系统管理员") //老师和管理员的菜单是不同的
                            V('menu')->menu_options(M('menu')->adminMenu());//可以添加学生
                        else
                            V('menu')->menu_options(M('menu')->teacherMenu());
                        V('showcourse')->entrycourse($_usercour);//这里将课程信息传入视图显示
                        $head -> html_end();
                        //接收参数
                        if(isset($_POST['password'])){//验证密码
                            if(is_array($_POST['password']))//防止MD5漏洞
                                die('<script language="javascript">  
                                alert("用户名或密码错误");  
                                window.history.back(-1);     
                                </script>');
                            $_m_login = M("login");//验证密码
                            if(strcmp($_m_login->islogin($_SESSION['userno']),md5($_POST['password']))==0){
                                if(isset($_POST['grade'])){
                                    //可以通过 $_POST['grade'][0] 处理接收到的参数  
                                    $_i = 0;
                                    $_upg = M('updateinfo');
                                    foreach ($_usercour as $key => $value) {
                                        //当$_POST['grade'][$_i]不为空时  将 $value['sno'] $value['cno'] $_POST['grade'][$_i]传入模型 不对  姓名和课程号不是唯一确定这个学生的
                                        if(!empty($_POST['grade'][$_i])){
                                            //echo whatage($_POST['grade'][$_i]).$_POST['grade'][$_i].'<br>';
                                            if(!whatage($_POST['grade'][$_i])){
                                                //echo $_i.$_POST['grade'][$_i].'<br>';
                                                //如果分数中含有字母或者长度不符合要求就直接跳过
                                                echo '<script language="javascript">  
                                                alert("学号：'.$value['sno'].'课程号：'.$value['cno'].'的成绩修改失败1");</script>';
                                                continue;
                                            }
                                            if(!$_upg->update_grade($value['sno'],$value['cno'],$_POST['grade'][$_i]))
                                                echo '<script language="javascript">  
                                                alert("学号：'.$value['sno'].'课程号：'.$value['cno'].'的成绩修改失败");</script>';
                                            }
                                        $_i++;
                                    }
                                    echo '<script language="javascript">  
                                    alert("更新成绩完成");
                                    window.location.replace("./index.php?controller=index&method=entryscore")
                                </script>  ';
                                }else{//其实没课是不可能进入这里的
                                    echo '<script language="javascriptz">  
                                    alert("你没有课哦");  
                                    window.history.back(-1);     
                                    </script>  ';
                                }
                            }else{
                                echo '<script language="javascript">  
                                alert("密码错误");  
                                window.history.back(-1);     
                                </script>  ';
                            }
                        }
                    }
                }else{
                    //学生不可以访问这个界面
                    V('error')->notFound();
                }
            }else{
                //如果没有登陆直接访问这个页面
                V('error')->notFound();
            }
        }
        function choosecour(){
            //学生选课模块
            session_start();
            if(isset($_SESSION['userno'])){
                if($_SESSION['whoisit'] == 'student'){
                    //只有学生才可以访问
                    //输入学号到模型 获取没有当前学生没有选的课程 模型user 方法selectchcourse
                    $_chcour = M('user') -> selectchcourse($_SESSION['userno']);
                    if($_chcour == ""){
                        echo '<script language="javascript">  
                        alert("你没课可选");  
                        window.location.replace("./index.php?controller=index&method=index")     
                        </script>  ';
                    }else{
                        //传入视图显示
                        $head = V("head");
                        $_user = V("user");
                        $head -> html_head('学生学籍管理系统','学生学籍管理系统');
                        V("titlesearch")->title_html_small("选课系统");
                        V('menu')->menu_options(M('menu')->studentMenu());
                        V('showcourse')->choosecourse($_chcour);
                        $head -> html_end();
                        //接收数据  验证密码->根据提交数组中的是否有choose 把课程名 学号
                        if(isset($_POST['password'])){
                            if(is_array($_POST['password']))//防止MD5漏洞
                                die('<script language="javascript">  
                                alert("用户名或密码错误");  
                                window.history.back(-1);     
                                </script>');
                            $_m_login = M("login");//验证密码
                            if(strcmp($_m_login->islogin($_SESSION['userno']),md5($_POST['password']))==0){
                                //处理接收到的数组
                                if(isset($_POST['chcour'])){
                                    //可以通过 $_POST['chcour'][0]
                                    $_i = 0;//按课程号输出的顺序 判断是否选择了此课程
                                    $_ins = M('insert');
                                    foreach ($_chcour as $key => $value) {//checkbox的name 和value单选
                                        if($_POST['chcour'][$_i]=='choose'){
                                            //将 $_SESSION['userno'] $value['cno'] 添加到stu_cour表 成功继续下一个  失败显示选$value['cname']失败insertstu_cour
                                            if(!$_ins->insertstu_cour($_SESSION['userno'],$value['cno']))
                                                echo '<script language="javascript">  
                                                alert("课程：'.$value['cname'].' 选课失败");</script>';
                                        }
                                        $_i++;
                                } 
                                echo '<script language="javascript">  
                                    alert("选课成功");
                                    window.location.replace("./index.php?controller=index&method=choosecour")   
                                </script>  ';
                            }else{
                                //没课输密码
                                echo '<script language="javascriptz">  
                                    alert("选了所有课不去上还在这输密码玩？？");  
                                    window.history.back(-1);     
                                    </script>  ';
                            }
                        }else{
                            echo '<script language="javascript">  
                                alert("密码错误,选课失败");  
                                window.history.back(-1);     
                                </script>  ';
                        }
                    }
                }
                }else{
                    V('error')->notFound();//老师和管理都访问不了
                }
            }else{
                V('error')->notFound();//没session的话访问不了的
            }
        }
        
    }
?>