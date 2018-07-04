<?php
    class titlesearchView{
        //原html代码 搜索和title在同一个<div>标签下  先这样 scoreboard下有不带顶部大文本的title，可以另写一个函数，有时间改一下颜色和背景
		//传入标题   黑客攻防学习及智能推荐系统
		//查询后来用再回去找
		public function title_html_small($_title){
			echo '<div class="banner page-head">
			<div class="logo">
				<h1><a href="?controller=index&method=index">'.$_title.'</a></h1>
			</div>
			</div>
		    </div>';
		}
    }
?>