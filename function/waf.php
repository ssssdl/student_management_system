<?php
    //这里写一些安全的waf  不太会起名  就这样吧

    //判断长度是否符合要求  长度写到config里面
    function howLeng($_str){
        require_once('/config/indexconfig.php');
        return in_array(strlen($_str),$_name_len);
    }

    //判断是否全为数字
    function nochar($_str){
        return preg_match("/^[0-9]*$/", "$_str");
    }


    function daddslashes($str){//过滤函数  单次转义单引号等符号  get_magic_quotes_gpc() 系统自动过滤函数  如果打开这个函数就不用重复转义
        return (!get_magic_quotes_gpc())?addslashes($str):$str;
    }

    //姓名只能是汉字  性别只能是男女  年龄只能是数字0-100  政治面貌只能是群众  共青团员  党员  电话只能是数字  每个长度也加判断
    function whatname($_str){
        if(strlen($_str)>=50){
            return false;
        }else{
            return preg_match('/[\x{4e00}-\x{9fa5}]+/u', $_str);
        }
    }
    function whatsex($_str){
        switch ($_str) {
            case '男':
            case '女':
                return true;
            default:
                return false;
        }
    }
    function whatage($_str){
        if(nochar($_str)){
            //判断0-100
            if(intval($_str)>=0&&intval($_str)<=100){
                return true;
            }else
                return false;
        }else
            return false;
    }
    function whatpolitical($_str){
        switch ($_str) {//添加其他政治面貌
            case '群众':
            case '共青团员':
            case '预备党员':
            case '共产党员':
                return true;
            default:
                return false;
        }
    }
    //电话只能是数字   可以的话加上中横线
    function whattele($_str){
        if(strlen($_str)>=15){
            return false;
        }else{
            return nochar($_str);
        }
    }

    function whatchour($_str){//学时 只能是数字 0-200之间
        if(nochar($_str)){
            //判断0-100
            if(intval($_str)>=0&&intval($_str)<200){
                return true;
            }else
            return false;
        }else
            return false;
    }
    function whatccredit($_str){//学分0-10之间最多三位小数
        if(intval($_str)>0&&intval($_str)<10)
            return preg_match("/^[0-9]+(.[0-9]{1,3})?$/", "$_str");
        else
            return false;
    }
    function whatcname($_str){//有非法返回1  使用时注意加！
        $black_str = "/(and|or|union|select|sleep|substr|order|order|by|where|from|rand|exp|updatexml|insert|update|dorp|delete|[,]|[\s]|[|]|[&])/i";
        if(strlen($_str)<40)
            return preg_match($black_str, $_str);
        else
            return false;
    }
    function whatarea($_str){//有非法返回1  使用时注意加！
        $black_str = "/(and|or|union|select|sleep|substr|order|order|by|where|from|rand|exp|updatexml|insert|update|dorp|delete|[,]|[\s]|[|]|[&])/i";
        if(strlen($_str)<100)
            return preg_match($black_str, $_str);
        else
            return false;
    }
?>