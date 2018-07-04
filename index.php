<?php

    /**5.1 功能要求：
      *⑴ 学生注册登记：提供给系统最基本的学籍信息。
      *⑵ 学生成绩登记：按专业分类，以年级为单位，登记学生在校期间每门课程的成绩。
      *⑶ 学籍更改登记：包括简历更改、成绩更改、休复转退学登记、奖惩登记。
      *⑷ 资料统计：统计各专业某年计某学期的学习成绩情况。以考试为例，分作90～100分，80～89分，70～79分，
      *  60～69分，60分以下五档人数及占总人数的百分率。按照学生的年龄大小、地区的来源、政治面貌作人数的统计。统计年年龄小于20  统计 共产党员  统计少数民族
      *⑸ 个人情况查询：查询成绩、简历、休复转退学及奖惩情况。
      *5.2 数据要求：
      *简历数据：学号、姓名、性别、学制、地区、年龄、政治面貌、民族、奖惩记录、休复转退标记
      */
    //入口文件
    //程序入口接受控制器消息
    //url形式  index.php?controller=控制器名&method=方法名
    //控制器的作用是调用模型,并调用视图.将模型产生的数据传递给视图.并让相关视图去显示
    //模型的作用是获取数据并处理、返回数据
    //视图的作用是将取得的数据进行组织、美化等，并最终向用户终端输出
    //网页在视图层

    //包含文件
    require_once('/function/function.php');
    require_once('/function/waf.php');

    //定义允许访问的控制器名 和方法名   ####这个比较重要应该设置一个控制器只能访问当前控制器下的方法
    $controllerAllow = array('login','index','update','insert','user');  //只实现login
    $metholAllow = array('login','index','unlogin','userinfo','updateinfo','searchadmin','selectcourse','entryscore','choosecour','insertcourse','insertadmincourse','adminuser');   

    //接收get数据  daddslashes转义  没设置的话默认是login
    $controller = isset($_GET['controller'])?(in_array($_GET['controller'],$controllerAllow)?daddslashes($_GET['controller']):'login'):'login';//先判断是否获取到参数 然后判断是否在定义的数组里面 daddslashes是一个实例化的函数
    $method = isset($_GET['method'])?(in_array($_GET['method'],$metholAllow)?daddslashes($_GET['method']):'login'):'login';
    C($controller,$method);
?>