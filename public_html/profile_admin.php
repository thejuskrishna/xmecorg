<?php

	include 'xmec.inc';
        include 'header.php';
	if (! XMEC::authenticate_user()) {
		echo "<html><h1>Please login to access this page<html>";
		exit ;
	}

	$me =& XMEC::getUser();

	if (!$me->isAdmin()) {
		echo "<html><h1>Not authorized !!</html>";
		exit ;
	}

	reset($HTTP_POST_VARS);

	$action = chop($HTTP_POST_VARS["todo"]);
	if ($_SERVER['REQUEST_METHOD'] == "GET")
		$action = chop($HTTP_GET_VARS["todo"]);

	$id = chop($HTTP_POST_VARS["id"]);
	if ($_SERVER['REQUEST_METHOD'] == "GET")
		$id = chop($HTTP_GET_VARS["id"]);

	$user = new XMEC_user();
	if ($id != "") {
		$user->setID($id);
		if ( !$user->fetchInfo()) {
			echo "<html><h1>Error getting user info !!</html>";
			exit ;
		}
	} else {
		echo "<html><h1>No ID selected !!</html>";
		exit ;
	}

	if ($action == "Update") {
 		if ($_POST['CBWork'] != "NULL")
			$user->set('work_type',ucwords($_POST['CBWork']));
		else
			$user->set('work_type', ucwords(trim($_POST['TBWork'])));

		$user->set('first_name', $_POST['TBFname']);
		$user->set('middle_name', $_POST['TBMname']);
		$user->set('last_name', $_POST['TBLname']);
		$user->set('company', $_POST['TBCname']);
		$user->set('sex', $_POST['CBSex']);
		$user->set('date_of_birth', $_POST['TBDob']);
		$user->set('marital_status', $_POST['CBMstatus']);
		$user->set('official_email', $_POST['TBEAddrO']);
		$user->set('personal_email', $_POST['TBEAddrP']);
		$user->set('nick_name', $_POST['TBNname']);
		$user->set('yahoo', $_POST['TBPostG']);
		$user->set('msn', $_POST['TBPost']);
		$user->set('webpage', $_POST['TBWebURL']);
		$user->set('alias', $_POST['TBAlias']);
		$user->set('forwarding_email', $_POST['TBEAddrF']);
		$user->set('aol', $_POST['TBSpouse']);
		$user->set('jabber', $_POST['TBSporg']);
		$user->set('fb_id', $_POST['FBId']);

		if ( ! $user->Update()) {
			XMEC::error_exit ("Update failed: ". $user->getError());
		} else {
			// re-read everything from DB..
			$user->fetchInfo();
		}

		$addr = new XMEC_address();

		$addr->set('house_name', $_POST['TBHname']);
                $addr->set('street', $_POST['TBCStr']);
                $addr->set('area', $_POST['TBCArea']);
                $addr->set('city', $_POST['TBCCity']);
                $addr->set('state', $_POST['TBCState']);
                $addr->set('country', $_POST['TBCCountry']);
                $addr->set('postal_code', $_POST['TBCPin']);
                $addr->set('telephone_no', $_POST['TBWPhone']);

                if (($p = $user->getAddressVisibility('COMPANY')))
                        $addr->set('visibility', $p);

                if (! $user->setAddress($addr, 'COMPANY')) {
                        XMEC::error_exit ("Update failed: ". $user->getError());
                }

                $addr->set('house_name', $_POST['TBTHname']);
                $addr->set('street', $_POST['TBTStr']);
                $addr->set('area', $_POST['TBTArea']);
                $addr->set('city', $_POST['TBTCity']);
                $addr->set('state', $_POST['TBTState']);
                $addr->set('country', $_POST['TBTCountry']);
                $addr->set('postal_code', $_POST['TBTPin']);
                $addr->set('telephone_no', $_POST['TBTPhone']);


		if (($p = $user->getAddressVisibility('PRESENT')))
			$addr->set('visibility', $p);

		if (! $user->setAddress($addr, 'PRESENT')) {
			XMEC::error_exit ("Update failed: ". $user->getError());
		}

		if (empty($target)) {
			$target="members.php";
		}

		echo "<br/><center><h1>".$user->get('first_name')."'s profile has been updated successfully</h1></center>";
                include 'footer.php';
		exit;
	} else {
		$paddr = $user->getAddress('PERMANENT');
		$caddr = $user->getAddress('PRESENT');
		$oaddr = $user->getAddress('COMPANY');
		$work_types = XMEC::get_work_types();
	}

?>

<FORM name="Fcr" method=post action=<?=$PHP_SELF?>>
<input type=hidden name=id value=<?=$id?>>
<TABLE align=left border=0 cellPadding=10 cellSpacing=0 width="615">
<TR><TD valign=top width=615>
<TABLE border=0 cellPadding=0 cellSpacing=0 background="">

<TR>
     <TD colSpan=4 height=35 class=head>PERSONAL INFORMATION
      (All the fields shown in Red are mandatory fields)
       </TD>
 </TR>
 <TR>
	<TD colspan=4 height=20>&nbsp;</TD>
 </TR>
  <TR>
    <TD height=35 class=fhead>First Name</TD>
    <TD><INPUT class=box name=TBFname value="<?=htmlentities($user->get('first_name'))?>"></TD>

    <TD class=fbody>
      <P>Middle Name </P></TD>
    <TD><INPUT class=box name=TBMname  value="<?=htmlentities($user->get('middle_name'))?>"></TD>
    </TR>
  <TR>
    <TD height=35 class=fhead>Surname</TD>
    <TD><INPUT  class=box name=TBLname  value="<?=htmlentities($user->get('last_name'))?>"></TD>

    <TD class=fhead>Sex</TD>
    <TD><SELECT  class=cbox name=CBSex >
      <OPTION value="NULL">Select One</OPTION>
  <OPTION <?if ($user->get('sex') == "M") echo "selected";?> value="M">Male</OPTION>
  <OPTION <?if ($user->get('sex') == "F") echo "selected";?> value="F">Female</OPTION>
  </SELECT></TD>
   </TR>
   <TR>
    <TD nowrap height=35 class=fhead>DOB <EM>(dd/mm/yyyy)</EM> <EM>
      </EM>  </TD>
    <TD><INPUT class=box name=TBDob
      value="<?=htmlentities($user->get('date_of_birth'))?>"
       ></TD>

    <TD class=fbody>Marital Status</TD>
    <TD><SELECT  class=cbox name=CBMstatus >
      <OPTION value="S">Single</OPTION>
      <OPTION <?if ($user->get('marital_status') == "M") echo "selected";?> value="M">Married</OPTION>
      </SELECT></TD>
    </TR>
  <TR>
    <TD nowrap height=35 class=fhead>
      <P>Email <EM>(Personal)</EM></P></TD>
    <TD><INPUT class=box name=TBEAddrP value="<?=htmlentities($user->get('personal_email'))?>"
           ></TD>

    <TD class=fbody>Email <EM>(Official)</EM></TD>
    <TD><INPUT class=box name=TBEAddrO value="<?=htmlentities($user->get('official_email'))?>"
           ></TD>
   </TR>
   <TR>
    <TD height=35 class=fhead>Field of Work
      </TD>
    <TD><SELECT class=cbox name=CBWork >
    <OPTION value="NULL">Others..</OPTION>
<?php
	for ($i = 0; $i < sizeof($work_types); $i++) {
		if ($user->get('work_type') == $work_types[$i])
			$sel = " selected";
		else
			$sel = "";
    	echo "<OPTION value=\"".htmlentities($work_types[$i])."\"$sel>".htmlentities($work_types[$i])."</OPTION>";
	}
?>
    </SELECT></TD>

    <TD class=fbody>If other,add</TD>
    <TD><INPUT class=box name=TBWork></TD>
  </TR>
   <TR>
	<TD colspan=4 height=20>&nbsp;</TD>
 </TR>
<TR>
    <TD height=35 class=fbody>Spouse Name</TD>
    <TD><INPUT class=box name=TBSpouse value="<?=htmlentities($user->get('aol'))?>"></TD>

    <TD class=fbody>
      <P>Spouse Organisation </P></TD>
    <TD><INPUT class=box name=TBSporg  value="<?=htmlentities($user->get('jabber'))?>"></TD>
    </TR>

<TR>

    <TD class=fbody>
      <P>Facebook Id </P></TD>
    <TD><INPUT class=box name=FBId  value="<?=htmlentities($user->get('fb_id'))?>"></TD>
    </TR>


<TR>
    <TD height=35 class=fhead>NickName</TD>
    <TD><INPUT class=box name=TBNname value="<?=htmlentities($user->get('nick_name'))?>"></TD>

    <TD class=fbody>
      <P>Post Graduation</P></TD>
    <TD><INPUT class=box name=TBPostG  value="<?=htmlentities($user->get('yahoo'))?>"></TD>
    </TR>
<TR>
    <TD height=35 class=fhead>Designation</TD>
    <TD><INPUT class=box name=TBPost value="<?=htmlentities($user->get('msn'))?>"></TD>

    <TD height=35 class=fhead>Web Page</TD>
    <TD><INPUT class=box name=TBWebURL value="<?=htmlentities($user->get('webpage'))?>"></TD>
    </TR>
  <TR>
    <TD nowrap height=35 class=fhead>
      <P>Forwarding Email <EM>(eg.bob@xmec.org)</EM></P></TD>
    <TD><INPUT class=box name=TBEAddrF value="<?=htmlentities($user->get('forwarding_email'))?>"
           ></TD>

    <TD class=fbody>Alias <EM>(Login name)</EM></TD>
    <TD><INPUT class=box name=TBAlias value="<?=htmlentities($user->get('alias'))?>"
           ></TD>
   </TR>

  <TR>

    <TD colSpan=2 height=35 class=name>
      <P align=center>PERMANENT ADDRESS</P> </TD>
    <TD  colspan =2 class=fbody>
      <P align=center>OFFICIAL ADDRESS<A href="javascript:showlayer('2');"><img src="images/lens.gif" border=0></A> </P></TD>
    </TR>
     <TR>
	<TD colspan=4 height=20>&nbsp;</TD>
 </TR>

  <TR>
    <TD nowrap height=35 class=name>House Name/No.</TD>
    <TD><INPUT  class=box name=TBHname value="<?=htmlentities($paddr->get('house_name'))?>"
           ></TD>
    <TD class=fbody>Organisation&nbsp;Name</TD>
    <TD><INPUT class=box name=TBCname
      value="<?=htmlentities($user->get('company'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=fbody>Street
Address</TD>
    <TD><INPUT class=box name=TBPStr value="<?=htmlentities($paddr->get('street'))?>"
           ></TD>
    <TD class=fbody>Street
Address</TD>
    <TD><INPUT class=box name=TBCStr
      value="<?=htmlentities($oaddr->get('street'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=name>Area</TD>
    <TD><INPUT  name=TBPArea
      class=box value="<?=htmlentities($paddr->get('area'))?>"
           ></TD>
    <TD class=fbody>Area</TD>
    <TD><INPUT  name=TBCArea
      class=box value="<?=htmlentities($oaddr->get('area'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=name>City/Town</TD>
    <TD><INPUT  name=TBPCity
      class=box value="<?=htmlentities($paddr->get('city'))?>"
           ></TD>
    <TD class=fbody>City/Town</TD>
    <TD><INPUT class=box
      name=TBCCity
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($oaddr->get('city'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=name>State</TD>
    <TD><INPUT  name=TBPState class=box
      style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('state'))?>"
           ></TD>
      <TD class=fbody>State</TD>
    <TD><INPUT  name=TBCState class=box
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($oaddr->get('state'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=name>Country</TD>
    <TD><INPUT class=box name=TBPCountry
      style="HEIGHT: 19px; WIDTH: 143px" value="<?=htmlentities($paddr->get('country'))?>"
           ></TD>
    <TD class=fbody>Country</TD>
    <TD><INPUT name=TBCCountry class=box
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($oaddr->get('country'))?>"
           ></TD></TR>
  <TR height=35>
    <TD class=fbody>Pin Code</TD>
    <TD><INPUT  name=TBPPin class=box
      style="HEIGHT: 19px; WIDTH: 144px" value="<?=htmlentities($paddr->get('postal_code'))?>"
           ></TD>
    <TD class=fbody>Pin Code</TD>
    <TD><INPUT  name=TBCPin class=box
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($oaddr->get('postal_code'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=fbody>Home Phone</TD>
    <TD><INPUT  name=TBHPhone class=box
      style="HEIGHT: 18px; WIDTH: 145px" value="<?=htmlentities($paddr->get('telephone_no'))?>"
           ></TD>
    <TD class=fbody>Work Phone</TD>
    <TD><INPUT  name=TBWPhone class=box
      style="HEIGHT: 19px; WIDTH: 148px" value="<?=htmlentities($oaddr->get('telephone_no'))?>"
           ></TD></TR>
  <TR><TD colspan=4 height=20>&nbsp;</TD></TR>
  <TR>
    <TD align = middle colspan="4" height=35 class=name>
      <P align=center><STRONG>PRESENT ADDRESS</STRONG> </P>
       </TD>
   </TR>
   <TR><TD colspan=4 height=20>&nbsp;</TD></TR>
  <TR>
    <TD height=35 class=name>House Name/No.</TD>
    <TD><INPUT  name=TBTHname class=box
      style="HEIGHT: 19px; WIDTH: 143px"  value="<?=htmlentities($caddr->get('house_name'))?>"
           ></TD>
    <TD class=fbody>Phone</TD>
    <TD><INPUT  name=TBTPhone class=box
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($caddr->get('telephone_no'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=fbody>Street Address</TD>
    <TD><INPUT  name=TBTStr class=box
      style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($caddr->get('street'))?>"
           ></TD>
    <TD class=name>Area</TD>
    <TD><INPUT  name=TBTArea class=box
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($caddr->get('area'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=name>City/Town</TD>
    <TD><INPUT   name=TBTCity class=box
      style="HEIGHT: 18px; WIDTH: 144px" value="<?=htmlentities($caddr->get('city'))?>"
           ></TD>
    <TD class=name>State</FONT></STRONG></TD>
    <TD><INPUT  name=TBTState class=box
      style="HEIGHT: 19px; WIDTH: 147px" value="<?=htmlentities($caddr->get('state'))?>"
           ></TD></TR>
  <TR>
    <TD height=35 class=name>Country</TD>
    <TD><INPUT name=TBTCountry class=box
      style="HEIGHT: 18px; WIDTH: 145px" value="<?=htmlentities($caddr->get('country'))?>"
           ></TD>
    <TD class=fbody>Pin Code</TD>
    <TD><INPUT name=TBTPin class=box
      style="HEIGHT: 19px; WIDTH: 146px" value="<?=htmlentities($caddr->get('postal_code'))?>"
           ></TD></TR>
    <TR>
    <TD height=20 colspan=4>&nbsp;</TD>
	</TR>
    <TR>
    <TD height=20 colspan=4>&nbsp;</TD>
	</TR>
  <TR>
     <TD colspan=2 align=center height=35>
      <INPUT  name=todo type=submit value=Update style="HEIGHT: 24px; WIDTH: 96px">
</TD>
     <TD colspan=2 align=center height=35>
      <INPUT  name=cancel type=button value=Close OnClick="javascript:window.close();" style="HEIGHT: 24px; WIDTH: 96px">
</TD>
  </TR>

</TABLE>
</TD>
</TR></TABLE>
</FORM>

<?
include 'footer.php';
?>
