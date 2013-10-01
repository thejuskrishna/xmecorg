<?php
        $no_search_menu = 1;
        $no_left_side = 1;
        include 'header.php';
	$university=1;
        $auth = XMEC::authenticate_user();

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
if($auth)
{
?>
<BR>
<!-- Box starts -->
<div align="center">
    <h1>Access xMECians</h1><br/><br/>
    <TABLE border=0 cellPadding=1 cellSpacing=3 width="75%" ALIGN=CENTER>
        <FORM name=frmsearch method=GET action=university.php>
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
                <SELECT class=cbox style="width:206px" name=year>
                <OPTION value="">--- Select ---</OPTION>
                <?php
                for ($y=1989; $y<=2011; $y++)
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
            <tr><td>&nbsp;</td></tr>
            <TR>
                <TD></TD>
                <TD align=center>
                <INPUT name=s style="HEIGHT: 24px; WIDTH: 101px" type=submit value=Search></TD>
                <TD align=center><INPUT name=BCancel style="HEIGHT: 24px; WIDTH: 86px" type=reset value=Cancel></TD>
                <TD></TD>
            </TR>
        </FORM>
    </TABLE>
    <br/>
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
            include ('search_results.php');
        }
?>
</div>
<?
}
else
{
echo "Please login with your xmec creds";
}
include ('footer.php')
?>

