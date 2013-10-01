<?php
  $_menu_number = 0;
  include_once 'xmec.inc';
    if (!XMEC::authenticate_user() && $secure_page) {
      global $PHP_SELF;
      $url = "login.php?xgetpage=";//.$_SERVER['PHP_SELF'];
      header("Location: $url");
      exit ;
    }

// Global variable holds the menu no. displayed.
if (!session_is_registered("_menu_number")) {
  session_register("_menu_number");
}
$current_sel = 0;
if (chop($HTTP_GET_VARS["mi"]) != "") {
  $current_sel += chop($HTTP_GET_VARS["mi"]);
  if ($current_sel && $current_sel != $_menu_number) {
    $_menu_number = $current_sel;
  }
}
$onload_str = "";
if ($_menu_number != 0) {
  $onload_str = "onload=javascript:show('".htmlentities($_menu_number)."')";
}

  $user = XMEC::getUser();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>xMEC - Alumni of Model Engineering College, Kochi</title>
<meta name="Description" content="xMEC is the Alumni of Model Engineering College, Kochi. www.xmec.net is the official site for the Alumni of Model Engineering College." />
<meta name="Keywords" content="xMEC,Alumni of Model Engineering College,Kochi,Cochin,Alumni,MEC,College,Kerala,Engineering Colleges in Kerala,MEC Alumni,electronics,computer engineering, information technology,biomedical,ihrd," />
<link rel="stylesheet" media="screen" href="style.css" />
<link rel="stylesheet" media="screen" href="galleriffic-2.css" />
<link rel="stylesheet" media="screen" href="jquery-ui.css" />
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" /><!-- custom favicon -->
<meta http-equiv="imagetoolbar" content="no" /><!-- disable IE's image toolbar -->
<script type="text/javascript" language="javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.galleriffic.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.opacityrollover.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" >
    function createCookie(name,value,days) {
        if (days) {
                var date = new Date();
                date.setTime(date.getTime()+(days*24*60*60*1000));
                var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
            document.cookie = name+"="+value+expires+"; path=/";
    }

    $(document).ready(function(){
        $("#preloader").css('display','none');
        $("#content").css('opacity','1');
        $(function() {
		$( "#accordion" ).accordion({
			collapsible: true,
                        active: -1
		});
	});
        $("#mini-tab").mouseenter(function () {
            $("#mini-list").slideToggle('medium');
        });
        $("#mini-tab").mouseleave(function () {
            $("#mini-list").slideToggle('medium');
        });
    });
</script>
</head>

<body>
<div id="preloader"></div>
<div id="main">
	<div id="header">
		<div id="logo"><a href="index.php"><img src="images/logo.png" alt="XMEC" width="318" height="85" /></a><span id="logo-text"><a href="./"></a></span></div><!-- logo -->
		<div id="menu">
			<ul id="nav">
				<li><a>xMECian</a>
                                    <ul>
                                        <li><a href="search.php">Search</a></li>
                                        <li><a href="groups.php">Groups</a></li>
                                        <li><a href="university.php">University Search</a></li>
                                        <li><a href="subscription.php">Subscriptions</a></li>
                                    </ul>
                                </li>
				<li><a>News</a>
                                    <ul>
                                        <li><a href="xnews.php">xMEC</a></li>
                                        <li><a href="mecnews.php">College</a></li>
                                        <li><a href="letters.php">Letters</a></li>
                                    </ul>
                                </li>
				<li><a>Activities</a>
                                    <ul>
                                        <li><a href="colact.php">College</a></li>
                                        <li><a href="chapters.php">Chapters</a></li>
                                        <li><a href="post_job.php">Careers</a></li>
                                    </ul>
                                </li>
				<li><a>Gallery</a>
                                    <ul>
                                        <li><a href="gallery.php">Photos</a></li>
                                        <li><a href="video.php">Videos</a></li>
                                    </ul>
                                </li>
				<li><a>Members</a>
                                    <ul>
                                        <li><a href="calendar.php">Calendar</a></li>
                                        <li><a href="post_job.php">Post a Job</a></li>
                                        <li><a href="phorum/">Discussions</a></li>
                                        <li><a href="polls.php">Polls</a></li>
                                        <li><a href="accounts.php">Accounts</a></li>
                                    </ul>
                                </li>
                                <li><a href="downloads.php">Downloads</a></li>
                                <li><a>About Us</a>
                                    <ul>
                                        <li><a href="xmec.php">xMEC</a></li>
                                        <li><a href="college.php">College</a></li>
                                        <li><a href="cusat.php">University</a></li>
                                        <li><a href="contact.php">Contact Us</a></li>
                                        <li><a href="vision.php">Vision</a></li>
                                    </ul>
                                </li>
			</ul>
		</div><!-- menu -->
                <?$user =& XMEC::getUser();
                if ($user->isLoggedIn()) { ?>
                <div id="mini-menu" >
			Welcome <b style="color: white;"><?=$user->first_name;?></b> |
                        <span id="mini-tab">
                            My Account
                            <ul id="mini-list">
                                <?
                                if($user->isAdmin())
                                {
                                ?>
                                <li><a href="admin.php">Administration</a></li>
                                <?
                                }
                                ?>
                                <li><a href="preferences.php">My Preferences</a></li>
                                <li><a href="editprofile.php">My Profile</a></li>
                                <li><a href="login.php?action=logout">Logout</a></li>
                            </ul>
                        </span>
		</div><!-- ticker -->
                <? } ?>
		<div id="headerimage">
			<!--<div id="download"><span id="download-text"><a href=""></a></span></div><!-- download -->
			<div id="icons">
				<a href="./" ><img src="images/icon_home.gif" alt="Home" width="13" height="13" id="home" /></a>
				<a href="./sitemap.php"><img src="images/icon_sitemap.gif" alt="Sitemap" width="13" height="13" id="sitemap" /></a>
				<a href="login.php?action=logout"><img src="images/power.gif" title="Log out" alt="Logout" width="13" height="13" id="logout" /></a>
                        </div><!-- icons -->
			<!--<div id="slogan">your slogan could go here</div>--><!-- slogan -->
		</div>
		<!-- headerimage -->
	</div>
	<!-- header -->
        <div id="content">
                <div class="Ctopleft"></div>
                <div class="Ctopright"></div>

