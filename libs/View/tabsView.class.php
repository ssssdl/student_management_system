<?php
    class tabsView{
        function admincourse($_allcourse,$_a){
            //管理员管理课程
            echo '
    <div class="typrography">
	 <div class="container"><div class="grid_3 grid_5">
    <h3 class="bars">Tabs</h3>
      <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
<ul id="myTab" class="nav nav-tabs" role="tablist">
 <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">添加个人课程</a></li>
 <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">管理全部课程</a></li>
 <li role="presentation" class=""><a href="#allscou" id="all-sc" role="tab" data-toggle="tab" aria-controls="myTabDrop1-contents" aria-expanded="false">查看学生学习情况</a></li>
</ul>
<div id="myTabContent" class="tab-content">
 <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
   ';
   V('insert')->insert_course("admin");
   echo '
 </div>
 <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">';
            V('showcourse')->admincourse($_allcourse);//这里传入课程查询结果
            echo' </div>
            <div role="tabpanel" class="tab-pane fade" id="allscou" aria-labelledby="profile-tab">';
            V('bars')->showmorebar($_a);
echo' </div>
</div>
</div>
</div>
</div>
</div>
<script src="js/bootstrap.js"></script>';
        } 
        function adminstucour($_allstudent,$_allteacher,$_allstucou,$tongji){
            //管理员管理所有用户
            echo '
    <div class="typrography">
	 <div class="container"><div class="grid_3 grid_5"><!-- 这里加上面的表格显示学生基本信息感觉这个可以拆出一个视图引擎来 -->
    <h3 class="bars">Tabs</h3>
      <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
<ul id="myTab" class="nav nav-tabs" role="tablist">
 <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">学生管理</a></li>
 <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">职工管理</a></li>
 <li role="presentation" class=""><a href="#allscou" id="all-sc" role="tab" data-toggle="tab" aria-controls="myTabDrop1-contents" aria-expanded="false">选课记录管理</a></li>
</ul>
<div id="myTabContent" class="tab-content">
 <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
   ';
   V('showcourse')->adminallstudent($_allstudent,$tongji);
   echo '
 </div>
 <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">';  
 V('showcourse')->adminallteacher($_allteacher);
echo' </div>
<div role="tabpanel" class="tab-pane fade" id="allscou" aria-labelledby="profile-tab">';
V('showcourse')->adminallstucour($_allstucou);
echo' </div>
</div>
</div>
</div>
</div>
</div>
<script src="js/bootstrap.js"></script>';
        }
        function teachercourse($_allcourse){//输入统计结果$_allcourse
          echo '
  <div class="typrography">
 <div class="container"><div class="grid_3 grid_5">
  <h3 class="bars">Tabs</h3>
    <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
<ul id="myTab" class="nav nav-tabs" role="tablist">
<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">添加个人课程</a></li>
<li role="presentation" class=""><a href="#allscou" id="all-sc" role="tab" data-toggle="tab" aria-controls="myTabDrop1-contents" aria-expanded="false">查看学生学习情况</a></li>
</ul>
<div id="myTabContent" class="tab-content">
<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
 ';
 V('insert')->insert_course("teacher");
 echo' </div>
          <div role="tabpanel" class="tab-pane fade" id="allscou" aria-labelledby="profile-tab">';
          V('bars')->showmorebar($_allcourse);
echo' </div>
</div>
</div>
</div>
</div>
</div>
<script src="js/bootstrap.js"></script>';
      } 
    }
?>