<script>
function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

	var nameEQ = "fbsr_101039650020031";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) alert(c.substring(nameEQ.length,c.length));
	}

createCookie(nameEQ,"",-1);
</script> 

<?php           
include 'xmec.inc';
if(XMEC::authenticate_fb())
{

if(isset($_SESSION["__fb_user"]))
{
?>
<script>
alert(document.cookie);
</script>
<?
echo $_SESSION["__fb_user"]->destroySession() ;
echo $_SESSION["__fb_user"]->getLogoutUrl();
unset($_COOKIE['fbsr_' . $_SESSION["__fb_user"]->getAppId()]);
}
}
else
{
echo "hahah";
}
?>

