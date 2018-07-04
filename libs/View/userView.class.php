<?php
    class userView{
        function search(){
            //搜索框
            echo '
            <h3 class="tittle">搜索</h3>
             
            <div class="typrography">
	 <div class="container">
            <div class="col-lg-6 in-gp-tb">
            <p>输入学号或者工号查询</p>
            <div class="input-group">
            <form method="post" action="#">
              <input type="text" style="width:1000px" name="search" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit" value="search">Go!</button>
              </span>
              </from>
              </div>
              </div></div>
              </div><br><br>';
        }
        function showuserhello($userinfo){
            V("titlesearch")->title_html_small("学籍管理系统");//这里其实可以用哪个题目写
            if(isset($userinfo["Tposit"])){//显示菜单
                //echo '<h1 style="font-size:100px">hello'.$userinfo["Tname"].'</h1>';
                if($userinfo["Tposit"]=="系统管理员")
                    V('question')->question(M('menu')->adminMenu(),'Hello! '.$userinfo["Tname"],"你可以......");//可以添加学生
                else
                    V('question')->question(M('menu')->teacherMenu(),'Hello! '.$userinfo["Tname"],"你可以......");
            }else{
                //echo '<h1 style="font-size:100px">hello'.$userinfo["Sname"].'</h1>';
                V('question')->question(M('menu')->studentMenu(),'Hello! '.$userinfo["Sname"],"你可以......");
            }
        }
        function showuserinfo($userinfo){
            V("titlesearch")->title_html_small("学籍管理系统");
            echo '
            <div class="typrography">
	 <div class="container">
	      <h3 class="tittle">个人信息</h3>
            <div class="grid_3 grid_5">
            <h3 class="bars"></h3>
               <div class="col-md-6">
                   <p>右侧菜单修改个人信息.</p>
                     <table class="table table-bordered">
                       <thead>
                           <tr>
                               <th>信息</th>
                               <th>内容</th>
                           </tr>
                       </thead>
                       <tbody> ';
                           /*<tr><!--<span>标签可以后期做提示用-->
                               <td>No modifiers</td>
                               <td><span class="badge">42</span></td>
                           </tr>
                           <tr>
                               <td><code>.badge-primary</code></td>
                               <td><span class="badge badge-primary">1</span></td>
                           </tr>
                           <tr>
                               <td><code>.badge-success</code></td>
                               <td><span class="badge badge-success">22</span></td>
                           </tr>
                           <tr>
                               <td><code>.badge-info</code></td>
                               <td>1233<span class="badge badge-info">30</span></td>
                           </tr>
                           <tr>
                               <td><code>.badge-warning</code></td>
                               <td><span class="badge badge-warning">412</span></td>
                           </tr>
                           <tr>
                               <td><code>.badge-danger</code></td>
                               <td><span class="badge badge-danger">999</span></td>
                           </tr>*/
                           //防xss过滤函数htmlentities();
                if(isset($userinfo["Tposit"])){//打印教师信息  Tno      | Tname  | Tsex | Tage | Tposit     | Tpolitical | Ttele
                    echo '<tr>
                            <td>职工号</td>
                            <td>'.htmlentities($userinfo["Tno"]).'</td>
                        </tr>
                        <tr>
                            <td>姓名</td>
                            <td>'.htmlentities($userinfo["Tname"]).'</td>
                        </tr>
                        <tr>
                        <td>性别</td>
                        <td>'.htmlentities($userinfo["Tsex"]).'</td>
                        </tr>
                        <tr>
                        <td>年龄</td>
                        <td>'.htmlentities($userinfo["Tage"]).'</td>
                        </tr>
                        <tr>
                        <td>职务</td>
                        <td>'.htmlentities($userinfo["Tposit"]).'</td>
                        </tr>
                        <tr>
                        <td>政治面貌</td>
                        <td>'.htmlentities($userinfo["Tpolitical"]).'</td>
                        </tr>
                        <tr>
                        <td>电话</td>
                        <td>'.htmlentities($userinfo["Ttele"]).'</td>
                        </tr>
                        </tbody>
                     </table> </div>  
                     </div>';
                }else{// Sno        | Sname  | Ssex | Sage | Sarea                  | Seducational | Spolitical | Snation | Sleave | Sreward      | Stele
                    echo '<tr>
                    <td>学号</td>
                    <td>'.htmlentities($userinfo["Sno"]).'</td>
                </tr>
                <tr>
                    <td>姓名</td>
                    <td>'.htmlentities($userinfo["Sname"]).'</td>
                </tr>
                <tr>
                <td>性别</td>
                <td>'.htmlentities($userinfo["Ssex"]).'</td>
                </tr>
                <tr>
                <td>年龄</td>
                <td>'.htmlentities($userinfo["Sage"]).'</td>
                </tr>
                <tr>
                <td>家庭住址</td>
                <td>'.htmlentities($userinfo["Sarea"]).'</td>
                </tr>
                <tr>
                <td>学制</td>
                <td>'.htmlentities($userinfo["Seducational"]).'</td>
                </tr>
                <tr>
                <td>政治面貌</td>
                <td>'.htmlentities($userinfo["Spolitical"]).'</td>
                </tr>
                <tr>
                <td>民族</td>
                <td>'.htmlentities($userinfo["Snation"]).'</td>
                </tr>
                <tr>
                <td>休复转退</td>
                <td>'.htmlentities($userinfo["Sleave"]).'</td>
                </tr>
                <tr>
                <td>奖惩记录</td>
                <td>'.htmlentities($userinfo["Sreward"]).'</td>
                </tr>
                <tr>
                <td>电话</td>
                <td>'.htmlentities($userinfo["Stele"]).'</td>
                </tr></tbody>
                     </table>   
                     </div>
                <div class="col-md-6">
				  <p> 基本学习进度 </p>
					<div class="list-group list-group-alternate"> 
						<a class="list-group-item"><span class="badge">'.htmlentities($userinfo["credit"]).'</span> <i class="ti ti-email"></i> 学分 </a> 
						<a class="list-group-item"><span class="badge badge-primary">'.htmlentities($userinfo["coucourse"]).'</span> <i class="ti ti-eye"></i> 总共修课程数 </a> 
						<a class="list-group-item"><span class="badge">'.htmlentities($userinfo["Pcourse"]).'</span> <i class="ti ti-headphone-alt"></i> 及格以上课程数 </a> 
						<a class="list-group-item"><span class="badge">'.htmlentities($userinfo["fcourse"]).'</span> <i class="ti ti-comments"></i> 优秀课程数 </a> 
						<!-- <a class="list-group-item"><span class="badge badge-warning">14</span> <i class="ti ti-bookmark"></i> Bookmarks </a> 
						<a class="list-group-item"><span class="badge badge-danger">30</span> <i class="ti ti-bell"></i> Notifications </a> -->
					</div>
               </div>
               <div class="clearfix"> </div>
               </div>
                ';//<a href="#" class="list-group-item"><span class="badge badge-danger">30</span> <i class="ti ti-bell"></i> Notifications </a>  可以接跳转具体分析
                }// //学分credit  总共修的课程数coucourse  及格以上课程数Pcourse  优秀课程数fcourse  绩点
                        echo '
               </div>';
        }
    }
?>