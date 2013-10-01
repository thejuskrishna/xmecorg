<?php
	include 'header.php';
	$auth = XMEC::authenticate_user();
	$user =& XMEC::getUser();
	if(!$user->isAdmin()) {
		echo '<BR><BR><H2><CENTER>You Are Not Authorized !</CENTER></H2>';
	include 'footer.php';
	exit ;
	}
?>
<div align="center">
    <br/><br/>
    <table cellpadding="1" cellspacing="10" width="50%">
        <tr>
            <td><A HREF="/statistics.php" class=link>Site Statistics</A></td>
            <td><A HREF="/updations.php" class=link>Profile Updations</A></td>
        </tr>
        <tr>
            <td><A HREF="/polls.php?action=poll_admin" class=link>Poll Admin</A></td>
            <td><A HREF="/caladmin.php" class=link>Calendar Admin</A></td>
        </tr>
        <tr>
            <td><A HREF="/sql_query.php" class=link>xMEC Database Access</A></td>
            <td><A HREF="/broadcast.php" class=link>xMEC Broadcast Mailer</A></td>
        </tr>
        <tr><td><A HREF="/import.php" class=link>Import Student Data</A></td></tr>
    </table>
</div>
<?php
include 'footer.php';
?>
