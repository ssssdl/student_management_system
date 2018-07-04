<?php
    class menuModel{
        //这个储存类菜单选项和对应的跳转
        function teacherMenu(){
            return array(  
                array('name'=>'个人信息','Instr'=>'查看个人信息','url'=>'?controller=index&method=userinfo'),  
                array('name'=>'管理课程','Instr'=>'开设课程','url'=>'?controller=insert&method=insertcourse'),  
                array('name'=>'录入成绩','Instr'=>'录入你开设课程的成绩','url'=>'?controller=index&method=entryscore'),  
                array('name'=>'查看课程情况','Instr'=>'查看学生成绩情况','url'=>'?controller=index&method=selectcourse'),
                array('name'=>'修改信息','Instr'=>'修改个人信息','url'=>'?controller=update&method=updateinfo'),  
                array('name'=>'退出登陆','Instr'=>'退出学籍系统','url'=>'?controller=login&method=unlogin')); 
        }
        function studentMenu(){
            return array(  
                array('name'=>'个人信息','Instr'=>'查看个人信息','url'=>'?controller=index&method=userinfo'),  
                array('name'=>'选课','Instr'=>'进入选课界面选课','url'=>'?controller=index&method=choosecour'),  
                array('name'=>'查询成绩','Instr'=>'查询考试成绩','url'=>'?controller=index&method=selectcourse'),  
                array('name'=>'修改信息','Instr'=>'修改个人信息','url'=>'?controller=update&method=updateinfo'),  
                array('name'=>'退出登陆','Instr'=>'退出学籍系统','url'=>'?controller=login&method=unlogin'));  
        }
        function adminMenu(){
            return array(  
                array('name'=>'个人信息','Instr'=>'查看个人信息','url'=>'?controller=index&method=userinfo'),  
                array('name'=>'管理课程','Instr'=>'开设或者结束课程','url'=>'?controller=insert&method=insertadmincourse'),  
                array('name'=>'录入成绩','Instr'=>'录入你开设的课程学生考试成绩','url'=>'?controller=index&method=entryscore'),
                array('name'=>'查询用户信息','Instr'=>'查询老师或者学生的信息','url'=>'?controller=index&method=searchadmin'),
                array('name'=>'查看课程情况','Instr'=>'查看学生成绩情况','url'=>'?controller=index&method=selectcourse'),
                array('name'=>'管理用户','Instr'=>'删除修改系统用户','url'=>'?controller=user&method=adminuser'),  
                array('name'=>'修改信息','Instr'=>'修改个人信息','url'=>'?controller=update&method=updateinfo'), 
                array('name'=>'退出登陆','Instr'=>'退出学籍系统','url'=>'?controller=login&method=unlogin'));  
        }
    }
?>