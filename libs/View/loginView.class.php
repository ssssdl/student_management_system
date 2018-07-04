<?php
    class loginView{
        //要加上提交操做，注册教师和其他用户一起登陆，要有用户名（学号）  密码  记住密码  注册（提交审核） 找回密码
        public function showLogin(){
            echo '
            <div class="contact-home">
                <div class="map-home">
                    <!-- 需要访问外网 -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d2482.432383990807!2d0.028213999961443994!3d51.52362882484525!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1423469959819"></iframe>
                    <div class="map-pos">
                        <div class="login-pad">
                            <h2>登录</h2>
                                <form id="loginForm" action="#" method="post">
                                    <input type="text" Name="Username" maxlength="10" placeholder="学/工号" required="" onkeyup="this.value=this.value.replace(/\D/g,\'\')">  
                                    <input type="password" Name="Password" placeholder="密码" required="">
                                    <!-- <input type="text" value="Mobile" onfocus="this.value = \'\';" onblur="if (this.value == \'\') {this.value = \'Mobile\';}" required=""> -->
                                    <label class="checkbox"><input id="remember" type="checkbox" name="checkbox" checked><i> </i>记住密码</label>
                                    <!-- <textarea placeholder="Message" required=""></textarea> -->
                                    <hr>
                                    <div align="center">
                                    <input type="submit" value="登录">
                                    </div>
                                </form>
                                <script><!-- 不知道有没有用 -->
  window.onload = function(){
    var oForm = document.getElementById(\'loginForm\');
    var oUser = document.getElementById(\'Username\');
    var oPswd = document.getElementById(\'Password\');
    var oRemember = document.getElementById(\'remember\');
    //页面初始化时，如果帐号密码cookie存在则填充
    if(getCookie(\'Username\') && getCookie(\'Password\')){
      oUser.value = getCookie(\'Username\');
      oPswd.value = getCookie(\'Password\');
      oRemember.checked = true;
    }
    //复选框勾选状态发生改变时，如果未勾选则清除cookie
    oRemember.onchange = function(){
      if(!this.checked){
        delCookie(\'Username\');
        delCookie(\'Password\');
      }
    };
    //表单提交事件触发时，如果复选框是勾选状态则保存cookie
    oForm.onsubmit = function(){
      if(remember.checked){ 
        setCookie(\'Username\',oUser.value,7); //保存帐号到cookie，有效期7天
        setCookie(\'Password\',oPswd.value,7); //保存密码到cookie，有效期7天
      }
    };
  };
  //设置cookie
  function setCookie(name,value,day){
    var date = new Date();
    date.setDate(date.getDate() + day);
    document.cookie = name + \'=\' + value + \';expires=\'+ date;
  };
  //获取cookie
  function getCookie(name){
    var reg = RegExp(name+\'=([^;]+)\');
    var arr = document.cookie.match(reg);
    if(arr){
      return arr[1];
    }else{
      return \'\';
    }
  };
  //删除cookie
  function delCookie(name){
    setCookie(name,null,-1);
  };
</script>
                            </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            ';
        }
    }
?>