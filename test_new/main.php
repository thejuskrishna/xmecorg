<?php
	include_once 'xmec.inc';
	include_once 'functions.php';

	reset($HTTP_POST_VARS);
	$action = chop($HTTP_POST_VARS["action"]);
	if ($REQUEST_METHOD == "GET")
		$action = chop($HTTP_GET_VARS["action"]);
	$login_success = FALSE;

	if ($target == "")
		$target = "members.php";

	if ($action == "login") {
		$userid = chop($HTTP_POST_VARS["rollno"]);
		$pass = chop($HTTP_POST_VARS["passwd"]);
		$target = chop($HTTP_POST_VARS["target"]);

		if (XMEC::authenticate_user()) {
			XMEC::user_logout();
		}

		if (XMEC::user_login($userid, $pass)) {
			$login_success = TRUE;
			$url = "$PHP_SELF?action=null&target=";
			$url .= rawurlencode($target);
			header("Location: $url");
			exit ;
		}
	} else if ($action == "logout") {
		XMEC::user_logout();
	} else
		XMEC::authenticate_user();

	$user =& XMEC::getUser();
	if (!$user->isLoggedIn()) {
		$user->set('first_name', "Guest");
		$user->set('last_name', "");
	} else {
		$login_success = TRUE;
	}

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
    
    function load_page(page)
    {
        if(page=="#content")
        {
            $('#content').html("");
            $('#content').load('index.php #content');
            /*$("#content").load(page,function(){
                $(document).ready(function(){
                    $("#preloader").css('display','none');
                    $(this).css('opacity','1');
                });
            });*/
            return;
        }
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
                $("#content").css('background-image','url(images/bg_page_other.gif)');
                $(".Cbottom").css('background-image','url(images/bg_page_other.gif)');
                $(document).ready(function(){
                    $("#preloader").css('display','none');
                    $(this).css('opacity','1');
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
                    load_page('#content');
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
                                        <li onclick="load_page('search.php')"><a>Search</a></li>
                                        <li onclick="load_page('groups.php')"><a>Groups</a></li>
                                        <li onclick="load_page('subscription.php')"><a>Subscriptions</a></li>
                                    </ul>
                                </li>
				<li><a>News</a>
                                    <ul>
                                        <li onclick="load_page('xnews.php')"><a>xMEC</a></li>
                                        <li onclick="load_page('mecnews.php')"><a>College</a></li>
                                        <li onclick="load_page('letters.php')"><a>Letters</a></li>
                                    </ul>
                                </li>
				<li><a>Activities</a>
                                    <ul>
                                        <li onclick="load_page('colact.php')"><a>College</a></li>
                                        <li onclick="load_page('chapters.php')"><a>Chapters</a></li>
                                        <li onclick="load_page('post_job.php')"><a>Careers</a></li>
                                    </ul>
                                </li>
				<li><a>Gallery</a>
                                    <ul>
                                        <li onclick="load_page('gallery.php')"><a>Photos</a></li>
                                        <li onclick="load_page('video.php')"><a>Videos</a></li>
                                    </ul>
                                </li>
				<li><a>Members</a>
                                    <ul>
                                        <li onclick="load_page('calendar.php')"><a>Calendar</a></li>
                                        <li onclick="load_page('post_job.php')"><a>Post a Job</a></li>
                                        <li onclick="load_page('phorum/index.php')"><a>Discussions</a></li>
                                        <li onclick="load_page('polls.php')"><a>Polls</a></li>
                                        <li onclick="load_page('accounts.php')"><a>Accounts</a></li>
                                    </ul>
                                </li>
                                <li onclick="load_page('downloads.php')"><a>Downloads</a></li>
                                <li><a>About Us</a>
                                    <ul>
                                        <li onclick="load_page('xmec.php')"><a>xMEC</a></li>
                                        <li onclick="load_page('college.php')"><a>College</a></li>
                                        <li onclick="load_page('university.php')"><a>University</a></li>
                                        <li onclick="load_page('contact.php')"><a>Contact Us</a></li>
                                        <li onclick="load_page('vision.php')"><a>Vision</a></li>
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
                <?  include 'head.php';?>
                <div id="cA">
			<h3>SEARCH</h3>
			<div id="search">
				<input type="text" class="search" /><input type="submit" class="submit" value="Submit" />
			</div><!-- search -->
			<p>&nbsp;</p>
			<h3>MEC NEWS</h3>
			<p class="testimonial"><img src="" alt="Skuola Screenshot Piece" width="87" height="100" class="leflo" />To be done. They are not just graphic artists, they are artists. They brought my ideas to reality making my portal's graphics simple, lightweight and intuitive. I especially appreciated their helpful attitude in looking together for the best solution. Impressive!<br /><strong>Marco from Skuola.net</strong></p>
			<p class="testimonial"><img src="" alt="The Music Magazine Screenshot Piece" width="87" height="100" class="leflo" />To be done. Their knowledge of web design has been invaluable in creating a website fit for public use. I received a range of affordable packages, and they were happy to spend as much time as we needed to make sure everything was perfect for my launch date. Full marks!<br /><strong>Scott from TheMusicMagazine.co.uk</strong></p>
		</div><!-- cA -->
		<div id="cB">
			<div id="cB1">
				<h3></h3>
				<div class="news">
					<p><b>xMEC</b> is the abbreviation for exMECians, the Alumni Association of <b>Model Engineering College, Thrikkakara, Kochi</b>. xMEC is an autonomous body representing thousand three hundred and more engineers who have earned their degrees in
  	Model Engineering College. It binds together MECians who are spread out in institutions and industries around the globe.</p><p> The backbone of xMEC is the relentless support and cooperation of all exMECians who live in India and abroad and
  	who are proud to announce <b>"MEC made me what I'm today"</b>.</p>
				</div>
				<!--<div class="news">
					<p></p>
				</div>-->
			</div><!-- cB1 -->
			<div id="cB2">
				<h3>MEMBERS LOGIN</h3>
				<div class="login">
                                    <?$user = XMEC::getUser();
                                        if (! $user->isLoggedIn()) {
                                    ?>
                                    <table class="box-table" id="login_table" cellSpacing=2 height=80 cellPadding=0 border=0>
                                    <form id="login" onsubmit="return false">
                                    <input type="hidden" name="xgetpage" value="<?=$PHP_SELF?>" />
                                    <input type="hidden" name="action" value="login" />
                                      
                                      <tr>
                                            <td class=fname>Login</td>
                                            <td><input id="rollno" name=rollno type=text class=box size=10 /></td>
                                      </tr>
                                      <tr>
                                            <td class=fname>Password</td>
                                            <td><input id="passwd" name=passwd type=password class=box  size=10 /></td>
                                      </tr>
                                      <tr rowspan="2">
                                          <td></td><td align="center"><button>Submit</button></td>
                                      </tr>
                                      <tr>
                                          <td></td><td><a class=link href="loginerror.php"><b>Forgot Password?</b></a></td>
                                      </tr>
                                    </form>
                                    </table>
                                    <?
                                          }
                                    ?>
				</div>
				<div id="newsletter"><a href=""></a></div><!-- newsletter -->
			</div><!-- cB2 -->
		</div><!-- cB -->

                <?  include 'footer.php';?>
	</div><!-- content -->
        <div id="properspace"></div><!-- properspace -->
</div><!-- main -->
<div id="footer">
	<div id="foot">
		© xMEC All rights reserved.
	</div><!-- foot -->
</div><!-- footer -->
</body>
</html>
