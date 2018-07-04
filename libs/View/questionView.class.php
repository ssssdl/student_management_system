<?php
    class questionView{
        //传入参数 题目变量（数组二维 3*n，说明标题、说明、链接），标题，标题说明  ，其实还可以设置颜色等等
        /*  //传入题目变量类型
            $arr = array(  
                array('name'=>'系统配置','Instr'=>'说明1','url'=>'?action=config&do=config'),  
                array('name'=>'验证码配置','Instr'=>'说明2','url'=>'?action=config&do=seccode'),  
                array('name'=>'模板管理','Instr'=>'说明3','url'=>'?action=config&do=tpl'),  
                array('name'=>'帐号管理','Instr'=>'说明4','url'=>'?action=admin&do=list'),  
                array('name'=>'添加帐号','Instr'=>'说明5','url'=>'?action=admin&do=add'));  
            */
        public function question($qus,$title,$title_dir){
            //题目上面的文字可以标识是什么题，web，逆向什么的
            $_str1_title_head = '
                    <div id="banner-bottom" class="banner-bottom">
	                <div class="container">
		            <h3 class="tittle">'.$title.'</h3>
		            <p> '.$title_dir.' </p>
                    ';

            //题目  每个题目对应一个标题 ，链接，说明  ，这里后期要弄成弹窗 ，还要可以提交flag，或者动态生成题目
            /*
             *icon 目前有如下四种，后期可以根据题目类型具体分配 ，icon也要从新选，颜色也可以设置
             *<span data-type="icon" class="sti-icon glyphicon glyphicon-plus sti-item"></span>
             *<span data-type="icon" class="sti-icon glyphicon glyphicon-scissors sti-item"></span>
             *<span data-type="icon" class="sti-icon glyphicon glyphicon-education sti-item"></span>
             *<span data-type="icon" class="sti-icon glyphicon glyphicon-apple sti-item"></span>
             */
            $_str1_qus = '<ul id="sti-menu" class="sti-menu">';
            foreach($qus as $k=>$val){  
               // echo "name:".$val["name"]."/n";
                $_str1_qus = $_str1_qus.'
				<li data-hovercolor="#fff">
					<a href="'.$val["url"].'"><!-- 跳转 -->
						<h4 data-type="mText" class="sti-item">'.$val["name"].'</h4>
						<p data-type="sText" class="sti-item">'.$val["Instr"].'</p>
                        <span data-type="icon" class="sti-icon glyphicon glyphicon-education sti-item"></span>
					</a>
				</li>';
             }  

            //这个表单结束符
            $_str1_title_end = '
				<script type="text/javascript" src="js/jquery.iconmenu.js"></script>
				<script type="text/javascript">
					$(function() {
						$(\'#sti-menu\').iconmenu({
							animMouseenter	: {
								\'mText\' : {speed : 400, easing : \'easeOutExpo\', delay : 140, dir : 1},
								\'sText\' : {speed : 400, easing : \'easeOutExpo\', delay : 0, dir : 1},
								\'icon\'  : {speed : 800, easing : \'easeOutBounce\', delay : 280, dir : 1}
							},
							animMouseleave	: {
								\'mText\' : {speed : 400, easing : \'easeInExpo\', delay : 140, dir : 1},
								\'sText\' : {speed : 400, easing : \'easeInExpo\', delay : 280, dir : 1},
								\'icon\'  : {speed : 400, easing : \'easeInExpo\', delay : 0, dir : 1}
						    	}
					    	});
				    	});
			    	    </script>
		            </ul>
	            </div>
            </div>
            ';
            echo $_str1_title_head.$_str1_qus.$_str1_title_end;
        }
    }
?>