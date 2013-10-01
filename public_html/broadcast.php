<?php
$secure_page=1;
$this_page="college";
include 'header.php';
?>
<?php
	if (! XMEC::authenticate_user()) {
		echo "<br/><br/><center><h1>Please login to access this page</h1></center>";
                include 'footer.php';
		exit ;
	}
	$me =& XMEC::getUser();

	if (!$me->isAdmin()) {
		echo "<br/><br/><center><h1>Not authorized !!</h1></center>";
                include 'footer.php';
		exit ;
	}
?>
<?php
$dbh =& XMEC::getDB();
   if (!isset($_POST['submit'])):{
      }
?>
<script type="text/javascript" src="jslibxmec.js"></script>
<script type="text/javascript">
function check()
{
    if (false == validate())
    {
        alert("Validate is False ");
    }
    else
        document.broadcast.submit();
}
function validate()
{
    if ((document.broadcast.to.value == "aow") && (document.broadcast.data.value == "")){
        alert("Please enter a valid data to query ");
        return false;
    }
    if (document.broadcast.to_address.value == "" && document.broadcast.to_address.value == ""){
        alert("Please either the To or Cc Address to which mails to be sent ");
        return false;
    }
    if (document.broadcast.subject.value == ""){
        alert("Please enter the Subject of the Mail to be posted");
        return false;
    }
    if (document.broadcast.message.value == ""){
        alert("Please enter the Message to be posted");
        return false;
    }
    if (document.broadcast.to.value == "notall" && document.broadcast.batch.value == ""){
        alert("Please select the Batch to which you wish to send");
        return false;
    }
    return false;
}
</script>
<div align="center" width="90%" style="padding:0 20px 0">
<br/><br/>
<h1>xMEC Broadcast Mailer</h1><br/>
<P><B>You can broadcast a mail to all XMECians that using XMEC Broadcast Mailer. You can define the Target Group to which you wish to send the mail using the query option. Please use the Broadcast to XMEC and Batches with care as XMECians are sensitive to SPAM. <font color=red><br/><br/>When you press the Submit button no additional level confirmation or verification is done, mails will be sent instantaneously.</font></B></P>
<br/><br/>
<form name="broadcast" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<TABLE BORDER=0 cellpadding=5 cellspacing=0 WIDTH="90%">
<tr>
<td align="center">
</td>
</tr>
<tr>
<TD width=225 class=name><strong>Broadcast Option</strong></TD>
<td>
<select name="to" class=cbox style="WIDTH: 144px">
<option value="all">Entire XMEC</option>
<option value="notall">By Batch</option>
<option value="aow">Query</option>
<option selected value="">None</option>
</select>
</td>
</tr>
<tr>
<TD width=225 class=body>Batch:</td>
<td>
<select name="batch" class=cbox style="WIDTH: 144px">
<OPTION selected value="">None</OPTION>
<OPTION value="1989">Batch 1 (1989~93)</OPTION>
<OPTION value="1990">Batch 2 (1990~94)</OPTION>
<OPTION value="1991">Batch 3 (1991~95)</OPTION>
<OPTION value="1992">Batch 4 (1992~96)</OPTION>
<OPTION value="1993">Batch 5 (1993~97)</OPTION>
<OPTION value="1994">Batch 6 (1994~98)</OPTION>
<OPTION value="1995">Batch 7 (1995~99)</OPTION>
<OPTION value="1996">Batch 8 (1996~2000)</OPTION>
<OPTION value="1997">Batch 9 (1997~2001)</OPTION>
<OPTION value="1998">Batch 10 (1998~2002)</OPTION>
<OPTION value="1999">Batch 11 (1999~2003)</OPTION>
<OPTION value="2000">Batch 12 (2000~2004)</OPTION>
</select>
</td>
</tr>
<TR>
<TD class=name width=225><STRONG>Query Condition</STRONG></TD>
<TD class=name><P><select name="condition" class=cbox>
<option selected value="id = ">Roll Number</option>
<option value="work_type =">Work Type</option>
<option value="company =">Company</option>
</select> equals <INPUT name=data class=lbox style="WIDTH: 70px"></P>
</TD>
</TR>
<tr>
<TD width=225 class=name>To:</TD>
<td> <select name="to_address" class=cbox style="WIDTH: 144px">
<option selected value="">None</option>
<option value="pemail">Personal Email</option>
</select>
</td>
</tr>
<tr>
<TD width=225 class=name>Cc:</TD>
<td> <select name="cc_address" class=cbox style="WIDTH: 144px">
<option selected value="">None</option>
<option value="ofemail">Official Email</option>
</select>
</td>
</tr>
<tr>
<TD width=225 class=name>Bcc:</td><td> <input name="bcc" class=lbox>
</td>
</tr>
<tr>
<TD width=225 class=name>Title or Subject:</td><td> <input name="subject" class=lbox>
</td>
</tr>
<tr>
<TD width=225 class=name>Message:</td>
<td>
<textarea wrap name="message" rows=10 cols=45 class=tbox></textarea>
</td>
</tr>
<tr>
<td width=225></td>
<td class=name>
<input type=submit name="submit" value="SUBMIT" onClick="javascript:check()">
</td>
</tr>
</TABLE>
</form>
</TD>
  </TR>
</TABLE>
</div>
<!--center ends-->


<?php else:

  $to = $_POST['to'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $country = $_POST['country'];

  if ("all" == $to) {
   $x = 1;
      $hold = 10; // quantity of emails sent before 3 sec delay
      $query = "SELECT id,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user ";
      $aowmail = mysql_query("$query");
      while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
      $name = $countmail["name"];
      $roll = $countmail["id"];
      if ($to_address == "pemail") {
      $to_whom = $name." <".$countmail["personal_email"].">";
      }
      if ($cc_address == "ofemail") {
      $cc_id = $name." <".$countmail["official_email"].">";
      }
      $messagex = "Dear $name "."[Login ID : $roll ]\n\n"."$message\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
	  echo "Mail sent to :[ $roll ] $name \n";
      //mail($to_whom , $subject ,$messagex , "From:XMEC Webmasters <webmasters@xmec.net>\r\n"."Cc:{$cc_id}\r\n"."Bcc:{$bcc}\r\n");
      $x++;
       if($x == $hold) { // When $x is equal to $hold, a 3 sec delay will occur avoiding php to timeout
       sleep(3);
       $x = 0;
    }
   } // end of while loop
  } else if ("aow" == $to){

   $x = 1;
   $hold = 10; // quantity of emails sent before 3 sec delay
   $value = " '".$data."' ;";
   $query = "SELECT id,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user where ".$condition.$value;
   $aowmail = mysql_query("$query");
   while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
   $name = $countmail["name"];
   $roll = $countmail["id"];
   if ($to_address == "pemail") {
   $to_whom = $name." <".$countmail["personal_email"].">";
   }
   if ($cc_address == "ofemail") {
   $cc_id = $name." <".$countmail["official_email"].">";
   }
   $messagex = "Dear $name "."[Login ID : $roll ]\n\n"."$message\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
   //mail($to_whom , $subject ,$messagex , "From:XMEC Webmasters <webmasters@xmec.net>\r\n"."Cc:{$cc_id}\r\n"."Bcc:{$bcc}\r\n");
	echo "Mail sent to :[ $roll ] $name \n";
   $x++;
    if($x == $hold) { // When $x is equal to $hold, a 3 sec delay will occur avoiding php to timeout
    sleep(3);
    $x = 0;
    }
   } // end of while loop
  } else if ("notall" == $to){

   $x = 1;
   $hold = 10; // quantity of emails sent before 3 sec delay
   $value = " '%".$batch."%' ;";
   $query = "SELECT id,personal_email,official_email,concat(first_name,' ',middle_name,' ',last_name) as name FROM xmec_user where id like ".$value;
   $aowmail = mysql_query("$query");
   while ($countmail = mysql_fetch_array($aowmail,MYSQL_ASSOC)) {
   $name = $countmail["name"];
   $roll = $countmail["id"];
   if ($to_address == "pemail") {
   $to_whom = $name." <".$countmail["personal_email"].">";
   }
   if ($cc_address == "ofemail") {
   $cc_id = $name." <".$countmail["official_email"].">";
   }
   $messagex = "Dear $name "."[Login ID : $roll ]\n\n"."$message\n\n"."This Message was sent from the XMEC Alumni site (www.xmec.net). Please contact webmasters@xmec.net if this mail has reached you in error or if you have any other concerns.";
   //mail($to_whom , $subject ,$messagex , "From:XMEC Webmasters <webmasters@xmec.net>\r\n"."Cc:{$cc_id}\r\n"."Bcc:{$bcc}\r\n");
	echo "Mail sent to :[ $roll ] $name \r\n";
   $x++;
    if($x == $hold) { // When $x is equal to $hold, a 3 sec delay will occur avoiding php to timeout
    sleep(3);
    $x = 0;
    }
   } // end of while loop
  }
?>
<?php endif; ?>
<?php
include 'footer.php';
?>
