<?php
  $_menu_number = 0;
  include_once 'xmec.inc';
    if (!XMEC::authenticate_user() && $secure_page) {
      global $PHP_SELF;
      $url = "login.php?xgetpage=$PHP_SELF";
      header("Location: index.php");
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
<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" /><!-- custom favicon -->
<meta http-equiv="imagetoolbar" content="no" /><!-- disable IE's image toolbar -->
<script type="text/javascript" language="javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.galleriffic.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.opacityrollover.js"></script>
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

    function load_page(page)
    {
        $("#preloader").css('display','block');
        $("#content").css('opacity','0.2');
        if(page=="gallery.php")
        {
            $("#content").load(page,function(){
                $("#content").css('background-image','url(images/bg_page_index.gif)');
                $(".Cbottom").css('background-image','url(images/bg_page_index.gif)');
                $(document).ready(function() {

                    $('#navigation').css({'width' : '250px', 'float' : 'left'});
                    $('#gallery').css('display', 'block');
                    $("#preloader").css('display','none');
                    $("#content").css('opacity','1');

                    var onMouseOutOpacity = 0.67;
                    $('#navigation ul.thumbs li').opacityrollover({
                            mouseOutOpacity:   onMouseOutOpacity,
                            mouseOverOpacity:  1.0,
                            fadeSpeed:         'fast',
                            exemptionSelector: '.selected'
                    });

                    var gallery = $('#navigation').galleriffic({
                            delay:                     3000,
                            numThumbs:                 12,
                            preloadAhead:              10,
                            enableTopPager:            true,
                            enableBottomPager:         true,
                            maxPagesToShow:            4,
                            imageContainerSel:         '#slideshow',
                            controlsContainerSel:      '#controls',
                            captionContainerSel:       '#caption',
                            loadingContainerSel:       '#loading',
                            renderSSControls:          true,
                            renderNavControls:         true,
                            playLinkText:              'Play Slideshow',
                            pauseLinkText:             'Pause Slideshow',
                            prevLinkText:              '&lsaquo; Previous Photo',
                            nextLinkText:              'Next Photo &rsaquo;',
                            nextPageLinkText:          'Next &rsaquo;',
                            prevPageLinkText:          '&lsaquo; Prev',
                            enableHistory:             false,
                            autoStart:                 true,
                            syncTransitions:           true,
                            defaultTransitionDuration: 900,
                            onSlideChange:             function(prevIndex, nextIndex) {
                                    this.find('ul.thumbs').children()
                                            .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
                                            .eq(nextIndex).fadeTo('fast', 1.0);
                            },
                            onPageTransitionOut:       function(callback) {
                                    this.fadeTo('fast', 0.0, callback);
                            },
                            onPageTransitionIn:        function() {
                                    this.fadeTo('fast', 1.0);
                            }
                    });
                });
            });
        }
        else
        {
            $("#content").load(page,function(){
                if(page.substr(0,8)!="index.php")
                {
                    $("#content").css('background-image','url(images/bg_page_other.gif)');
                    $(".Cbottom").css('background-image','url(images/bg_page_other.gif)');
                }
                $(document).ready(function(){
                    $("#preloader").css('display','none');
                    $("#content").css('opacity','1');
                });
            });
        }
    }

    $(document).ready(function(){
        $("#preloader").css('display','none');
        $("#content").css('opacity','1');
        $("#login").submit(function(){
            $.ajax({
                url: "login.php",
                type: "post",
                data: "action=login&rollno="+$('#rollno').val()+"&passwd="+$('#passwd').val(),
                success: function(dat){
                    if(dat=="no_fb_login")
                        alert("Please contact our admin (vyas.thottathil@gmail.com) with your details");
                    else if(dat=="success" || dat=="logout")
                        load_page('index.php #content');
                    else if(dat=="login_failed")
                        alert("Username/password is wrong! Please try again.");
                }
            });
        });
    });
</script>
</head>

<body>
<div id="preloader"></div>
<div id="main">
	<div id="header">
		<div id="logo"><a href="./"><img src="images/logo.png" alt="XMEC" width="318" height="85" /></a><span id="logo-text"><a href="./"></a></span></div><!-- logo -->
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
<!--		<div id="ticker">

		</div><!-- ticker -->
		<div id="headerimage">
			<!--<div id="download"><span id="download-text"><a href=""></a></span></div><!-- download -->
			<div id="icons">
				<a href="./" ><img src="images/icon_home.gif" alt="Home" width="13" height="13" id="home" /></a>
				<a href="./sitemap.php"><img src="images/icon_sitemap.gif" alt="Sitemap" width="13" height="13" id="sitemap" /></a>
				<a href="./"><img src="images/icon_contact.gif" alt="Contact" width="13" height="13" id="contact" /></a>
                        </div><!-- icons -->
			<!--<div id="slogan">your slogan could go here</div>--><!-- slogan -->
		</div>
		<!-- headerimage -->
	</div>
	<!-- header -->
        <div id="content">
                <div class="Ctopleft"></div>
                <div class="Ctopright"></div>

