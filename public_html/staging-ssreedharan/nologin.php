<?php
$secure_page=0;
include 'header.php';
?>
<script type="text/javascript" src="jslibxmec.js"></script>
<script type="text/javascript">

function check()
{
    if (validate())
        document.nologin.submit();
}

function validate()
{
    if (document.nologin.Batch.value == ""){
        alert("Please Select your Batch");
        return false;
    }
    if (document.nologin.Rollno.value == ""){
        alert("Please record your College Roll Number ");
        return false;
    }
    if (document.nologin.Name.value == "") {
        alert("Please enter your Name");
        return false;
    }
    if(!CheckEmailStr(document.nologin.email.value )){
        //alert("Please verify Personel Email");
        return false;
    }
    return true;
}

</script>

<BR>
<h1><B>Login Help >></B> Request for Login ID</h1>
<div align="center">
    <TABLE cellSpacing=0 cellPadding=4 border=0 width=90% align=center>
        <TR>
            <TD valign=top width=90% class=body><BR><BR>Many of the facilities of this site are exclusive to the alumni of MEC, and <strong><font color = red>hence will not be available to the general internet user </font></strong>. Any inconvenience caused is regretted. All XMECians who have earned their degrees from Model Engineering College are <strong><font color = red>members by default</font>.<BR><BR>In case you have not received your Login details, please enter your details so that the XMEC Moderator can process your request for Login.</strong>
                <br/>
                <form name="nologin" method="post" action="/server-scripts/formmail/FormMail.pl">
                    <input type=hidden name="recipient" value="moderator@xmec.addr.com">
                    <INPUT TYPE=hidden NAME="subject" VALUE="[xmec.net]New Login Request">
                    <input type=hidden name="redirect" value="http://www.xmec.net/new/thankyou.php">
                    <TABLE BORDER=0 cellpadding=5 cellspacing=0 bordercolor="#dddddd" WIDTH="425">
                        <TR>
                            <TD width=125 class=body><B>Batch</B></TD>
                            <TD width=300>
                                <SELECT NAME="Batch" width="250" class=cbox>
                                    <OPTION value="" selected>Select One</OPTION>
                                    <OPTION value="batch1">1st Batch (89-93)</OPTION>
                                    <OPTION value="batch2">2nd Batch (90-94)</OPTION>
                                    <OPTION value="batch3">3rd Batch (91-95)</OPTION>
                                    <OPTION value="batch4">4th Batch (92-96)</OPTION>
                                    <OPTION value="batch5">5th Batch (93-97)</OPTION>
                                    <OPTION value="batch6">6th Batch (94-98)</OPTION>
                                    <OPTION value="batch7">7th Batch (95-99)</OPTION>
                                    <OPTION value="batch8">8th Batch (96-00)</OPTION>
                                    <OPTION value="batch9">9th Batch (97-01)</OPTION>
                                    <OPTION value="batch10">10th Batch (98-02)</OPTION>
                                    <OPTION value="batch11">11th Batch (99-03)</OPTION>
                                    <OPTION value="batch12">12th Batch (00-04)</OPTION>
                                </SELECT>
                            </TD>
                        </TR>
                        <TR>
                            <TD width=125 class=body><B>Roll No</B></TD>
                            <TD width=300 ><INPUT NAME="Rollno" size="25" class=lbox></TD>
                        </TR>
                        <TR>
                            <TD width=125 class=body><STRONG>Name</STRONG></TD>
                            <TD width=300><INPUT name=Name size=25 class=lbox></TD>
                        </TR>
                        <TR>
                            <TD width=125 class=body><STRONG>Email ID</STRONG></TD>
                            <TD width=300><INPUT NAME="email" size=25 class=lbox></TD>
                        </TR>
                        <TR>
                            <TD align=left>
                            <A href="javascript:history.back();"><img src="images/back.gif" border=0></A>
                            </TD>
                            <TD align=center>
                            <INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check()">
                            </TD>
                        </TR>
                    </TABLE>
                </form>
            </TD>
        </TR>
    </TABLE>
</div>
<!--center ends-->
<?php
include 'footer.php';
?>