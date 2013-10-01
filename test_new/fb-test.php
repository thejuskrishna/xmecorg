<?php
	include_once 'xmec.inc';
if(XMEC::authenticate_fb())
{
require 'header.php';

}
else
{


if(XMEC::fb_login())
{
		
$user =& XMEC::getUser();
$target = "index.php";
                header("Location: $target");

}
else
{
$target = "login.php";
                header("Location: $target");

require 'header.php';
echo $user->error;
//echo "Your fbid is not in our systems please send a mail to our admin (vyas.thottathil@gmail.com) with your details so he can add you to our system";
}



?>

<div id="fb-root"></div>
 <div class="fb-login-button" data-scope="email,user_checkins">
        Login with Facebook
      </div>
<?
}
?>
<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '101039650020031',
          status     : true, 
          cookie     : true,
          xfbml      : true,
          oauth      : true,
        });

        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
      };

      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));
    </script>
  </body>
</html>
