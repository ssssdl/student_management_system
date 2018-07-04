<?php
//这个函数作用是根据指定的控制器和方法 自动实例化控制器类方便实现统一的入口程序
   function C($name,$method){//neme代表控制器的名字 method代表像执行的方法
   	require_once('/libs/Controller/'.$name.'Controller.class.php');
   	//eval('$obj = new '$name.'Controller();$obj->'.$method.'();');//这个函数简单，但不安全  Controller()可能没有括号
   	$controller = $name.'Controller';
   	$obj = new $controller();//括号
   	$obj->$method();
   }
   function M($name){//传入模型名 完成实例化 返回实例化模型对象
   	require_once('/libs/Model/'.$name.'Model.class.php');
   	//这里也可以用eval()
   	$model = $name.'Model';
   	$obj = new $model();
   	return $obj;
   }
   function V($name){//完成实例化 返回对象
   	require_once('/libs/View/'.$name.'View.class.php');
   	$view = $name.'View';
   	$obj = new $view();
   	return $obj;
   }
   function whoisit($_no){//这些函数是改数据库时用的	
	   switch(strlen($_no)){
		   	case 7:
				return 'course';
			case 8:
				return 'teacher';
			case 10:
				return 'student';
			default:
				die(V('error')->notFound());
	   }
   }
   function whoisno($_no){
		switch(strlen($_no)){
			case 7:
			 	return 'cno';
		 	case 8:
			 	return 'tno';
		 	case 10:
			 	return 'sno';
		 	default:
			 	die(V('error')->notFound());
		}
	}
	function whoispass($_no){
		switch(strlen($_no)){
		 	case 8:
			 	return 'Tpass';
		 	case 10:
			 	return 'Spass';
		 	default:
			 	die(V('error')->notFound());
		}
	}
	function whoistele($_no){
		switch(strlen($_no)){
		 	case 8:
			 	return 'Ttele';
		 	case 10:
			 	return 'Stele';
		 	default:
			 	die(V('error')->notFound());
		}
	}
?>