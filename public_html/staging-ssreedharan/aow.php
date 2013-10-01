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
<h1>xMEC Statistics >> xMECian Work Profile List</h1>
<div align="center">
<br/>

<?
	$sqlbox = "SELECT work_type, COUNT(*) AS Entries FROM xmec_user GROUP BY work_type ORDER by Entries DESC LIMIT 1";
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=0 width='85%'>";
			echo "<tr bgcolor=#DDDDDD>";
			  echo "<tr>";
			  echo "<td class =body colspan=2><p>xMEC profile defines the Field of Work (Area of Expertise ) as a mandatory information while Designation is optional. The Field of Work information helps MEC students and other XMECians to locate experienced hands in the domain that they are interested in or need assistance in.</P><P class=name><b>However there are many profiles where the Field of Work is mistaken and misinformed as Designation. For eg. <i>Software Engineer</i> is a Designation and <i>Software Design</i> or <i>C, C++,Unix</i> is the Field of Work</b>.<BR><BR></P></td></tr><tr> ";
echo "<td colspan=2 align=left><P class=head><B>Profile Details for $me->first_name </B></P></td></tr><tr>";
echo "<td><P class=body>Field of Work</P></td><td><P><b> $me->work_type</B></P></td></tr><tr>";
echo "<td><P class=body>Designation (optional) </P></td><td><P><B> $me->msn </B><BR></P></td></tr><tr>";
echo "<td></td><td><P><b><A href=editprofile.php class=flink>Do you want to change your profile ?</A></B></P></td>";

			  echo "</tr>";
			echo "</table>";
		}
	}

?>

<br/><br/>

<?
	$sqlbox = "SELECT work_type, COUNT(*) AS Entries FROM xmec_user WHERE work_type <> '' GROUP BY work_type ORDER by Entries DESC";
	$dbh =& XMEC::getDB();
	if (DB::isManip($sqlbox)) {
		echo "No manipulation queries please !";
	} else {
		$r = $dbh->query(XMEC_user::unQuote($sqlbox));
		if (DB::isError($r)) {
			echo "Query: $sql failed.";
		} else {
			echo "<table border=0 width='40%'>";
			echo "<tr bgcolor=#DDDDDD>";
			echo "<td><b class=title>Field of Work</b></td>";
			echo "<td><b class=title>xMECians</b></td>";
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