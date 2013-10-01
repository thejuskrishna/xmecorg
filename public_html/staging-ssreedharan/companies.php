<?php
$secure_page=1;
include 'header.php';
?>
<?php
	if (! XMEC::authenticate_user()) {
		echo "<html><h1>Please login to access this page<html>";
		exit ;
	}
	$me =& XMEC::getUser();
	reset($HTTP_POST_VARS);
	$action = chop($HTTP_POST_VARS["todo"]);
	if ($REQUEST_METHOD == "GET")
		$action = chop($HTTP_GET_VARS["todo"]);
	$sql = chop($HTTP_POST_VARS["sql"]);
	if ($REQUEST_METHOD == "GET")
		$sql = chop($HTTP_GET_VARS["sql"]);
?>

<br/>
<h1>xMEC Statistics >> xMECian Organisation List</h1>
<div align="center">
<br/>

<?
	$sqlbox = "SELECT company, COUNT(*) AS Entries FROM xmec_user GROUP BY company ORDER by Entries DESC LIMIT 1";
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=0>";
			echo "<tr bgcolor=#DDDDDD>";

			while (is_array($x = $r->fetchRow())) {
			  echo "<tr>";
			  echo "<td class =head><p> The total number of xMECians who have not declared the Organisation details is ";
			  for ($i=0; $i<count($x); $i++) echo "<b>$x[$i]</b>";
			  echo "</P><td>";
			  echo "</tr>";
			}
			echo "</table>";
		}
	}

?>
<br/>
<?
	$org = $me->company ;	
	$sqlbox = "SELECT COUNT(*) AS Entries FROM xmec_user where company = '$org' ";
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=0>";
			echo "<tr bgcolor=#DDDDDD>";

			while (is_array($x = $r->fetchRow())) {
			  echo "<tr>";
			  echo "<td class =body><p>The total number of xMECians in your Organisation <b>$me->company </b>is ";
			  for ($i=0; $i<count($x); $i++) echo "<font color=red><b>$x[$i]</b></font>";
			  echo "  </P><td>";
			  echo "</tr>";
			}
			echo "</table>";
		}
	}

?>
<br/><br/>
<?
	$sqlbox = "SELECT company, COUNT(*) AS Entries FROM xmec_user WHERE company <> '' GROUP BY company ORDER by Entries DESC";
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=0>";
			echo "<tr bgcolor=#DDDDDD>";
			echo "<td><b class=title>Organisation</b></td>";
			echo "<td><b class=title>XMECians</b></td>";
			echo "</tr>";
			while (is_array($x = $r->fetchRow())) {
			  echo "<tr>";
			  for ($i=0; $i<count($x); $i++) echo "<td bgcolor=#CFDDD1>$x[$i]</td>";
			  echo "</tr>";
			}
			echo "</table>";
		}
	}

?>

</div>
<?php
include 'footer.php';
?>