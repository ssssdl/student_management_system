<?php
	class headView{
		//定义两个变量储存开始结和结束对应的html
		//这里也可以用数组和列表一个标签一个标签实现

		//开始  传入关键字，和标题  ，传出开始的HTML代码
		public function html_head($_title,$_keywords){
			//开始html head 接下来接body里面的标签  需要的更改内部话可以改成函数  可以更改title
			$_head = '
					<!DOCTYPE html>
					<html>
					<head>
					<title>'.$_title.'</title>
					<!-- mate标签保持相同 -->
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<meta name="keywords" content="'.$_keywords.'" />
					<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
						function hideURLbar(){ window.scrollTo(0,1); } </script>
					<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
					<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
					<link href="css/component.css" rel="stylesheet" type="text/css"  />
					<link href="css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
					<link href="css/ihover.css" rel="stylesheet" media="all">
					<script src="js/jquery-1.11.1.min.js"></script>
					<link href=\'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic\' rel=\'stylesheet\' type=\'text/css\'>
						<script type="text/javascript" src="js/move-top.js"></script>
						<script type="text/javascript" src="js/easing.js"></script>
						<script type="text/javascript">
							jQuery(document).ready(function($) {
								$(".scroll").click(function(event){		
									event.preventDefault();
									$(\'html,body\').animate({scrollTop:$(this.hash).offset().top},1000);
								});
							});
						</script>
					</head>
					<!-- 右侧菜单 -->
					<body class="cbp-spmenu-push">
				';
			echo $_head;
		}
		public function html_end(){
			$_end = '
		<!-- //contact -->
<!-- copy-right -->
<div class="copy-right">
	<div class="container">
		<p>ssssdl.github.io</p>
	</div>
</div>
<!-- //copy-right -->
<!-- Bootstrap core JavaScript-->
    <!-- Placed at the end of the document so the pages load faster -->
	<!-- js -->
		 <script src="js/bootstrap.js"></script>
	<!-- js -->
<!-- smooth scrolling -->
	<script type="text/javascript">
		$(document).ready(function() {
		/*
			var defaults = {
			containerID: \'toTop\', // fading element id
			containerHoverID: \'toTopHover\', // fading element hover id
			scrollSpeed: 1200,
			easingType: \'linear\' 
			};
		*/								
		$().UItoTop({ easingType: \'easeOutQuart\' });
		});
	</script>
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!-- //smooth scrolling -->
					</body>
					</html>
					';
			echo $_end;
		}
	}	
?>