<?php
    class showcourseView{
        function studentcourse($_info){
            echo '
            <div class="typrography">
	            <div class="container">
            <h3 class="tittle">成绩查询</h3>
            <p> 按选课时间输出你的成绩 </p>
            <section id="tables">
            <div class="bs-docs-example">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>教师</th>
                  <th>课程名</th>
                  <th>成绩</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
            foreach ($_info as $key => $value) {
                echo '<tr>
                  <td>'.htmlentities($_i).'</td>
                  <td>'.htmlentities($value['tname']).'</td>
                  <td>'.htmlentities($value['cname']).'</td>
                  <td>'.htmlentities($value['grade']).'</td>
                </tr>';
                $_i++;
				//echo $value['sname']." ".$value['tname']." ".$value['cname']." ".$value['grade'];
            }
            echo '</tbody>
            </table>
          </div>
          </section>
          </div></div>';
        }
        function teachercourse($_info){
            echo '
            <div class="typrography">
	            <div class="container">
            <h3 class="tittle">成绩查询</h3>
            <p> 按选课时间输出你的成绩 </p>
            <section id="tables">
            <div class="bs-docs-example">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>学生</th>
                  <th>课程</th>
                  <th>成绩</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
            foreach ($_info as $key => $value) {
                echo '<tr>
                  <td>'.htmlentities($_i).'</td>
                  <td>'.htmlentities($value['sname']).'</td>
                  <td>'.htmlentities($value['cname']).'</td>
                  <td>'.htmlentities($value['grade']).'</td>
                </tr>';
                $_i++;
				//echo $value['sname']." ".$value['tname']." ".$value['cname']." ".$value['grade'];
            }
            echo '</tbody>
            </table>
          </div>
          </section>
          </div></div>';
        }
        function entrycourse($_cour){
            //这个是给学生打分的  显示当前老师下，学生成绩为空的课程，提交的时候 按顺序提交 成绩，教师密码
            echo '
            <div class="typrography">
	            <div class="container">
            <h3 class="tittle">录入成绩</h3>
            <p> 按选课时间输出成绩为空的课程 必须输入密码才可以修改成绩 注意成绩录入后不可修改 急需修改请联系系统管理员  </p>
            <section id="tables">
            <div class="bs-docs-example">
			<form action="#" method="post">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>学生</th>
                  <th>课程</th>
                  <th>成绩</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
              foreach ($_cour as $key => $value) {
                echo '<tr>
                  <td>'.htmlentities($_i).'</td>
                  <td>'.htmlentities($value['sname']).'('.htmlentities($value['sno']).')</td>
                  <td>'.htmlentities($value['cname']).'('.htmlentities($value['cno']).')</td>
                  <td><input type="text" Name="grade['.$_i.']" maxlength="3" placeholder="成绩(1-100)" onkeyup="this.value=this.value.replace(/\D/g,\'\')"></td>
                </tr>';
                $_i++;
            }
                echo'
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <br>
          <h3>输入密码确认录入成绩 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
          <input name="submit" type="submit" value="确定修改"><br>
            </form>
		</div></div>
          ';
        }
        function choosecourse($_cour){
          //显示未被当前学生选择的课程
          echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">选择课程</h3>
        <p> 选课完成后输入密码提交确定选课  </p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>课程</th><!-- 包括课程号 -->
                  <th>教师</th>
                  <th>学分</th>
                  <th>学时</th>
                </tr>
              </thead>
              <tbody>';
              //输出没有被此学生选的课程名
              $_i = 0;//按课程号输出的顺序 判断是否选择了此课程
              foreach ($_cour as $key => $value) {//checkbox的name 和value单选
                //cname,cno,tname,Chour,ccredit
                echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chcour['.$_i.']" value="choose"></td>
                  <td>'.htmlentities($value['cname']).'('.htmlentities($value['cno']).')</td>
                  <td>'.htmlentities($value['tname']).'</td>
                  <td>'.htmlentities($value['ccredit']).'</td>
                  <td>'.htmlentities($value['chour']).'</td>
                </tr>';
                $_i++;
            } 
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <br>
          <h3>输入密码确认选课 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
          <input name="submit" type="submit" value="确定选课"><br>
            </form>
		</div></div>';
        }
        function admincourse($_cour){
          //管理员修改查看所有选择的课程
          //课程名(可修改)cname  课程号cno  课程老师(tname tno)  课时(可修改)chour  学分(可修改)ccredit 选课人数count(sno)snum  
          if($_cour==""){
            echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">选择课程</h3>
        <p> 系统中还没有课程哦 </p></div></div>';
          }else{
          echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">选择课程</h3>
        <p> 选中复选框才有效哦 修改课程名的话只需填入新的课程名提交即可  不必写课程号 </p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>课程名</th>
                  <th>课程号</th>
                  <th>教师</th>
                  <th>学分</th>
                  <th>学时</th>
                  <th>选课人数</th>
                </tr>
              </thead>
              <tbody>';
              //输出没有被此学生选的课程名
              $_i = 0;//按课程号输出的顺序 判断是否选择了此课程
              foreach ($_cour as $key => $value) {//checkbox的name 和value单选
                //cname,cno,tname,Chour,ccredit  这里可以修改的改成文本框<input type="text" Name="tname" value="'.htmlentities($adminInfo['Tname']).'" required>
                echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chcour['.$_i.']" value="choose"></td>
                  <td><input type="text" Name="cname['.$_i.']" value="'.htmlentities($value['cname']).'" required></td>
                  <td>'.htmlentities($value['cno']).'</td>
                  <td>'.htmlentities($value['tname']).'('.htmlentities($value['tno']).')</td>
                  <td><input type="text" Name="ccredit['.$_i.']" value="'.htmlentities($value['ccredit']).'" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')" required></td>
                  <td><input type="text" Name="chour['.$_i.']" value="'.htmlentities($value['chour']).'" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')" required></td>
                  <td>'.htmlentities($value['snum']).'</td>
                </tr>';
                $_i++;
            } 
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <br>
          <h3>输入密码确认调整 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
          <input name="submit" type="submit" value="修改课程"><a>  or  </a><input name="submit" type="submit" value="删除课程"><br>
            </form>
    </div></div>';
  }
        }
        function adminallstudent($_student,$tongji){
          //管理员查看所有学生
          /**
          提交的信息
          submit 添加学生
          chstu[i] 选中学号
          morestu[i] 修改更多
          passwordstu 密码
          submit 删除学籍
           */
          if($_student==""){
            echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">管理学生</h3>
        <p>两行一个用户   删除添加修改选中复选框才有效 不改密码的话密码空着</p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>学号</th>
                  <th>姓名</th>
                  <th>性别</th>
                  <th>年龄</th>
                  <th>地区</th>
                  <th>学制</th></tr><tr>
                  <th>学分</th>
                  <th>民族</th>
                  <th>休复转退</th>
                  <th>奖惩记录</th>
                  <th>电话</th>
                  <th>密码</th>
                  <th>政治面貌</th>
                </tr>
              </thead>
              <tbody><tr>
              ';
              $_i=0;
              echo '
                  <td><input type="checkbox" aria-label="..." name="chstu['.$_i.']" value="choose"></td>
                  <td>2016083101</td>
                  <td><input type="text" style="width:60px" Name="sname['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="ssex['.$_i.']" value=""></td>
                  <td><input type="text" style="width:100px" Name="sage['.$_i.']" value=""></td>
                  <td><input type="text" Name="sarea['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="seducational['.$_i.']" value=""></td></tr><tr>
                  <td></td>
                  <td><input type="text" style="width:60px" Name="snation['.$_i.']" value=""></td>
                  <td><input type="text" style="width:60px" Name="sleave['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="sreward['.$_i.']" value=""></td>
                  <td><input type="text" style="width:100px" Name="stele['.$_i.']" value=""></td>
                  <td><input type="text" Name="spass['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="spolitical['.$_i.']" value=""></td>
                </tr>';
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <br>
          <h3>输入密码管理员密码确认删除 :</h3><br><input type="Password" Name="password" placeholder="密码"><br><br><br>
          <input name="submit" type="submit" value="修改添加学籍信息"><br>
            </form>
    </div></div>';
          }else{
          echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">管理学生</h3>
        <p>两行一个用户 最后两行添加学生  删除选中复选框才有效 不改密码的话密码空着</p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>学号</th>
                  <th>姓名</th>
                  <th>性别</th>
                  <th>年龄</th>
                  <th>地区</th>
                  <th>学制</th></tr><tr>
                  <th>学分</th>
                  <th>民族</th>
                  <th>休复转退</th>
                  <th>奖惩记录</th>
                  <th>电话</th>
                  <th>密码</th>
                  <th>政治面貌</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
              foreach ($_student as $key => $value) {//Sno,Sname,Ssex,Sage,Sarea,Seducational,Spolitical,Snation,Sleave,Sreward,Stele,Spass,allcredit  
                echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chstu['.$_i.']" value="choose"></td>
                  <td>'.htmlentities($value['sno']).'</td>
                  <td><input type="text" style="width:60px" Name="sname['.$_i.']" value="'.htmlentities($value['sname']).'"></td>
                  <td><input type="text" style="width:80px" Name="ssex['.$_i.']" value="'.htmlentities($value['ssex']).'"></td>
                  <td><input type="text" style="width:100px" Name="sage['.$_i.']" value="'.htmlentities($value['sage']).'"></td>
                  <td><input type="text" Name="sarea['.$_i.']" value="'.htmlentities($value['sarea']).'"></td>
                  <td><input type="text" style="width:80px" Name="seducational['.$_i.']" value="'.htmlentities($value['seducational']).'"></td></tr><tr>
                  <td>'.htmlentities($value['allcredit']).'</td>
                  <td><input type="text" style="width:60px" Name="snation['.$_i.']" value="'.htmlentities($value['snation']).'"></td>
                  <td><input type="text" style="width:60px" Name="sleave['.$_i.']" value="'.htmlentities($value['sleave']).'"></td>
                  <td><input type="text" style="width:80px" Name="sreward['.$_i.']" value="'.htmlentities($value['sreward']).'"></td>
                  <td><input type="text" style="width:100px" Name="stele['.$_i.']" value="'.htmlentities($value['stele']).'"></td>
                  <td><input type="text" Name="spass['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="spolitical['.$_i.']" value="'.htmlentities($value['spolitical']).'"></td>
                </tr>';
                $_i++;
                $_str = intval($value['sno'])+1;
            } 
            echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chstu['.$_i.']" value="choose"></td>
                  <td>'.htmlentities($_str).'</td>
                  <td><input type="text" style="width:60px" Name="sname['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="ssex['.$_i.']" value=""></td>
                  <td><input type="text" style="width:100px" Name="sage['.$_i.']" value=""></td>
                  <td><input type="text" Name="sarea['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="seducational['.$_i.']" value=""></td></tr><tr>
                  <td></td>
                  <td><input type="text" style="width:60px" Name="snation['.$_i.']" value=""></td>
                  <td><input type="text" style="width:60px" Name="sleave['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="sreward['.$_i.']" value=""></td>
                  <td><input type="text" style="width:100px" Name="stele['.$_i.']" value=""></td>
                  <td><input type="text" Name="spass['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="spolitical['.$_i.']" value=""></td>
                </tr>';
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <p>统计</p><br>
          <p>党员：'.$tongji['dang'].'</p>
          <p>年龄小于20：'.$tongji['xiao'].'</p>
          <p>少数民族：'.$tongji['shao'].'</p>
          <div class="container">
          <div class="contact-info">
          <br>
          <h3>输入密码管理员密码确认删除 :</h3><br><input type="Password" Name="password" placeholder="密码"><br><br><br>
          <input name="submit" type="submit" value="删除学籍"><a> & </a><input name="submit" type="submit" value="修改或添加学籍信息"><br>
            </form>
    </div></div>';
  }
        }
        function adminallteacher($_teacher){
          //管理员查看所有职工
          /**
          提交信息
          submit 添加职工
          chtea[i] 选中数
          passwordtea 密码
          moretea[i] 修改  修改单个信息
          submit 删除职工
           */
          if($_teacher==""){
            
          echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">管理职工</h3>
        <p>最后一行添加职工  删除添加修改选中复选框才有效 不改密码的话密码空着</p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>工号</th>
                  <th>姓名</th>
                  <th>性别</th>
                  <th>年龄</th>
                  <th>职务</th>
                  <th>政治面貌</th>
                  <th>电话</th>
                  <th>密码</th>
                  <th>课程数</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
              echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chtea['.$_i.']" value="choose"></td>
                  <td>20160001</td>
                  <td><input type="text"  style="width:60px" Name="tname['.$_i.']" value=""></td>
                  <td><input type="text" style="width:30px" Name="tsex['.$_i.']" value=""></td>
                  <td><input type="text" style="width:30px" Name="tage['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="tposit['.$_i.']" value=""></td>
                  <td><input type="text" style="width:60px" Name="tpolitical['.$_i.']" value=""></td>
                  <td><input type="text" Name="ttele['.$_i.']" value=""></td>
                  <td><input type="text" Name="tpass['.$_i.']" value=""></td>
                  <td></td>
                </tr>';
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <br>
          <h3>输入密码管理员密码确认 :</h3><br><input type="Password" Name="password" placeholder="密码"><br><br><br>
          <input name="submit" type="submit" value="修改或添加职工信息"><br>
            </form>
    </div></div>';
          }else{
          echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">管理职工</h3>
        <p> 删除增加修改选中复选框才有效 不改密码的话密码空着</p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>工号</th>
                  <th>姓名</th>
                  <th>性别</th>
                  <th>年龄</th>
                  <th>职务</th>
                  <th>政治面貌</th>
                  <th>电话</th>
                  <th>密码</th>
                  <th>课程数</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
              foreach ($_teacher as $key => $value) {//Tno,Tname,Tsex,Tage,Tposit,Tpolitical,Ttele,Tpass,ccou这里可以修改的全部用文本框
                echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chtea['.$_i.']" value="choose"></td>
                  <td>'.htmlentities($value['tno']).'</td>
                  <td><input type="text"  style="width:60px" Name="tname['.$_i.']" value="'.htmlentities($value['tname']).'"></td>
                  <td><input type="text" style="width:30px" Name="tsex['.$_i.']" value="'.htmlentities($value['tsex']).'"></td>
                  <td><input type="text" style="width:30px" Name="tage['.$_i.']" value="'.htmlentities($value['tage']).'"></td>
                  <td><input type="text" style="width:80px" Name="tposit['.$_i.']" value="'.htmlentities($value['tposit']).'"></td>
                  <td><input type="text" style="width:60px" Name="tpolitical['.$_i.']" value="'.htmlentities($value['tpolitical']).'"></td>
                  <td><input type="text" Name="ttele['.$_i.']" value="'.htmlentities($value['ttele']).'"></td>
                  <td><input type="text" Name="tpass['.$_i.']" value=""></td>
                  <td>'.htmlentities($value['ccou']).'</td>
                </tr>';
                $_i++;
                $_str = intval($value['tno'])+1;
            } 
            echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chtea['.$_i.']" value="choose"></td>
                  <td>'.htmlentities($_str).'</td>
                  <td><input type="text"  style="width:60px" Name="tname['.$_i.']" value=""></td>
                  <td><input type="text" style="width:30px" Name="tsex['.$_i.']" value=""></td>
                  <td><input type="text" style="width:30px" Name="tage['.$_i.']" value=""></td>
                  <td><input type="text" style="width:80px" Name="tposit['.$_i.']" value=""></td>
                  <td><input type="text" style="width:60px" Name="tpolitical['.$_i.']" value=""></td>
                  <td><input type="text" Name="ttele['.$_i.']" value=""></td>
                  <td><input type="text" Name="tpass['.$_i.']" value=""></td>
                  <td></td>
                </tr>';
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <br>
          <h3>输入密码管理员密码确认 :</h3><br><input type="Password" Name="password" placeholder="密码"><br><br><br>
          <input name="submit" type="submit" value="删除职工"><a> & </a><input name="submit" type="submit" value="修改或添加职工信息"><br>
            </form>
    </div></div>';
  }
        }
        function adminallstucour($_stucour){
          //管理员查看所有选课信息
          /**
          提交信息
          submit 添加选课
          chscou[i] 选中数
          cno[i]  课程号
          sno[i]  学号
          grade[i]  成绩
          passwordscou 密码
          submit 删除选课 修改选课
           */
          if($_stucour==""){
            echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">管理选课</h3>
        <p> 最后一行添加课程 删除修改修改选中复选框才有效哦</p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>课程号</th>
                  <th>课程名</th>
                  <th>学号</th>
                  <th>姓名</th>
                  <th>教师</th>
                  <th>教师号</th>
                  <th>成绩</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
            echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chscou['.$_i.']" value="choose"></td>
                  <td><input type="text" Name="cno['.$_i.']" value="" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')"></td>
                  <td></td>
                  <td><input type="text" Name="sno['.$_i.']" value="" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><input type="text" Name="grade['.$_i.']" value="" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')"></td>
                </tr>';
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <h3>添加选课：</h3>
          <br><input type="Password" Name="passwordscou" placeholder="课程号" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')">
          <input type="Password" Name="passwordscou" placeholder="学号" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')">
          <br>
          <h3>输入密码管理员密码确认添加或删除 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
          <input name="submit" type="submit" value="修改或添加选课"><br>
            </form>
    </div></div>';
          }else{
          echo '
          <div class="typrography">
          <div class="container">
        <h3 class="tittle">管理选课</h3>
        <p> 最后一行添加课程 删除修改修改选中复选框才有效哦</p>
        <section id="tables">
          <div class="bs-docs-example">
          <form action="#" method="post">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>课程号</th>
                  <th>课程名</th>
                  <th>学号</th>
                  <th>姓名</th>
                  <th>教师</th>
                  <th>教师号</th>
                  <th>成绩</th>
                </tr>
              </thead>
              <tbody>';
              $_i = 0;
              foreach ($_stucour as $key => $value) {// cno,cname,sno,sname,tno,tname,grade
                echo '<tr>
                  <td><input type="checkbox" aria-label="..." name="chscou['.$_i.']" value="choose"></td>
                  <td>'.htmlentities($value['cno']).'</td>
                  <td>'.htmlentities($value['cname']).'</td>
                  <td>'.htmlentities($value['sno']).'</td>
                  <td>'.htmlentities($value['sname']).'</td>
                  <td>'.htmlentities($value['tno']).'</td>
                  <td>'.htmlentities($value['tname']).'</td>
                  <td><input type="text" maxlength="3" Name="grade['.$_i.']" value="'.htmlentities($value['grade']).'" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')"></td>
                </tr>';
                $_i++;
            } 
                echo '
              </tbody>
            </table>
          </div>
          </section>
          </div></div>
          <div class="container">
          <div class="contact-info">
          <h3>添加选课：</h3>
          <br><input type="text" Name="addcno" maxlength="7" placeholder="课程号" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')">
          <input type="text" Name="addsno" maxlength="10" placeholder="学号" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')">
          <br>
          <h3>输入密码管理员密码确认添加或删除 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
          <input name="submit" type="submit" value="删除选课"><a> & </a><input name="submit" type="submit" value="修改成绩"><a> & </a><input name="submit" type="submit" value="添加选课"><br>
            </form>
    </div></div>';
  }
        }
    }
?>