<div id="fb-root"></div>
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
       
	function createCookie(name,value,days) {
            if (days) {
                var date = new Date();
                date.setTime(date.getTime()+(days*24*60*60*1000));
                var expires = "; expires="+date.toGMTString();
            }
            else var expires = "";
                document.cookie = name+"="+value+expires+"; path=/";
        }

    </script>

<?php
  $this_page="login";
	include_once 'xmec.inc';

	reset($HTTP_POST_VARS);
	$action = chop($HTTP_POST_VARS["action"]);
	$target = chop($HTTP_POST_VARS["xgetpage"]);
	if ($_SERVER['REQUEST_METHOD'] == "GET") {
		$target = chop($HTTP_GET_VARS["xgetpage"]);
		$action = chop($HTTP_GET_VARS["action"]);
	}

	$target_passed = 0;
	$login_failed = 0;

	if ($target == "") {
		$target = "index.php";
	} else {
		$target_passed = 1;
	}
?>
<?
		if(!XMEC::authenticate_fb())
		{

			$fb_icon=1;
			if(XMEC::fb_login())
			{

				$user =& XMEC::getUser();
				//$target = "index.php";
			        header("Location: $target");
			}
			else
			{
				$user =& XMEC::getUser();
				//$target = "index.php";
				if($user->error!="")
				{
?>

<script>
				alert("Your fb id is currently not in our system please contact our admin (vyas.thottathil@gmail.com) with your details so he can add you to our system");
</script>

<?
				}

				$fb_icon=0;
			}
		}

		if ($action == "login") {
			$userid = chop($HTTP_POST_VARS["rollno"]);
			$pass = chop($HTTP_POST_VARS["passwd"]);

			if (XMEC::authenticate_user()) {
				XMEC::user_logout();
				$fb_icon=1;
			}

			if (! XMEC::user_login($userid, $pass)) {
				//header("Location: failedlogin.php");
				//exit;
				$login_failed = 1;
			} else {
				header("Location: $target");
				exit;
			}

		} else if ($action == "logout") {
?>
<script>

        		var nameEQ = "fbsr_101039650020031";
			createCookie(nameEQ,"",-1);
</script>
<?            
			$target="index.php";
			XMEC::user_logout();
			header("Location: $target");
			exit;
		}

		//$target = urlencode($target);
		$no_search_menu = 1;
		include 'header.php';

?>

<BR>

<div id="login_container" align="center">

    <TABLE class="box-table" id="login_table" cellSpacing=2 cellPadding=0 width=175 border=0>
	<?php
                if ( ($target_passed) && (!$login_failed) ) {
	?>
			<TR>
                            <font color="#ffffff"><B>This page can be viewed only by xMECians</B></font><br/><br/>
                            <B>Please login to view this page</B>
			</TR>
	<?php
		}
	?>

	<?php
		if ($login_failed) {
	?>
			<TR>
                            <font color="#FF0000"><B>Login Failed! Please try again.</B></font>
			</TR>
	<?php
		}
	?>

                    <form method=POST name=frmlogin action=login.php>
                        <input type=hidden name=action value=login>
                        <input type=hidden name=xgetpage value=<?=$target?>><br/><br/>
                        <tr><h1>Members Login</h1></tr><br/>
			<TR>
                            <TD class=fname>Login</TD>
                            <TD><INPUT name=rollno type=text class=box size=10></TD>
                            <TD><img src="images/space.gif" border=0 ></TD>
			</TR>
			<TR>
                            <TD class=fname>Password</TD>
                            <TD><INPUT name=passwd type=password class=box size=10></TD>
                            <TD><INPUT name=bttnlogin type=image src="images/go.gif" border=0 width=15 height=15></TD>
                        </TR>
                    </form>
	</TABLE>
        <br/><br/>
        <div>
            <B><A class=link href="nologin.php">Did not receive Login?</A> ||
            <A class=link href="loginerror.php">Forgot Password?</A> ||
            <A class=link href="othererrors.php">Report a problem</A></B>
        </div>
        <br/>
<!--        <div id="fb-root"></div>-->
        <fb:login-button autologoutlink='true' scope='email,user_checkins'>Login with Facebook</fb:login-button>
</div>
<?php
include 'footer.php';
?>
