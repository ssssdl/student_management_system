<?php
    class insertView{
        function insert_course($_who){
            //添加课程 传入 课程名 name 课时 hour 学分 credit
            if($_who == "teacher"){
                echo '
            <div class="contact-us">
	<div class="container">
        <h3 class="tittle">添加课程</h3>
        <p>教师只能添加自己课程  添加后学生才可以选课  输入密码确定选课 删除课程请与管理员联系</p><!-- 懒得写前端 -->
		<div class="contact-info">
			<form action="#" method="post">
				<h3>课程 :</h3><br><input type="text" Name="addcname" required><br>
				<h3>课时 :</h3><br><input type="text" Name="addchour" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')" required><br>
                <h3>学分 :</h3><br><input type="text" Name="addccredit" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')" required><br>
                <h3>输入密码 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
				<input name="submit" type="submit" value="确定添加"><br>
            </form>
		</div>
	</div>
</div>
            ';
        }else{
            echo '
            <div class="contact-us">
	<div class="container">
		<div class="contact-info">
			<form action="#" method="post">
				<h3>课程 :</h3><br><input type="text" Name="addcname" required><br>
				<h3>课时 :</h3><br><input type="text" Name="addchour" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')" required><br>
                <h3>学分 :</h3><br><input type="text" Name="addccredit" onkeyup="if(isNaN(value))execCommand(\'undo\')" onafterpaste="if(isNaN(value))execCommand(\'undo\')" required><br>
                <h3>输入密码 :</h3><br><input type="Password" Name="password" placeholder="密码（必填）" required><br><br><br>
				<input name="submit" type="submit" value="确定添加"><br>
            </form>
		</div>
	</div>
</div>
            ';
            }
        }
    }
?>