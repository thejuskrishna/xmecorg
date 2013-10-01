<html><title>Email Sent to Webmaster</title>
<?php

$messagex = "$_POST[messages] \n\n"."$_POST[details] \n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
mail($_POST['recipient'], $_POST['subject'], $messagex, "From:{$_POST['sender']}\r\n"."Cc:{$_POST['ccrecipient']}\r\n"."Bcc:{$_POST['bccrecipient']}, vyas.thottathil@gmail.com\r\n") ;
?>
<SCRIPT>document.location.href="thankyou.php";
</SCRIPT></html>
