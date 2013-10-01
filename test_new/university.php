<?php
        $no_search_menu = 1;
        $no_left_side = 1;
        include 'header.php';
	$university=1;
        if ($_s != 1) {
                $univ = trim($_GET['univ']);
                $country = trim($_GET['country']);
                $degree = trim($_GET['degree']);
                $year = trim($_GET['year']);
                $area = trim($_GET['area']);
                $state = trim($_GET['state']);
        } else {
                $univ = trim($_GET['n']);
                $country = trim($_GET['c']);
                $degree = trim($_GET['d']);
                $year = trim($_GET['y']);
                $area = trim($_GET['a']);
                $state = trim($_GET['st']);
        }

        $fil = array();
        if ($univ != "" || $country != "" || $year != "" ||
                $area != "" || $degree != "" || $state != "") {
                $univ != "" && $fil['univ'] = $univ;
                $country != "" && $fil['country'] = $country;
                $degree != "" && $fil['degree'] = $degree;
                $year != "" && $fil['year'] = $year;
                $area != "" && $fil['area'] = $area;
                $state != "" && $fil['state'] = $state;
        }

        $user =& XMEC::getUser();

?>
<BR>
<div id="univ_page" class="content" align="center">
<TABLE align=center cellSpacing=0 cellPadding=0 border=0>
<TBODY>
        <TR>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        <TD align=left background=images/tb_top.gif height=4><IMG height=4 src="images/tb_left_topt.gif" width=8></TD>
        <TD align=right background=images/tb_top.gif height=4><IMG height=4 src="images/tb_right_topt.gif" width=8></TD>
        <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
    </TR>
    <TR>
                <TD vAlign=top width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_topb.gif" width=3></TD>
                <TD colSpan=2 rowSpan=2>
                        <!--contents starts-->

<TABLE border=0 cellPadding=1 cellSpacing=1 width="85%" ALIGN=CENTER>
        <FORM name=frmsearch method=GET action=university.php>
  <TR bgcolor=#EEEEEE>
    <TD></TD>
    <TD colSpan=2 align=center class=head bgcolor=#EEEEEE><B>ACCESS xMECians</B></TD>
    <TD></TD>
        </TR>
  <TR>
    <TD></TD>
    <TD colSpan=2></TD>
    <TD></TD>
        </TR>
  <TR>
<?php if($user->isAdmin()) { ?>
                <TD class=body>University</TD>
<? } else { ?>
                <TD class=fbody >University</TD>
<? } ?>
    <TD><INPUT class=lbox id=text1 name=univ></TD>
    <TD nowrap class=fbody>Country</TD>
    <TD>
                        <INPUT class=lbox id=text1 name=country>
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
    <TD class=fbody>Area of study</TD>
    <TD><INPUT id=text2 class=lbox name=area></TD>
        </TR>
  <TR>
     <TD class=fbody>State</TD>
    <TD><INPUT id=text2 class=lbox name=state></TD>
     <TD class=fbody>Degree</TD> 
    <TD><INPUT id=text2 class=lbox name=degree></TD>

    </TR>
    <TR>
    <TD></TD>
    <TD align=center>
      <INPUT name=s style="HEIGHT: 24px; WIDTH: 101px" type=submit value=Search></TD>
    <TD align=center><INPUT name=BCancel style="HEIGHT: 24px; WIDTH: 86px" type=reset value=Cancel></TD>
                <TD></TD>
        </TR>
</TABLE>

</P>
</form>
 <!--contents ends-->
                </TD>
                <TD vAlign=top width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_topb.gif" width=3></TD>
        </TR>
        <TR>
                <TD vAlign=bottom width=4 background=images/tb_left.gif height="50%"><IMG height=6 src="images/tb_left_bottomb.gif" width=3></TD>
                <TD vAlign=bottom width=4 background=images/tb_right.gif height="50%"><IMG height=6 src="images/tb_right_bottomb.gif" width=3></TD>
        </TR>
    <TR>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
                <TD align=left background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_left_bottomt.gif" width=8></TD>
                <TD align=right background=images/tb_bottom.gif height=4><IMG height=4 src="images/tb_right_bottomt.gif" width=8></TD>
                <TD width=4 height=4><IMG height=4 src="images/corner.gif" width=4></TD>
        </TR>
        </TBODY>
</TABLE>
</div>
<!-- Box ends -->
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
                        include ('search_results.php');
                } else
                        include ('search_results.php');
        }
?>
<?
include ('footer.php')
?>
