<?php
$secure_page=0;
$this_page="loginerror";
$no_search_menu=1;
include 'header.php';
?>

<script type="text/javascript" src="jslibxmec.js"></script>
<script type="text/javascript">

function check()
{
  if (validate())
    document.loginerror.submit();
}

function validate()
{
    if (document.loginerror.Batch.value == ""){
        alert("Please Select your Batch");
        return false;
    }
    if (document.loginerror.Rollno.value == ""){
        alert("Please record your College Roll Number ");
        return false;
    }
    if(!CheckEmailStr(document.loginerror.email.value )){
        alert("Please verify Personal Email");
        return false;
    }
    if((document.loginerror.Dob.value == "" ) ||(false == CheckDate(document.loginerror.Dob.value)) || (IsDateGreaterToday(document.loginerror.Dob.value))){
        alert("Please Enter the correct Date of Birth. Use dd/mm/yyyy format");
        return false;
    }
    return true;
}

</script>

<!--center starts-->

<BR>
<h1><B>Login Help >></B> Request Password Change</h1>
<div align="center">
    <TABLE cellSpacing=0 cellPadding=4 border=0 width=75% align=center>
        <TR>
            <TD>
                <BR><BR>Please enter the required details. The xMEC Webmasters will send the changed password to your Personal E-mail address.</strong>
                <form name="loginerror" method="post" action="maildetails.php">
                    <input type=hidden name="recipient" value="webmasters@xmec.addr.com">
                    <INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net] Password Reset">
                    <input type=hidden name="redirect" value="http://www.xmec.net/thankyou.php">
                    <TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH=100%>
                        <TR>
                            <TD width=40% class=body><B>Batch</B></TD>
                            <TD width=60% colspan=2>
                                <SELECT NAME="Batch" class=cbox>
                                   <OPTION value="" selected>Select One</OPTION>
<?php
		    $year=date('o');
                    for ($y=1993; $y<=$year; $y++)
                        echo "<OPTION value=\"$y\">$y</OPTION>";
?>
                                </SELECT>
                            </TD>
                        </TR>
                        <TR>
                            <TD width=40% class=body><B>First Name</B></TD>
                            <TD width=60% colspan=2><INPUT NAME="name" SIZE=30 class=lbox></TD>
                        </TR>
                           <TR>
                            <TD width=40% class=body><B>Middle Name</B></TD>
                            <TD width=60% colspan=2><INPUT NAME="middle_name" SIZE=30 class=lbox></TD>
                        </TR>
                       <TR>
                            <TD width=40% class=body><B>Last Name</B></TD>
                            <TD width=60% colspan=2><INPUT NAME="last_name" SIZE=30 class=lbox></TD>
                        </TR>
                       <TR>
                            <TD width=40% class=body><B>Roll No</B></TD>
                            <TD width=60% colspan=2><INPUT NAME="Rollno" SIZE=30 class=lbox></TD>
                        </TR>
                       <TR>
                            <TD width=40% class=body><STRONG>Email ID</STRONG></TD>
                            <TD width=60% colspan=2><INPUT NAME="email" SIZE=30 class=lbox></TD>
                        </TR>
                        <TR>
                            <TD width=40% class=body><STRONG>Date of Birth</STRONG></TD>
                            <TD width=100><INPUT name=Dob size=30 class=lbox></TD>
                            <TD width=200 class=body><I>[dd/mm/yyyy]</I></TD>
                        </TR>
                        <TR>
                            <TD width=40% class=body><STRONG>Email or Password</STRONG></TD>
			<TD><input type="radio" name="change" value="email_id" />Email &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="change" value="password" />Password<br /></TD>
			</TR>
                        
			<TR>
                            <TD></TD>
                            <TD colspan=2>
                                <INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check()">
                            </TD>
                        </TR>
                    </TABLE>
                </form>
            </TD>
        </TR>
    </TABLE>
</div>
<!--Content ends-->
<?php
include 'footer.php';
?>
