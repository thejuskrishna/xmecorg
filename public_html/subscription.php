<?php
$secure_page=1;
$this_page="subscribe";
include 'header.php';
$user = XMEC::getUser();
?>
<script language="javascript" src="jslibxmec.js">
</script>
<script language="javascript">
function check1()
{
    if (true == validate1())
        document.subscription.submit();
}

function validate1()
{
    if(!CheckEmailStr(document.subscription.sendcat.value )){
        alert("Please record your Email ID ");
        return false;
    }
    if(document.subscription.list.value == ""){
        alert("Please verify Alumni Mailing List");
        return false;
    }
    if (document.subscription.subject1.value == ""){
        alert("Please select to Subcribe or Unsubscribe");
        return false;
    }
    if (document.subscription.subject1.value == "-subscribe@yahoogroups.com"){
        document.subscription.message.value = "Please Subscribe this ID to the Mailing List";
    }
    if (document.subscription.subject1.value == "-unsubscribe@yahoogroups.com"){
        document.subscription.message.value = "Please Unsubscribe this ID from the Mailing List";
    }

    if (document.subscription.recipient.value == ""){
        document.subscription.recipient.value = document.subscription.list.value + document.subscription.subject1.value;
    }
    if (document.subscription.ccrecipient.value == ""){
        document.subscription.ccrecipient.value = document.subscription.list.value + "-owner@yahoogroups.com";
    }
    if (document.subscription.sendcat.value != ""){
        document.subscription.sender.value = document.subscription.details.value +"<"+ document.subscription.sendcat.value +">";
    }
    if (document.subscription.subject1.value != ""){
        document.subscription.subject.value = document.subscription.message.value;
    }
    return true;
}

function check2()
{
    if (true == validate2())
        document.subscribelist.submit();
}

function validate2()
{
    if(!CheckEmailStr(document.subscribelist.sendcat2.value )){
        alert("Please record your Email ID ");
        return false;
    }
    if(document.subscribelist.list2.value == ""){
        alert("Please verify Batch Mailing List");
        return false;
    }
    if (document.subscribelist.subject2.value == ""){
        alert("Please select to Subcribe or Unsubscribe");
        return false;
    }
    if (document.subscribelist.subject2.value == "Subscribe"){
        document.subscribelist.message.value = "Please Subscribe this ID to the Mailing List ";
    }
    if (document.subscribelist.subject2.value == "Unsubscribe"){
        document.subscribelist.message.value = "Please Unsubscribe this ID from the Mailing List" ;
    }
    if (document.subscribelist.recipient.value == ""){
        document.subscribelist.recipient.value = document.subscribelist.list2.value;
    }
    if (document.subscribelist.bccrecipient.value == ""){
        document.subscribelist.bccrecipient.value = "vyas.thottathil@gmail.com";
    }
    if (document.subscribelist.sendcat2.value != ""){
        document.subscribelist.sender.value = document.subscribelist.details.value+"<"+document.subscribelist.sendcat2.value+">";
    }
    if (document.subscribelist.subject2.value != ""){
        document.subscribelist.subject.value = document.subscribelist.subject2.value;
    }
    return true;
}

</script>
<br/>
<h1>xMEC Mailing List Subscription</h1>
<br/><br/>
<div align="center" style="width: 85%;margin: auto;">
    <P class=body><B>You can choose to subscribe or unsubscribe your preferred email ID to any one of the xMEC Yahoogroups Mailing Lists. Please note that request goes directly to Yahoogroups and moderated by the xMEC Moderator. You will receive the confirmation mails from Yahoogroups directly.</B></P>
    <form name="subscription" method="post" action="mail.php">
        <SELECT NAME="subject1" class=cbox>
            <OPTION value="" selected>Do Not Change</OPTION>
            <OPTION value="-subscribe@yahoogroups.com">Subscribe</OPTION>
            <OPTION value="-unsubscribe@yahoogroups.com">Unsubscribe</OPTION>
        </SELECT>
        <INPUT NAME="sendcat" value="<?php echo $user->personal_email ?>" type=text class=lbox>
        <SELECT NAME="list" class=cbox >
            <OPTION value="" selected>Alumni Lists</OPTION>
            <OPTION value="xmec">xMEC</OPTION>
            <OPTION value="xmec-jobs">xMEC Jobs</OPTION>
            <OPTION value="xmec-placement-assist">Placement Assistance</OPTION>
            <OPTION value="hash_define_mec">xMEC Programmers</OPTION>
            <OPTION value="xmec-mgt">xMEC Management</OPTION>
            <OPTION value="xmec-bangalore">xMEC Bangalore</OPTION>
            <OPTION value="xmec-chennai">xMEC Chennai</OPTION>
            <OPTION value="xmec-tvm">xMEC Trivandrum</OPTION>
            <OPTION value="xmec-asiapac">xMEC AsiaPac</OPTION>
            <OPTION value="xmec-Europe">xMEC Europe</OPTION>
            <OPTION value="xmec-MiddleEast">xMEC Middle East</OPTION>
            <OPTION value="xmec_west">xMEC US West</OPTION>
            <OPTION value="xmec_east">xMEC US East</OPTION>
        </SELECT>
        <INPUT type=hidden NAME="message" value="" type=text>
        <INPUT type=hidden NAME="recipient" value="" type=text>
        <INPUT type=hidden NAME="ccrecipient" value="" type=text>
        <INPUT type=hidden NAME="sender" value="<?php echo $user->personal_email ?>" type=text>
        <INPUT type=hidden NAME="subject" value="" type=text>
        <INPUT type=hidden NAME="details" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?> <?php echo $user->id ?>" type=text>
        <INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check1()">
    </form>
    <br/><br/>
    <h2>Batch Mailing List Subscription</h2><br/>
    <P class=body><B>You can choose to subscribe or unsubscribe your preferred email ID for your Batch Mailing List. Please note that you can use this facility to update your Email preference for <i>your Batch Mailing List</i> only.</B></P>
    <form name="subscribelist" method="post" action="mail.php">
        <SELECT NAME="subject2" class=cbox>
            <OPTION value="" selected>Do Not Change</OPTION>
            <OPTION value="Subscribe">Subscribe</OPTION>
            <OPTION value="Unsubscribe">Unsubscribe</OPTION>
        </SELECT>
        <INPUT NAME="sendcat2" value="<?php echo $user->personal_email ?>" type=text class=lbox>
        <SELECT NAME="list2" class=cbox >
            <OPTION value="" selected>Batch List</OPTION>
            <OPTION value="batch1@xmec.net">1st Batch (89-93)</OPTION>
            <OPTION value="batch2@xmec.net">2nd Batch (90-94)</OPTION>
            <OPTION value="batch3@xmec.net">3rd Batch (91-95)</OPTION>
            <OPTION value="batch4@xmec.net">4th Batch (92-96)</OPTION>
            <OPTION value="batch5@xmec.net">5th Batch (93-97)</OPTION>
            <OPTION value="batch6@xmec.net">6th Batch (94-98)</OPTION>
            <OPTION value="batch7@xmec.net">7th Batch (95-99)</OPTION>
            <OPTION value="batch8@xmec.net">8th Batch (96-00)</OPTION>
            <OPTION value="batch9@xmec.net">9th Batch (97-01)</OPTION>
            <OPTION value="batch10@xmec.net">10th Batch (98-02)</OPTION>
            <OPTION value="batch11@xmec.net">11th Batch (99-03)</OPTION>
            <OPTION value="batch12@xmec.net">12th Batch (00-04)</OPTION>
        </SELECT>
        <INPUT type=hidden NAME="message" value="" type=text>
        <INPUT type=hidden NAME="recipient" value="" type=text>
        <INPUT type=hidden NAME="sender" value="" type=text>
        <INPUT type=hidden NAME="subject" value="" type=text>
        <INPUT type=hidden NAME="bccrecipient" value="" type=text>
        <INPUT type=hidden NAME="details" value="<?php echo $user->first_name ?> <?php echo $user->last_name ?> <?php echo $user->id ?>" type=text>
        <INPUT TYPE="button" NAME="sendit" VALUE="Send" onClick="javascript:check2()">
    </form>
    <br/><br/>
</div>
<?php
include 'footer.php';
?>

