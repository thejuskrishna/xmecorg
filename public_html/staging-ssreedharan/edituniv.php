<?php
        include 'xmec.inc';
        $secure_page=1;
        $this_page="profile";
        include 'header.php';
        if (! XMEC::authenticate_user()) {
                echo "<html><h2>Please login to access this page<html>";
                exit ;
        }

        reset($HTTP_POST_VARS);
        $action = chop($HTTP_POST_VARS["todo"]);
        if ($_SERVER['REQUEST_METHOD'] == "GET")
                $action = chop($HTTP_GET_VARS["todo"]);

        $user =& XMEC::getUser();
        if(isset($_POST["BSubmit"]))
        {
            for($cnt=0;$cnt < $_POST["num"]; $cnt+=1)
            {
                $d=array();
                $d["user_id"]=$user->id;
                $d["country"]=$_POST["country".$cnt];
                $d["degree"]=$_POST["degree".$cnt];
                $d["university_name"]=$_POST["univ".$cnt];
                $d["fields_of_study"]=$_POST["area".$cnt];
                $d["start_year"]=$_POST["start_year".$cnt];
                $d["end_year"]=$_POST["end_year".$cnt];
                $d["city"]=$_POST["city".$cnt];
                $d["state"]=$_POST["state".$cnt];
                $d["visibility"]=$_POST["visibility".$cnt];
                $d["row_id"]=$_POST["row_id".$cnt];
                $user->setedu($d);
            }
        }
        $colleges=$user->fetchedu();
        
?>
<script type="text/javascript">
        function add(i)
        {
            var entry="<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr> <TR> <TD class=fbody >University</TD>";
            entry+="<TD><INPUT class=lbox id=text1 name=univ"+i+" value=''></TD> <TD nowrap class=fbody>Degree</TD>";
            entry+="<TD><INPUT class=lbox id=text1 name=degree"+i+" value=''></TD> </TR>";
            entry+="<TR> <TD nowrap class=fbody>Area of Study</TD> <TD><INPUT id=text2 class=lbox name=area"+i+" value=''></TD>";
            entry+="<TD nowrap class=fbody>Country</TD> <TD><INPUT class=lbox id=text1 name=country"+i+" value=''></TD> </TR>";
            entry+="<TR> <TD nowrap class=fbody>Year of Joining</TD> <TD><SELECT class=cbox style='width:144px' name=start_year"+i+" value=''>";
            entry+="<OPTION value=''>--- Select ---</OPTION>";
            var x=0,date=new Date();
            for (x=1989; x<=date.getFullYear(); x++)
            {
                entry+="<OPTION value='"+x+"'>"+x+"</OPTION>";
            }
            entry+="</TD> <TD class=fbody>Year of Completion</TD>";
            entry+="<td><SELECT class=cbox style='width:144px' name=end_year"+i+" value=''>";
            entry+="<OPTION value=''>--- Select ---</OPTION>";
            for (x=1989; x<=date.getFullYear()+6; x++)
            {
                entry+="<OPTION value='"+x+"'>"+x+"</OPTION>";
            }
            entry+="</SELECT></td></TR>";
            entry+="<TR> <TD class=fbody>City</TD> <TD><INPUT id=text2 class=lbox name=city"+i+" value=''></TD>";
            entry+="<TD class=fbody>State</TD> <TD><INPUT id=text2 class=lbox name=state"+i+" value=''></TD>";
            entry+="</TR> <INPUT  name=row_id"+i+" type=hidden value='-1'>";

            $("#no").val(i+1);
            $("#edu").append(entry);
        }
</script>
<div align="center">
    <br><br><h2>Higher Studies Information</h2>
<form method=post action="edituniv.php">
    <input type=hidden name=todo value=null>

    <!--contents starts-->
    <TABLE id="edu" width="85%" >
<?
    $i=0;
    if(count($colleges)!=0)
    {
        foreach($colleges as $college)
        {
?>
            <tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
            <TR> <TD class=fbody >University</TD>
<?
            echo "<TD><INPUT class=lbox id=text1 name=univ".$i." value=\"".$college->univ."\"></TD>";
?>
            <TD nowrap class=fbody>Degree</TD>
            <TD>
<?
            echo "<INPUT class=lbox id=text1 name=degree".$i." value=\"".$college->degree."\">";
?>
            </TD>
            </TR>
            <TR>
            <TD nowrap class=fbody>Area of Study</TD>
<?
            echo "<TD><INPUT id=text2 class=lbox name=area".$i." value=\"".$college->area."\"></TD>";
?>
            <TD nowrap class=fbody>Country</TD>
<?
            echo "<TD><INPUT class=lbox id=text1 name=country".$i." value=\"".$college->country."\"></TD>";
?>
            </TR>
        <TR>
            <TD nowrap class=fbody>Year of Joining</TD>
            <TD>
<?
            echo "<SELECT class=cbox style=\"width:144px\" name=start_year".$i." value=\"".$college->start_year."\">";
?>
            <OPTION value="">--- Select ---</OPTION>
<?php
            for ($y=1989; $y<=2011; $y++)
            {
                if($y==$college->start_year)
                    echo "<OPTION value=\"$y\"selected>$y</OPTION>";
                else
                    echo "<OPTION value=\"$y\">$y</OPTION>";
            }
        
?>
            </SELECT>
            </TD>
            <TD class=fbody>Year of Completion</TD>
            <td>
<?
            echo "<SELECT class=cbox style=\"width:144px\" name=end_year".$i." value=\"".$college->start_year."\">";
?>
            <OPTION value="">--- Select ---</OPTION>
<?php
            for ($y=1989; $y<=2020; $y++)
            {
                if($y==$college->end_year)
                    echo "<OPTION value=\"$y\"selected>$y</OPTION>";
                else
                    echo "<OPTION value=\"$y\">$y</OPTION>";
            }

?>
            </SELECT>
            </td>
        </TR>
        <TR>
            <TD class=fbody>City</TD>
<?
            echo "<TD><INPUT id=text2 class=lbox name=city".$i." value=\"".$college->city."\"></TD>";
?>
            <TD class=fbody>State</TD>
<?
            echo "<TD><INPUT id=text2 class=lbox name=state".$i." value=\"".$college->state."\"></TD>";
?>
<?
            echo "</TR>
                <INPUT  name=row_id".$i." type=hidden value=".$college->row_id.">";
            $i++;
        }
    }
?>
    </TR>
</TABLE>
<br><br>
<?
echo "<div><INPUT type=button value='New' onClick=\"javascript:add(".$i.")\"  style=\"HEIGHT: 24px; WIDTH: 96px\">";
echo "<INPUT  name=num type=hidden value=\"".$i."\">";
?>
      <INPUT  name=BSubmit type=submit value=Update  style="HEIGHT: 24px; WIDTH: 96px">
      </div>
</FORM>
</div>
<?php
include 'footer.php';
?>
