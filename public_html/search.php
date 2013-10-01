<?php
        $no_search_menu = 1;
        $no_left_side = 1;
        include 'header.php';
        include_once 'xmec.inc';

        if ($_s != 1) {
                $name = htmlentities($_GET['name']);
                $worktype = trim($_GET['worktype']);
                $company = trim($_GET['company']);
                $year = trim($_GET['year']);
                $branch = trim($_GET['branch']);
                $location = trim($_GET['location']);
        } else {
                $name = htmlentities($_GET['n']);
                $worktype = trim($_GET['w']);
                $company = trim($_GET['c']);
                $year = trim($_GET['y']);
                $branch = trim($_GET['b']);
                $location = trim($_GET['l']);
        }

        $fil = array();
        if ($name != "" || $worktype != "" || $year != "" ||
                $branch != "" || $company != "" || $location != "") {
                $name != "" && $fil['name'] = $name;
                $worktype != "" && $fil['work_type'] = $worktype;
                $company != "" && $fil['company'] = $company;
                $year != "" && $fil['year'] = $year;
                $branch != "" && $fil['branch'] = $branch;
                $location != "" && $fil['location'] = $location;
        }

        $user =& XMEC::getUser();
?>
<BR>
<div align="center">
    <h1>Access xMECians</h1><br/><br/>
    <TABLE border=0 cellPadding=1 cellSpacing=3 width="85%" ALIGN=CENTER>
        <FORM name=frmsearch method=GET action=search.php>
        <TR>
<?php if($user->isAdmin()) { ?>
            <TD class=body>Name/Roll no</TD>
<? } else { ?>
            <TD class=fbody >Name</TD>
        <? } ?>
            <TD><INPUT class=lbox id=text1 name=name></TD>
            <TD nowrap class=fbody>Batch</TD>
            <TD>
                <SELECT class=cbox style="width:206px" name=year>
                    <OPTION value="">--- Select ---</OPTION>
<?php
$year=date('o');
                    for ($y=1993; $y<=$year; $y++)
                        echo "<OPTION value=\"$y\">$y</OPTION>";
?>
                </SELECT>
            </TD>
        </TR>
        <TR>
            <TD class=fbody>Branch</TD>
            <TD>
                <SELECT class=cbox style="width:206px" name=branch>
                    <OPTION value="">--- Select ---</option>
                    <OPTION value=EBE>Biomedical</OPTION>
                    <OPTION value=CSE>Computer</OPTION>
                    <OPTION value=ECE>Electronics</OPTION>
                    <OPTION value=EEE>Electrical</OPTION>
                </SELECT>
            </TD>
        
            <TD class=fbody>Organisation</TD>
            <TD><INPUT class=lbox id=text2 name=company></TD>
 </TR>
        <TR>
           <TD nowrap class=fbody>Org. Location</TD>
            <TD><INPUT id=text2 class=lbox name=location></TD>
            <TD nowrap class=fbody>Field of Work</TD>

            <TD><INPUT class=lbox id=text1 name=worktype></TD>
        </TR>
        <tr><td>&nbsp;</td></tr>
        <TR>
            <TD></TD>
            <TD align=center><INPUT name=s style="HEIGHT: 24px; WIDTH: 101px" type=submit value=Search></TD>
            <TD align=center><INPUT name=BCancel style="HEIGHT: 24px; WIDTH: 86px" type=reset value=Cancel></TD>
            <TD></TD>
        </TR>
        </FORM>
    </TABLE>

<BR>
<!-- Box ends -->
<?php

        $search_fil = $fil;
        $do_search = TRUE;
        if ($_GET['s'] == "Search") {
            $search_start = 0;
            $search_count = 20;
        } else if ($_GET['s'] == 1) {
            $search_start = $_GET['f'];
            $search_count = $_GET['c'];
        } else {
                $do_search = FALSE;
        }

        if ($do_search) {
                if ($user->isAdmin()) {
			if(preg_match('/\d+/',$fil['name']))
			{
                        $fil['rollno'] = $fil['name'];
                        $fil['name']="";
			$search_fil = $fil;
			}
                        include ('admin_search_results.php');
                } else
                        include ('search_results.php');
        }
?>
</div>
<?
include ('footer.php')
?>

