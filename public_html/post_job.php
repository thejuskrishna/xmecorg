<?php
	$secure_page=1;
	$this_page="job";
	$no_left_side = 1;
	include 'header.php';
	include_once 'xmec.inc';
	include_once 'xmec_jobs.php';
	$user = XMEC::getUser();

$category = array(
"Software",
"Hardware",
"Biomedical",
"Marketing",
"Management"
);
?>

<?php
function showJobPost($action, $post_id=NULL) {
	if ($action == "view_details") {
		$job = getJobPostDetails($post_id);
	}
?>
<br/>
<div align="center">
<h1>Post a Job</h1>
<br/><br/>
<TABLE width=75% cellspacing=10 cellpadding=0 border=0><TBODY>
<?php if ($action == "post") { ?>
<FORM NAME=post_job ACTION=post_job.php?action=do_post METHOD=post>
<INPUT TYPE=hidden NAME=action VALUE="do_post">
<?php } ?>
<TR>
	<TD width="100px" class=name><b>Company</b></TD>
	<TD>
<?php
		if ($action == "view_details") {
			echo $job[1];
		} else {
			echo "<INPUT CLASS=lbox NAME=company VALUE=>";
		}
?>
	</TD>
	<TD width="100px" class=name><b>Experience</b></TD>
	<TD>
<?php
		if ($action == "view_details") {
			echo $job[2] . " To " . $job[3];
		} else {
		echo "
		<SELECT CLASS=cbox NAME=lyof>
			<OPTION VALUE=0>Fresher</OPTION>
			<OPTION VALUE=1>1</OPTION>
			<OPTION VALUE=2>2</OPTION>
			<OPTION VALUE=3>3</OPTION>
			<OPTION VALUE=4>4</OPTION>
			<OPTION VALUE=5>-</OPTION>
		</SELECT> To
		<SELECT CLASS=cbox NAME=uyof>
			<OPTION VALUE=0>Fresher</OPTION>
			<OPTION VALUE=1>1</OPTION>
			<OPTION VALUE=2>2</OPTION>
			<OPTION VALUE=3>3</OPTION>
			<OPTION VALUE=4>4</OPTION>
			<OPTION VALUE=5>>5</OPTION>
		</SELECT>";
		}
?>
	</TD>
</TR>
<TR>
	<TD class=name ><b>Contact Name</b></TD>
	<TD>
<?php
		if ($action == "view_details") {
			echo $job[4];
		} else {
			echo "<INPUT CLASS=lbox NAME=referer VALUE=>";
		}
?>
	</TD>
	<TD><b>Contact Email</b></TD>
	<TD>
<?php
		if ($action == "view_details") {
			echo $job[5];
		} else {
			echo "<INPUT CLASS=lbox NAME=refemail VALUE=>";
		}
?>
	</TD>
</TR>
<TR>
	<TD><b>Category</b></TD>
	<TD>
<?php
/* WORKAROUND */
$category = array(
"Software",
"Hardware",
"Biomedical",
"Marketing",
"Management"
);
/* WORKAROUND */
		if ($action == "view_details") {
			echo $category[$job[6]];
		} else {
		echo "
		<SELECT CLASS=cbox NAME=fow>
			<OPTION VALUE=0>".$category[0]."</OPTION>
			<OPTION VALUE=1>".$category[1]."</OPTION>
			<OPTION VALUE=2>".$category[2]."</OPTION>
			<OPTION VALUE=3>".$category[3]."</OPTION>
			<OPTION VALUE=4>".$category[4]."</OPTION>
		</SELECT>";
		}
?>
	</TD>
	<TD><b>Keywords</b></TD>
	<TD>
<?php
		if ($action == "view_details") {
			echo $job[7];
		} else {
			echo "<INPUT CLASS=lbox NAME=keywords VALUE=>";
		}
?>
	</TD>
</TR>
<TR>
	<TD><b>Details</b><sup>*</sup></TD>
	<TD colspan="3" rowspan="3">
<?php
		if ($action == "view_details") {
			echo '<pre>'.$job[8].'</pre>';
		} else {
			echo "<TEXTAREA CLASS=tbox NAME=details MAXLENGTH=80 rows='10' cols='80'></TEXTAREA>";
		}
?>
<br/>
<P class=name><sup>*</sup> Paste the contents of the requirement mail in this section</P><BR>
	</TD>
</TR>
<?php if ($action == "post") { ?>
<tr>&nbsp;</tr><tr>&nbsp;</tr><tr>&nbsp;</tr>
<TR ALIGN=CENTER>
	<TD COLSPAN=4><INPUT TYPE=submit VALUE="Post"></TD>
</TR>
</FORM>
<?php } ?>
</TBODY></TABLE>
</div>
<!--Box Ends-->
<?php
}
?>
<?php
$action = chop($HTTP_GET_VARS["action"]);
if ($action == "") {
	$action = "view";
}
?>

<?php
	if ($action=="post") {
		showJobPost($action);
	}
?>

<?php
	if ($action=="do_post") {
		$tmp_comp = chop($HTTP_POST_VARS["company"]);
		$tmp_lyof = chop($HTTP_POST_VARS["lyof"]);
		$tmp_uyof = chop($HTTP_POST_VARS["uyof"]);
		$tmp_ref = chop($HTTP_POST_VARS["referer"]);
		$tmp_email = chop($HTTP_POST_VARS["refemail"]);
		$tmp_fow = chop($HTTP_POST_VARS["fow"]);
		$tmp_keyw = chop($HTTP_POST_VARS["keywords"]);
		$tmp_det = chop($HTTP_POST_VARS["details"]);
		doJobPost($tmp_comp, $tmp_lyof, $tmp_uyof, $tmp_ref,
							$tmp_email, $tmp_fow, $tmp_keyw, $tmp_det);
		echo "Thank you for submitting this posting to XMEC.<br>";
	}
?>

<?php
	if ($action=="view_details") {
	$post_id=chop($HTTP_GET_VARS["post_id"]);
		showJobPost($action,$post_id);
	}
?>

<?php
	if ($action=="view") {
?>
<!--Box Starts-->
<br/>
<h1>xMEC Job Postings</h1>
<br/><br/>
<div align="center">
<TABLE WIDTH="90%">
<THEAD class=head bgcolor=#EEEEEE>
	<TD><B>Company</B></TD>
	<TD><B>Category</B></TD>
	<TD><B>Experience (Yrs)</B></TD>
	<TD><B>Keywords</B></TD>
	<TD><B>Post Date</B></TD>
</THEAD>
<TBODY>
<?php

		$posts = getJobPosts();
		for($i=0;$i<count($posts);$i++) {
			if ($i%2)
			$colored = " BGCOLOR=#CFDDD1 ";
			else
			$colored = " BGCOLOR=#CFDDD1 ";
			$post = $posts[$i];
			echo "
<TR". $colored .">
	<TD><A class=link HREF=\"/post_job.php?action=view_details&post_id=".$post[0]."\">".$post[1]."</A></TD>
	<TD align=center>".$category[$post[6]]."</TD>
	<TD align=center>".$post[2]."-".$post[3]."</TD>
	<TD>".$post[7]."</TD>
	<TD>".$post[10]."</TD>
</TR>
";
			/* echo $post[1]." ".$post[2]."-".$post[5].
			" ".$post[6]." ".$post[9]."<br>"; */
		}
?>
</TBODY>
</TABLE>
<br/><br/>
<CENTER><A class=flink HREF="/post_job.php?action=post"><IMG src="images/email.gif">&nbsp;Post a Job to XMEC</A></CENTER>
</div>
<!--Box Ends-->
<?php
	}
?>


<?php
include 'footer.php';
?>
