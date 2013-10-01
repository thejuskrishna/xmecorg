<?php
include_once 'xmec.inc';

$secure_page=0;
$this_page="loginerror";
$no_search_menu=1;
include 'header.php';
$name=$_POST['name'];
$middle_name=$_POST['middle_name'];
$last_name=$_POST['last_name'];
$batch=$_POST['Batch'];
$roll_no=$_POST['Rollno'];
$email_id=$_POST['email'];
$dob=$_POST['Dob'];
$link="http://www.xmec.org/admin_preferences.php?s=1&id=".$roll_no;
//mail

$to      = 'vyas.thottathil@gmail.com,sarath.s.mec@gmail.com,thejuskrishna@gmail.com';
$subject = 'xMEC.org: Forgot Email/Password';
$headers = 'From: webmaster@xmec.org' . "\r\n" ;

if($_POST['change']=="password")
{

$msg=<<<EOD
Please change password of the xMECian, whose details are provided below:

First Name submitted: "$name"
Middle Name submitted: "$middle_name"
Last Name submitted: "$last_name"
Batch submitted: "$batch"
Roll No submitted: "$roll_no"
Email Id submitted: "$email_id"
Date of Birth submitted: "$dob"

To take action, please click "$link" .
EOD;

mail($to, $subject, $msg, $headers);
}
else
{

        $fb= new Facebook(array(
          'appId'  => '101039650020031',
          'secret' => '4cd18604efbe1d7691981b26532c7c0b',
          'cookie' => true,
        ));

        $uid=$fb->getUser();
        if($uid!=0)
        {
            $user_profile = $fb->api('/me');
$fb_link=$user_profile['link'];
$fb_first=$user_profile['first_name'];
$fb_middle=$user_profile['middle_name'];
$fb_last=$user_profile['last_name'];
$fb_email=$user_profile['email'];

       $msg=<<<EOD
Please change the email id of the xMECian, whose details are provided below:

FB Profile Link: "$fb_link"
First Name submitted: "$fb_first"
Middle Name submitted: "$fb_middle"
Last Name submitted: "$fb_last"
Batch submitted: "$batch"
Roll No submitted: "$roll_no"
Email Id submitted: "$email_id"
FB Email id: "$fb_email"
Date of Birth submitted: "$dob"
FB Studied At: "$fb_college"
To take action, please click "$link" .
EOD;
mail($to, $subject, $msg, $headers);
	 }
        else
        {

            echo "You need to log in to Facebook for this to work";
        	exit;
	}



}
?>
<!--center starts-->

<div align="center">
A Mail has been sent to our admins.
</div>
<!--Content ends-->
<?php
include 'footer.php';
?>
