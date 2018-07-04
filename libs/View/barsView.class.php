<?php
    class barsView{
        function showmorebar($_allcourse){
            foreach ($_allcourse as $key => $value) {
            if(intval($value['allstu']) != 0){
            echo '<p>'.$value['cname'].'('.$value['cno'].')</p>';
            echo '<div class="progress">
            <div class="progress-bar progress-bar-info" style="width: '.intval($value['buji'].'00')/intval($value['allstu']).'%"><a>不及格:'.intval($value['buji']).'人
</a><span class="sr-only">35% Complete (success)</span></div>
            <div class="progress-bar progress-bar-success" style="width: '.intval($value['ji'].'00')/intval($value['allstu']).'%"><a>及格'.intval($value['ji']).'人
</a><span class="sr-only">35% Complete (success)</span></div>
            <div class="progress-bar progress-bar-warning" style="width: '.intval($value['zhong'].'00')/intval($value['allstu']).'%"><a>中等'.intval($value['zhong']).'人
</a><span class="sr-only">20% Complete (warning)</span></div>
<div class="progress-bar progress-bar-inverse" style="width: '.intval($value['liang'].'00')/intval($value['allstu']).'%"><a>良好'.intval($value['liang']).'人
</a><span class="sr-only">10% Complete (danger)</span></div>
            <div class="progress-bar progress-bar-danger" style="width: '.intval($value['youa'].'00')/intval($value['allstu']).'%"><a>优秀'.intval($value['youa']).'人
</a><span class="sr-only">10% Complete (danger)</span></div>
        </div>';}
        else{
            echo '<p>'.$value['cname'].'('.$value['cno'].')还没有学生选课</p>';
        }
    }
        }
    }
?>