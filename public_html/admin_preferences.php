<?php

        include 'xmec.inc';
        include 'header.php';

        if (! XMEC::authenticate_user()) {

                echo "<html><h1>Please login to access this page<html>";

                exit ;

        }

  reset($HTTP_POST_VARS);
        $action = chop($HTTP_POST_VARS["todo"]);
        if ($_SERVER['REQUEST_METHOD'] == "GET")
                $action = chop($HTTP_GET_VARS["todo"]);

  $me =& XMEC::getUser();
  $user = $me;

  $admin = FALSE;
$id=$_GET['id'];
  if ($me->isAdmin() && isset($_GET['id']) && $_GET['id'] != "" ) {
    $admin = TRUE;
    $user = new XMEC_user($_GET['id']);
    if (!$user->fetchInfo()) {
          echo "<html><h1>ID not found !</html>";
      exit;
    }
  }

  $pemail_pref = $user->getPref('personal_email');
  $oemail_pref = $user->getPref('official_email');
  $curr_visib = $user->getAddressVisibility('PRESENT');
  $comp_visib = $user->getAddressVisibility('COMPANY');
  $perm_visib = $user->getAddressVisibility('PERMANENT');

  $pass_st = "";
  $email_st = "";
  $addr_st = "";

			
	$flag=0;

	  if ($action == "update") {

    // Password change..

    if (!empty($_POST['passwd1']) || !empty($_POST['passwd2']) || !empty($_POST['passwd3'])) {
    if (!$admin && $_POST['passwd1'] == "") {
      $pass_st = "Please enter the old password";
	$flag=1;
    } else
    if ($_POST['passwd2'] != "" && $_POST['passwd3'] != "") {
      if ($_POST['passwd2'] != $_POST['passwd3']) {
		$pass_st = "Passwords doesn't match";
		$flag=1;
      } else {
        if ($admin) {
          if ($user->setPassword($_POST['passwd2'], $_POST['passwd2'], TRUE) == FALSE)
          {
		  $pass_st = "Old password incorrect";
		$flag=1;
	  }
        } else {
          if ($user->setPassword($_POST['passwd1'], $_POST['passwd2']) == FALSE)
            {$pass_st = "Old password incorrect";
		$flag=1;
	  }
        }
      }
    } else
	{
      		$pass_st = "Please enter new password";
		$flag=1;
	}
    }
    else
	$flag=1;

if($flag==0)
{
	$message="Hello ".$user->first_name.",\n\nYour password for xmec.org has been reset to the following:\n\n".$_POST['passwd2']."\n\nCheers!\nxMEC Admin";
	$to=$user->get('personal_email').",".$user->get('official_email');
	$subject = 'xMEC.org : Your password has been reset';
	$headers = 'From: webmaster@xmec.org'."\r\nBcc: vyas.thottathil@gmail.com,sarath.s.mec@gmail.com,thejuskrishna@gmail.com";
	mail($to,$subject,$message,$headers);
}

if(!empty($_POST['new_email']))
{
$new_email=$_POST['new_email'];
$message=<<<EOD
Hello $user->first_name,

The personal email id of your account on xmec.org for roll no "$user->id" has been updated to "$new_email"

Cheers!
xMEC Admin
EOD;

$to=$user->get('official_email').",".$user->personal_email.",".$_POST['new_email'];
$subject = 'xMEC.org: New personal email ID';
$headers = 'From: webmaster@xmec.org' . "\r\nBcc: vyas.thottathil@gmail.com,sarath.s.mec@gmail.com,thejuskrishna@gmail.com" ;
mail($to,$subject,$message,$headers);
$user->setEmail($_POST['new_email'],$admin);
}
    // Email prefs..
    if ($_POST['pemail'] != $pemail_pref) {
      if (! $user->setPref('personal_email', $_POST['pemail'])) {
        $email_st = $user->getError();
      } else {
        $pemail_pref = $_POST['pemail'];
      }
    }

    if ($_POST['oemail'] != $oemail_pref) {
      if (! $user->setPref('official_email', $_POST['oemail'])) {
        $email_st .= $user->getError();
      } else {
        $oemail_pref = $_POST['oemail'];
      }
    }

    // Address visibility..

    if ($_POST['curr'] != $curr_visib) {
      if (! $user->setAddressVisibility('PRESENT', $_POST['curr'])) {
        $addr_st = $user->getError();
      } else {
        $curr_visib = $_POST['curr'];
      }
    }

    if ($_POST['comp'] != $comp_visib) {
      if (! $user->setAddressVisibility('COMPANY', $_POST['comp'])) {
        $addr_st .= $user->getError();
      } else {
        $comp_visib = $_POST['comp'];
      }
    }

    if ($_POST['perm'] != $perm_visib) {
      if (! $user->setAddressVisibility('PERMANENT', $_POST['perm'])) {
        $addr_st .= $user->getError();
      } else {
        $perm_visib = $_POST['perm'];
      }
    }
  }
		

?>



<script>

function validate()

{

<?php if (!$admin) { ?>

	if (document.f1.passwd1.value != "" || document.f1.passwd2.value != "" || document.f1.passwd3.value != "") {

		if (document.f1.passwd1.value == "" )

			alert("Please enter the old password");

		else if (document.f1.passwd2.value == "")

			alert("Please enter a new password");

		else if (document.f1.passwd3.value == "")

			alert("Please confirm the new password");

		else if (document.f1.passwd2.value != document.f1.passwd3.value)			alert("Passwords doesn't match");

		else {

			document.f1.action="<?=$PHP_SELF?>"

			document.f1.submit();

		}

	} else {

		document.f1.action="<?=$PHP_SELF?>"

		document.f1.submit();

	}

<?php } else { ?>

	document.f1.action="<?=$PHP_SELF?>"
	document.f1.submit();
<?php } ?>


}	

</script>
<div align="center">
<br/><br/>
<form name=f1 method=POST>
<TABLE border=0 cellPadding=0 cellSpacing=0 width="90%">
<TR>
<TD valign=top width=445><IMG src="images/head_profile.gif">
<P><b>Changing preferences for <?=$user->get('full_name')?></b>
<?php 
	if ($pass_st != "" || $email_st != "" || $addr_st != "")
            echo "<br><FONT face=arial size=2 color=\"#FF0000\">Failed updating preferences: $pass_st  $email_st  $addr_st</font><br>";
	else if ($action == "update")
            echo "<br><FONT face=arial size=2 color=\"#00FF00\">Successfully updated preferences</font><br>";
?>

</P><BR>
<P><b>Change Password </b><BR>
You can change your password and the next time you login in, the system will accept the new password. Please use a distinctive word (more than 8 letters). </P>

<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="400">
<TR><TD width=150><P>Old password</P></TD><TD width=250><INPUT name=passwd1 type=password></TD></TR>
<TR><TD><P>New password</P></TD><TD><INPUT name=passwd2 type=password></TD></TR>
<TR><TD><P>Confirm New password</P></TD><TD><INPUT name=passwd3 type=password></TD></TR>
</TABLE><BR>
<BR>
<P><B>Email change</B><BR>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="400">

<TR><TD><P>New Email</P></TD><TD><INPUT name=new_email SIZE=30 type=text></TD></TR>
</TABLE>
<P><B>Profile Security </B><BR>
Your Profile is by default visible to all Internet users. You can however set your preferences with respect to visibility of certain information. </P>

<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="400">
<TR><TD width=150><P>Personal Email ID</P></TD>
	<TD width=250><SELECT name=pemail>
		<OPTION value="PUBLIC" <?if($pemail_pref=='PUBLIC')echo 'SELECTED';?> >Public</OPTION>
		<OPTION value="XMEC" <?if($pemail_pref=='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
		<OPTION value="PRIVATE" <?if($pemail_pref=='PRIVATE')echo 'SELECTED';?>>Restricted</OPTION></SELECT></TD></TR>
<TR><TD><P>Official Email ID</P></TD>
	<TD><SELECT name=oemail>
		<OPTION value="PUBLIC" <?if($oemail_pref=='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($oemail_pref=='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION>
		<OPTION value="PRIVATE" <?if($oemail_pref=='PRIVATE')echo 'SELECTED';?>>Restricted</OPTION></SELECT></TD></TR>

<TR><TD><P>Current Address</P></TD>
	<TD><SELECT name=curr>
		<OPTION value="PUBLIC" <?if($curr_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($curr_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION></SELECT></TD></TR>

<TR><TD><P>Company Address</P></TD>
	<TD><SELECT name=comp>
		<OPTION value="PUBLIC" <?if($comp_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($comp_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION></SELECT></TD></TR>

<TR><TD><P>Permanent Address</P></TD>
	<TD><SELECT name=perm>
		<OPTION value="PUBLIC" <?if($perm_visib =='PUBLIC')echo 'SELECTED';?>>Public</OPTION>
		<OPTION value="XMEC" <?if($perm_visib =='XMEC')echo 'SELECTED';?>>XMECians Only</OPTION></SELECT></TD></TR>

</TABLE><BR><BR>
<?php if (0) { //Disabled... ?>
<P><B>XMEC Yahoo groups Subscription </B><BR>
Please specify the Email ID Mailbox that you would want to receive all your XMEC communication. </P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="400">
<TR><TD width=150><P>Email ID</P></TD><TD width=250><SELECT name=select1> <OPTION 
              selected>Official Email ID</OPTION> <OPTION>Personal Email ID</OPTION> 
              </SELECT></TD></TR>

</TABLE><BR><BR>

<P><b>Reminders</b><BR>
Do you wish to receive any reminder on the forthcoming Birthdays of fellow XMECians? </P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0>
<TR><TD><INPUT name=checkbox1 type=checkbox></TD><TD><P>Yes</P></TD></TR>
<TR><TD><INPUT name=checkbox1 type=checkbox></TD><TD><P>No</P></TD></TR>
</TABLE><BR><BR>

<P>Do you wish to receive Newsletters regarding news and events regarding the Alumni? </P>
<TABLE align=center border=0 cellPadding=0 cellSpacing=0>
<TR><TD><INPUT name=checkbox2 type=checkbox></TD><TD><P>Yes</P></TD></TR>
<TR><TD><INPUT name=checkbox2 type=checkbox></TD><TD><P>No</P></TD></TR>
</TABLE><BR><BR>

<?php } //Disabled... ?>

<TABLE align=center border=0 cellPadding=0 cellSpacing=0 width=200>
<TR><TD align=middle><INPUT name=submit1 type=button value=Submit onClick="javascript:validate();"></TD>
<TD align=middle><INPUT name=reset1 type=reset value=Reset></TD></TR>
</TABLE><BR><BR>
</TD>
</TR>

<TR>
<TD colspan=2>
      <TABLE align=center border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TR>
          <TD align=middle height=30 valign=top><A href="members.php"><font face=arial size=-1 color="#669999">Members</font></A> || <A href="disc.htm"><font face=arial size=-1 color="#669999">Disclaimer</font></A> || <A href="sitemap.htm"><font face=arial size=-1 color="#669999">Sitemap</font></A> || <A href="mailto:moderator@xmec.net"><font face=arial size=-1 color="#669999">Comments</font></A></TD>
        </TR>
        <TR>
		</TR>
      </TABLE>
</TD></TR>
</TABLE> 

<?php if ($admin) { ?>

<input type=hidden name=s value=1>
<input type=hidden name=id value=<?=$id?>>

<?php } ?>

<input type=hidden name=todo value="update">
</form>
</div>

<?
include 'footer.php';
?>
