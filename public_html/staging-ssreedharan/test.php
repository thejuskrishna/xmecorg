<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
<div id="preloader"></div>
<div id="fb-root"></div>
<script type="text/javascript">

    window.fbAsyncInit = function() {
        FB.init({
          appId      : '101039650020031',
          status     : true,
          cookie     : true,
          xfbml      : true,
          oauth      : true,
        });

        FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
window.location='login.php';
    // connected
  } else if (response.status === 'not_authorized') {
    login();
  } else {
    login();
  }
 });

        FB.Event.subscribe('auth.login', function(response) {
            window.location='login.php';
        });
        /*FB.Event.subscribe("auth.logout", function() {
            window.location = 'login.php?action=logout';
        });*/
    };

    (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
    }(document));

function login() {
    FB.login(function(response) {
        if (response.authResponse) {
            testAPI();
        } else {
            // cancelled
        }
    });
function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
        console.log('Good to see you, ' + response.name + '.');
    });
}

}
</script>

