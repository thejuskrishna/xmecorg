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
$target = "index.php";
             header("Location: $target");

}
else
{
$user =& XMEC::getUser();

$target = "index.php";
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
$target="index.php?action=logout";
		XMEC::user_logout();
		header("Location: $target");
		exit;
	}

	//$target = urlencode($target);
  $no_search_menu = 1;
	include 'header.php';
?>
        <?php
		$fb_icon=1;
                if ($fb_icon) {
        ?>
                                <DIV ALIGN=RIGHT height=30 ><div id="fb-root"></div>
 <div class="fb-login-button" data-scope="email,user_checkins">
        Login with Facebook
      </div>
        <?php
                }
        ?>
</div>
<CENTER>
<BR>
<!--center starts-->
<!-- Box starts -->
<TABLE cellSpacing=0 cellPadding=0 border=0>
<TBODY>
        <TR>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>    </TR>
    <TR>
                <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
                <TD colSpan=2 rowSpan=2>
                        <!--contents starts-->

<TABLE cellSpacing=0 cellPadding=1 width=375  border=0>
	<?php
		if ( ($target_passed) && (!$login_failed) ) {
	?>
			<TR>
  			<TD ALIGN=CENTER height=40 class=name bgcolor="#8EBBE6"><font color="#ffffff"><B>This page can be viewed by XMECians only.</B></font>
					<BR><BR><B>Please login to view this page</B></TD>
			</TR>
	<?php
		}
	?>

	<?php
		if ($login_failed) {
	?>
			<TR>
				<TD ALIGN=CENTER height=30 class=head bgcolor="#FF0000"><font color="#FFFFFF"><B>Login Failed. Please try again.</B></font></TD>
			</TR>
	<?php
		}
	?>
  <TR>

  	<TD valign=top align=center>
		<TABLE cellSpacing=2 cellPadding=0 width=175 border=0>
			<form method=POST name=frmlogin action=login.php>
				<input type=hidden name=action value=login>
				<input type=hidden name=xgetpage value=<?=$target?>>
				<TR>
					<TD colspan=3 align=center height=25><img src="images/loginhead.jpg" width=140 height=16></TD>
				</TR>
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
  	</TD>
  </TR>
	    <TR><TD align=center height=20><img src="images/space.gif"></TD></TR>
	    <TR>
    <TD align=center height=20 bgcolor="#eeeeee"><B><A class=link href="nologin.php">Did not receive Login?</A> || <A
class=link href="loginerror.php">Forgot Password?</A> || <A class=link href="othererrors.php">Report a problem</A></TD>
    </TR>
</TABLE>
<!--contents ends-->
                </TD>
                <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
        </TR>
        <TR>
                <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
                <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
        </TR>
    <TR>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
                <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
                <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        </TR>
        </TBODY>
</TABLE>
<!-- Box ends -->
<BR>
<!--center ends-->

<?php
include 'footer.php';
?>
