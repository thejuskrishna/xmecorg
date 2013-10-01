<?php
   global $PHP_SELF;
   if(isset($university))
   {
   	  $res =& XMEC::univ_search($search_fil, $search_start, $search_count);
	  $link="<A href=$PHP_SELF?n=".urlencode($search_fil['univ'])."&w=".urlencode($search_fil['country'])."&c=".urlencode($search_fil['degree'])."&y=".urlencode($search_fil['year'])."&b=".urlencode($search_fil['area'])."&l=".urlencode($search_fil['state'])."&f=";
   }
   else
   {
	 $res =& XMEC::search($search_fil, $search_start, $search_count);
         $link="<A href=$PHP_SELF?name=".urlencode($search_fil['name'])."&workrole=".urlencode($search_fil['work_type'])."&company=".urlencode($search_fil['company'])."&year=".urlencode($search_fil['year'])."&branch=".urlencode($search_fil['branch'])."&location=".urlencode($search_fil['location'])."&f=";
   }
   $no_links = 5; // half the no. of navigation links (1 2 3...)
?>
<BR>
<TABLE border=0 cellPadding=0 cellSpacing=3 width=90%>

<?php
$total = $res['total'];
if ($res['total'] > $search_count ) {
    $rem = (int)(($res['total'] + $search_count - 1)/ $search_count);
    $current = (int)(($search_start + $search_count - 1)/$search_count);

    echo "<TR>";
    echo "<TD align=left>";
    if ($search_start > 0)
        echo $link.(($current - 1)*$search_count)."&c=$search_count&s=1 class=link><img src=images/back.gif border=0></A></TD>";
    else
	echo "&nbsp;</TD>";

    echo "<TD align=center colspan=2>";

	if ($current - $no_links < 0)
		$xfrom = 0;
	else
		$xfrom = $current - $no_links;

	$xto = $xfrom + $no_links * 2;

	if ($xto > $rem) {
		$xto = $rem;
		$xfrom = $rem - $no_links * 2;
		if ($xfrom < 0)
			$xfrom = 0;
	}

        for ($i = $xfrom; $i < $xto; $i++) {
		if ($i == $current) {
			echo "<b>";
		echo "<span class='page_no'>";
		}
        echo $link.($i*$search_count)."&c=$search_count&s=1>".($i+1)."</A>&nbsp";
		if ($i == $current) {

    			echo "</span>";
			echo "</b>";
		}
        }
    echo "</TD>";
    echo "<TD align=right>";
    if ($search_start + $search_count < $total)
        echo $link.(($current + 1)*$search_count)."&c=$search_count&s=1 class=link><img src=images/next.gif border=0></A></TD>";
    else
	echo "&nbsp;</TD>";
    echo "</TR>";
}
if($university)
{
?>
        <TR bgcolor="#E7F3CC">
                <TD><b class=head>Name</b></TD>
                <TD><b class=head>University</b></TD>
                <TD><b class=head>Degree</b></TD>
                <TD><b class=head>Area</b></TD>
                <TD><b class=head>State</b></TD>
                <TD><b class=head>Country</b></TD>

        </TR>

<?php
    for ($i = 0; $i < $res['count']; $i++) {
            echo "<TR". (($i%2)?" bgcolor=\"#E7F3FB\">":">");
            if($res[$i]->id==$res[$i]->alias)
                $identity=$res[$i]->id;
            else
                $identity=$res[$i]->alias;

	    echo "<TD><A href=\"view_details.php?s=1&id=".rawurlencode($res[$i]->id)."\" class=link>".htmlentities($res[$i]->name)."</a></TD>\n";
            echo "<TD class=body>". ($res[$i]->univ == ""?"&nbsp;":htmlentities($res[$i]->univ)) . "</TD>";
            echo "<TD class=body>" . ($res[$i]->degree == ""?"&nbsp;":htmlentities($res[$i]->degree)). "</TD>";
            echo "<TD class=body>" . ($res[$i]->area == ""?"&nbsp;":htmlentities($res[$i]->area)). "</TD>";
            echo "<TD class=body>" . ($res[$i]->state == ""?"&nbsp;":htmlentities($res[$i]->state)). "</TD>";
            echo "<TD class=body>" . ($res[$i]->country == ""?"&nbsp;":htmlentities($res[$i]->country)). "</TD>";

            echo "</TR>\n";
    }

}
else
{
?>
	<TR bgcolor="#E7F3CC">
		<TD><b class=head>Name</b></TD>
		<TD><b class=head>Organisation</b></TD>
		<TD><b class=head>Location</b></TD>
		<TD><b class=head>Branch</b></TD>
		<TD><b class=head>Batch</b></TD>
	</TR>

<?php
    for ($i = 0; $i < $res['count']; $i++) {
            echo "<TR". (($i%2)?" bgcolor=\"#E7F3FB\">":">");
	    echo "<TD><A href=\"view_details.php?s=1&id=".rawurlencode($res[$i]->id)."\" class=link>".htmlentities($res[$i]->name)."</a></TD>\n";
            echo "<TD class=body>". ($res[$i]->company == ""?"&nbsp;":htmlentities($res[$i]->company)) . "</TD>";
            echo "<TD class=body>" . ($res[$i]->location == ""?"&nbsp;":htmlentities($res[$i]->location)). "</TD>";
            echo "<TD class=body>" . ($res[$i]->branch == ""?"&nbsp;":htmlentities($res[$i]->branch)). "</TD>";
            echo "<TD class=body>" . ($res[$i]->year == ""?"&nbsp;":htmlentities($res[$i]->year)). "</TD>";
            echo "</TR>\n";
    }
}
$total = $res['total'];
if ($res['total'] > $search_count ) {
    $rem = (int)(($res['total'] + $search_count - 1)/ $search_count);
    $current = (int)(($search_start + $search_count - 1)/$search_count);

    echo "<TR>";
    echo "<TD align=left>";
    if ($search_start > 0)
        echo $link.(($current - 1)*$search_count)."&c=$search_count&s=1 class=flink><img src=images/back.gif border=0></A></TD>";
    else
	echo "&nbsp;</TD>";

    echo "<TD align=center colspan=2>";

        for ($i = $xfrom; $i < $xto; $i++) {
		if ($i == $current) {
			echo "<b>";
		echo "<span class='page_no'>";
		}
        echo $link.($i*$search_count)."&c=$search_count&s=1>".($i+1)."</A>&nbsp;";
		if ($i == $current) {
    			echo "</span>";
			echo "</b>";
		}
        }
    echo "</TD>";
    echo "<TD align=right>";
    if ($search_start + $search_count < $total)
        echo $link.(($current + 1)*$search_count)."&c=$search_count&s=1 class=flink><img src=images/next.gif border=0></A></TD>";
    else
	echo "&nbsp;</TD>";
    echo "</TR>";
}
?>
	<TR>
	<!--	<TD colspan=5 bgcolor="#CFDDD1" height=2><img src="images/space.gif"></TD> -->
	</TR>
</TABLE>
<BR>
<!-- Box ends -->
