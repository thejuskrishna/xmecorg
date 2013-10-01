<script type="text/javascript">
function add()
{
alert("a")
var mytable=document.getElementById("edu")
var newrow=mytable.insertRow(-1)
var body="<TR><TD class=fbody >University</TD><TD><INPUT class=lbox id=text1 name=univ"+i+"></TD>";
body=body+"<TD nowrap class=fbody>Country</TD><TD><INPUT class=lbox id=text1 name=country"+i+"></TD></TR>";
body=body+"<TR><TD class=fbody >Degree</TD><TD><INPUT class=lbox id=text1 name=degree"+i+"></TD></TR>";
body=body+"<OPTION value=>--- Select ---</OPTION>"+
'<?php
        for ($y=1989; $y<=2011; $y++)
{
if($y==$college->start_year)
{

       echo "<OPTION value=$y selected>$y</OPTION>";
}
else
{
       echo "<OPTION value=$y>$y</OPTION>";
}
}
?>
'+"<TR><TD nowrap class=fbody>Year of completion</TD><TD>"



}
</script>
<TABLE id="edu" border=0 width=500 cellPadding=0 cellSpacing=0 background="">
<INPUT  name=submit type=button value=ADD onClick="javascript:add()"  style="HEIGHT: 24px; WIDTH: 96px">
