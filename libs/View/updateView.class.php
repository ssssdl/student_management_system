<?php
    class updateView{
        function adminupdate($adminInfo){
            //管理员不可以修改工号 职务 Tname Tsex Tage tpolitical ttele
            echo '
            <div class="contact-us">
	<div class="container">
        <h3 class="tittle">修改个人信息</h3>
        <p>不修改的项不写  输入密码才能修改.</p><!-- 懒得写前端 -->
		<div class="contact-info">
			<form action="#" method="post">
				<h3>姓名 :</h3><br><input type="text" Name="tname" value="'.htmlentities($adminInfo['Tname']).'" required><br>
				<h3>性别 :</h3><br><input type="text" Name="tsex" value="'.htmlentities($adminInfo['Tsex']).'" required><br>
                <h3>年龄 :</h3><br><input type="text" Name="tage" value="'.htmlentities($adminInfo['Tage']).'" required><br>
                <h3>政治面貌 :</h3><br><input type="text" Name="tpolitical" value="'.htmlentities($adminInfo['Tpolitical']).'" required><br>
                <h3>电话 :</h3><br><input type="text" Name="ttele" value="'.htmlentities($adminInfo['Ttele']).'" required><br>
                <h3>输入密码 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
                <h1>修改密码：</h1><br>
                <h3>新密码 :</h3><br><input type="Password" Name="newpass" placeholder="新密码"><br>
                <h3>确认密码 :</h3><br><input type="Password" Name="repass" placeholder="确认密码"><br>
				<input name="submit" type="submit" value="确定修改"><br>
            </form>
		</div>
	</div>
</div>
            ';
        }
        function stu_teaupdate($_info){
            //普通教师和学生只能修改电话和密码
            echo '<div class="contact-us">
            <div class="container">
                <h3 class="tittle">修改个人信息</h3>
                <p>不修改的项不写  输入密码才能修改.</p><!-- 懒得写前端 -->
                <div class="contact-info">
                <form action="#" method="post">
                    <h3>电话 :</h3><br><input type="text" Name="Stele" value="'.htmlentities($_info['Ttele']).'" required><br>
                    <h3>输入密码 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
                    <h1>修改密码：</h1><br>
                    <h3>新密码 :</h3><br><input type="Password" Name="newpass" placeholder="新密码"><br>
                    <h3>确认密码 :</h3><br><input type="Password" Name="repass" placeholder="确认密码"><br>
                    <input name="submit" type="submit" value="确定修改"><br>
                </form>
            </div>
        </div>
    </div>';
        }
    }
?>