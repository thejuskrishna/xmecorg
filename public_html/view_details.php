<?php
	include 'xmec.inc';
        include 'header.php';
	$auth = XMEC::authenticate_user();
	$id = $_GET['id'];
	global $PHP_SELF;
	if ($id != "") {
	    $res = new XMEC_user($id);	
//var_dump($res);
        $colleges=$res->fetchedu();

	    if ($res->fetchInfo())
	    {	
		$pres_addr = $res->getAddress('PRESENT');
		$comp_addr = $res->getAddress('COMPANY');
		$perm_addr = $res->getAddress('PERMANENT');
?>

<div id="profile_page" class="content" align="center">
<TABLE class="box-table" style="width: 50%" cellspacing=0 cellpadding=5 align=center border=0>
<!-- Box starts -->
<?php
if ($refresh==1){
echo"<script>window.opener.refresh()</script>";}
?>

<div style="text-align: center;">
<img height="160" src=<?
$img="profile/thumbnails/".str_replace("/","_",$res->get('id')).".jpg";
if (file_exists($img)) echo $img;
else
{
    $rslt=XMEC::fb_pic($res->get('id'));
    if($rslt!=-1)
    {
        echo "https://graph.facebook.com/$rslt/picture?type=large";
    }
    else
    {
        echo "profile/thumbnails/default.png";
    }
}
?> >
</div>
<TR><TD class=flink bgcolor=#EEEEEE  width=370 align=left>
<strong>XMEC Record</strong></TD><TD class=head bgcolor=#EEEEEE   width=370 align=left>No. RQ00<?=htmlentities($res->get('id'))?>9K</TD></TR>
<TR>
<TD class=flink bgcolor=#EEEEEE width=370 align=left><strong>Engineering Dept</strong></TD>
<TD class=head bgcolor=#EEEEEE   width=370 align=left><?php echo $res->get('branch');?></TD>
</TR>
<TR>
<TD class=flink bgcolor=#EEEEEE  width=370 align=left><strong>Batch</strong></TD>
<TD class=head bgcolor=#EEEEEE width=370 align=left><?=htmlentities($res->get('year'))?></TD>
</TR> 
<TR>
<TD class=flink bgcolor=#EEEEEE width=370 align=left><strong>Name</strong></TD>
<TD class=name bgcolor=#EEEEEE  width=370 align=left><?=htmlentities($res->get('full_name'))?></TD>
</TR>
<TR><TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>Field of Work</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left><?=htmlentities($res->get('work_type'))?></TD></TR> 
<TR>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>Personal Email</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?=XMEC::pref_print(htmlentities($res->get('personal_email')),
		    $res->getPref('personal_email'), $auth);
?>
</TD>
</TR>
<TR>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>Official Email</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?=XMEC::pref_print(htmlentities($res->get('official_email')),
		    $res->getPref('official_email'), $auth);
?>
</TD>
</TR>
<?
if($auth)
{
?>
<TR>
<TD style="border-bottom:1px solid #7c7878" class=flink bgcolor=#FFFFFF  width=370 align=left><strong></strong></TD>
<TD style="border-bottom:1px solid #7c7878" class=fbody bgcolor=#FFFFFF  width=370 align=left></TD>
</TR>

<TR>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>Higher Studies</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left></TD>
</TR>
<TR>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong></strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left></TD>
</TR>

<?
    $i=0;
    if(count($colleges)!=0)
    {
        foreach($colleges as $college)
        {
?>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>College</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?echo $college->univ."</TD></TR><TR>";
?>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>Area of Study</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?echo $college->area."</TD></TR><TR>";?>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>Country</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?echo $college->country."</TD></TR><TR>";?>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>Start Year</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?echo $college->start_year."</TD></TR><TR>";?>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>End year</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?echo $college->end_year."</TD></TR><TR>";?>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>State</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?echo $college->state."</TD></TR><TR>";?>
<TD class=flink bgcolor=#FFFFFF  width=370 align=left><strong>City</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left>
<?echo $college->city."</TD></TR>";
?>
<TR>
<TD style="border-bottom:1px solid #7c7878" class=flink bgcolor=#FFFFFF  width=370 align=left><strong></strong></TD>
<TD style="border-bottom:1px solid #7c7878" class=fbody bgcolor=#FFFFFF  width=370 align=left></TD>
</TR>

<?
}
}
}
?>

<?
  if (($comp_addr->get('house_name') != "") &&
      ($comp_addr->get('visibility') == 'PUBLIC' || 
       ($comp_addr->get('visibility') == 'XMEC' && $auth))) {
?>

<TR>
<TD class=flink bgcolor=#EEEEEE  width=370 align=left valign=top><strong>Organisation</strong></TD>
<TD class=fbody bgcolor=#EEEEEE  width=370 align=left>
<strong><?echo $res->company;?></strong><br>
<? if ($comp_addr->get('street') != "") 
	echo htmlentities($comp_addr->get('street')), "<br>";
   if ($comp_addr->get('area') != "") 
	echo htmlentities($comp_addr->get('area')), "<br>"; 
   if ($comp_addr->get('city') != "") 
	echo htmlentities($comp_addr->get('city')), "<br>";
   if ($comp_addr->get('state') != "") 
	echo htmlentities($comp_addr->get('state')), "<br>";
   if ($comp_addr->get('country') != "") 
	echo htmlentities($comp_addr->get('country')), "<br>";
   if ($comp_addr->get('postal_code') != "") 
	echo htmlentities($comp_addr->get('postal_code')), "<br>";
   if ($comp_addr->get('telephone_no') != "") 
	echo "Ph: ", htmlentities($comp_addr->get('telephone_no')), "<br>";
  }
?>
</TD></TR>

<?
  if (($pres_addr->get('house_name') != "") &&
      ($pres_addr->get('visibility') == 'PUBLIC' || 
       ($pres_addr->get('visibility') == 'XMEC' && $auth))) {
?>

<TR><TD class=flink bgcolor=#FFFFFF  width=370 align=left valign=top><strong>Current Address</strong></TD>
<TD class=fbody bgcolor=#FFFFFF  width=370 align=left><?=htmlentities($pres_addr->get('house_name'))?><br>

<? if ($pres_addr->get('street') != "") 
	echo htmlentities($pres_addr->get('street')), "<br>";
   if ($pres_addr->get('area') != "") 
	echo htmlentities($pres_addr->get('area')), "<br>"; 
   if ($pres_addr->get('city') != "") 
	echo htmlentities($pres_addr->get('city')), "<br>";
   if ($pres_addr->get('state') != "") 
	echo htmlentities($pres_addr->get('state')), "<br>";
   if ($pres_addr->get('country') != "") 
	echo htmlentities($pres_addr->get('country')), "<br>";
   if ($pres_addr->get('postal_code') != "") 
	echo htmlentities($pres_addr->get('postal_code')), "<br>";
   if ($pres_addr->get('telephone_no') != "") 
	echo "Ph: ", htmlentities($pres_addr->get('telephone_no')), "<br>";
  }
?>
</TD></TR>

<?
  if (($perm_addr->get('house_name') != "") &&
      ($perm_addr->get('visibility') == 'PUBLIC' || 
       ($perm_addr->get('visibility') == 'XMEC' && $auth))) {
?>

<TR><TD class=flink bgcolor=#EEEEEE  width=370 align=left valign=top><strong>Permanent Address</strong></TD>
<TD class=fbody bgcolor=#EEEEEE  width=370 align=left><?=htmlentities($perm_addr->get('house_name'))?><br>

<? if ($perm_addr->get('street') != "")
        echo htmlentities($perm_addr->get('street')), "<br>";
   if ($perm_addr->get('area') != "") 
        echo htmlentities($perm_addr->get('area')), "<br>";
   if ($perm_addr->get('city') != "") 
        echo htmlentities($perm_addr->get('city')), "<br>";
   if ($perm_addr->get('state') != "") 
        echo htmlentities($perm_addr->get('state')), "<br>";
   if ($perm_addr->get('country') != "") 
        echo htmlentities($perm_addr->get('country')), "<br>";
   if ($perm_addr->get('postal_code') != "") 
        echo htmlentities($perm_addr->get('postal_code')), "<br>";
   if ($perm_addr->get('telephone_no') != "") 
        echo "Ph: ", htmlentities($perm_addr->get('telephone_no')), "<br>";
  }
?>                                                                      
</TD></TR>
<?php
if (!$auth)echo "<tr><td colspan=2 bgcolor=#8EBBE6  width=370 align=left class=body><i>You may need to <a class=link href=\"login.php?xgetpage=$PHP_SELF?id=$id&refresh=1\"><B>login</B></a> to view the details restricted to XMECians.</td></tr>";
?>
</TABLE>



<?	} else {
	    echo "Details of ", "<strong>",$id,"</strong>"," not found","<br>";
	}

    } else 
	echo "No more details !!\n";
	
?> 
 <!--contents ends-->

<!-- Box ends -->
</div>
<?
include 'footer.php';
?>
