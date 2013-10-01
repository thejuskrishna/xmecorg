<?php
        $no_search_menu = 1;
        $no_left_side = 1;
	$university=0;
        include 'header.php';

        if ($_s != 1) {
                $name = trim($_GET['name']);
                $worktype = trim($_GET['worktype']);
                $company = trim($_GET['company']);
                $year = trim($_GET['year']);
                $branch = trim($_GET['branch']);
                $location = trim($_GET['location']);
        } else {
                $name = trim($_GET['n']);
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

<div class="content" id="search_page">
<table class="box-table" id="search_table" border=0 cellPadding=1 cellSpacing=1 width="85%" ALIGN=CENTER>
        <FORM name=frmsearch method=GET action=search.php>
  <TR bgcolor=#EEEEEE>
    <TD></TD>
    <TD colSpan=2 align=center class=head bgcolor=#EEEEEE><B>ACCESS XMECians</B></TD>
    <TD></TD>
        </TR>
  <TR>
    <TD></TD>
    <TD colSpan=2></TD>
    <TD></TD>
        </TR>
  <TR>
<?php if($user->isAdmin()) { ?>
                <TD class=body>Name/Roll no</TD>
<? } else { ?>
                <TD class=fbody >Name</TD>
<? } ?>
    <TD><INPUT class=lbox id=text1 name=name></TD>
    <TD nowrap class=fbody>Designation</TD>
    <TD>
                        <INPUT class=lbox id=text1 name=workrole>
                </TD>
        </TR>
        <TR>
    <TD nowrap class=fbody>Year of Joining</TD>
    <TD>
      <SELECT class=cbox style="width:144px" name=year>
        <OPTION value="">--- Select ---</OPTION>
<?php
        for ($y=1989; $y<=2001; $y++)
        echo "<OPTION value=\"$y\">$y</OPTION>";
?>
      </SELECT>
    </TD>
    <TD class=fbody>Branch</TD>
    <TD>
      <SELECT class=cbox style="width:144px" name=branch>
        <OPTION value="">--- Select ---</option>
        <OPTION value=BE>Biomedical</OPTION>
        <OPTION value=CE>Computer</OPTION>
        <OPTION value=EE>Electronics</OPTION>
      </SELECT>
    </TD>
    </TR>
  <TR>
                <TD class=fbody>Organisation</TD>
    <TD><INPUT class=lbox id=text2 name=company></TD>

    <TD nowrap class=fbody>Org. Location</TD>
    <TD><INPUT id=text2 class=lbox name=location></TD>
        </TR>
  <TR>
    <TD nowrap class=fbody>Field of Work</TD>
    <TD>
      <SELECT class=cbox name=worktype>
        <OPTION value="">--- Any ---</OPTION>
<?php
        $wrk = XMEC::get_work_types();
        for ($i = 0; $i < sizeof($wrk); $i++)
        echo "<OPTION value=\"". htmlentities($wrk[$i]) . "\">".htmlentities($wrk[$i]). "</OPTION>";
?>
      </SELECT>
    </TD>
    </TR>

    <TR>
    <TD></TD>
    <TD align=center>
      <INPUT name=s style="HEIGHT: 24px; WIDTH: 101px" type=submit value=Search></TD>
    <TD align=center><INPUT name=BCancel style="HEIGHT: 24px; WIDTH: 86px" type=reset value=Cancel></TD>
                <TD></TD>
       </TR>
        </form>
</TABLE>

</P>

 
<?php

        $search_fil = $fil;
        $do_search = TRUE;
        if ($_GET['s'] == "Search") {
            $search_start = 0;
            $search_count = 20;
        } else if ($_GET['_s'] == 1) {
            $search_start = $_GET['f'];
            $search_count = $_GET['c'];
        } else {
                $do_search = FALSE;
        }

        if ($do_search) {
                if ($user->isAdmin()) {
                        //$fil['rollno'] = $fil['name'];
                        //$search_fil = $fil;
                        include ('admin_search_results.php');
                } else
                        include ('search_results.php');
        }
?>
</div>
<?
include ('footer.php')
?>