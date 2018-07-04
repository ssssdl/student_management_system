<?php
    class menuView{

		//菜单选项  传入二维数组 name+url 打印菜单html代码
		/*$arr = array(  
			array('name'=>'系统配置','url'=>'?action=config&do=config'),  
			array('name'=>'验证码配置','url'=>'?action=config&do=seccode'),  
			array('name'=>'模板管理','url'=>'?action=config&do=tpl'),  
			array('name'=>'帐号管理','url'=>'?action=admin&do=list'),  
			array('name'=>'添加帐号','url'=>'?action=admin&do=add'));  
			*/
        public function menu_options($_menu){
			$_menu_start = '
			<section class="button">
			<button id="showLeftPush"><img src="images/menu.png" alt=""></button>
			</section>
			<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<h3>菜单</h3>
			';
			$_menu_end = '
		            </nav>
		            <script src="js/classie.js"></script>
		            <script>
			            var menuLeft = document.getElementById( \'cbp-spmenu-s1\' ),
				        showLeftPush = document.getElementById( \'showLeftPush\' ),
				        showRightPush = document.getElementById( \'showRightPush\' ),
				        body = document.body;
                        showLeftPush.onclick = function() {
				            classie.toggle( this, \'active\' );
				            classie.toggle( body, \'cbp-spmenu-push-toright\' );
				            classie.toggle( menuLeft, \'cbp-spmenu-open\' );
				            disableOther( \'showLeftPush\' );
			            };
                        function disableOther( button ) {
				            if( button !== \'showLeftPush\' ) {
					            classie.toggle( showLeftPush, \'disabled\' );
				            }
				            if( button !== \'showRightPush\' ) {
					            classie.toggle( showRightPush, \'disabled\' );
			            }
		            }
                    </script>
					';
			echo $_menu_start;
			foreach ($_menu as $key => $value) {
				echo '<a href="'.$value['url'].'">'.$value['name']."</a>";
			}
			echo $_menu_end;
        }
    }
?>