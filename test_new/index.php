<?php
	include_once 'xmec.inc';
	include_once 'functions.php';

	reset($HTTP_POST_VARS);
	$action = chop($HTTP_POST_VARS["action"]);
	if ($_SERVER["REQUEST_METHOD"] == "GET")
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
?>
<script>
        var nameEQ = "fbsr_101039650020031";
        createCookie(nameEQ,"",-1);
</script>
<?
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
        $("#content").load(page,function(){
            if(page.substr(0,9)!="index.php")
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
<div id="fb-root"></div>
<script type="text/javascript">

    window.fbAsyncInit = function() {
        FB.init({
          appId      : '101039650020031',
          status     : true,
          cookie     : true,
          xfbml      : true,
          oauth      : true,
        });

        FB.Event.subscribe('auth.login', function(response) {
          $.ajax({
                url: "login.php",
                success: function(dat){
                    if(dat=="no_fb_login")
                        alert("Your FB id is not registered in our database. Please contact our admin (vyas.thottathil@gmail.com) with your details");
                    if(dat=="success")
                        load_page('index.php #content');
                }
          });
          load_page('index.php #content');
        });
    };

    (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
    }(document));


</script>
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
        <div id="content" style="background-image: url('images/bg_page_index.gif')">
                <div class="Ctopleft"></div>
                <div class="Ctopright"></div>
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
                                    <?php $user =& XMEC::getUser();

                                       if ($user->isLoggedIn()) { ?>
                                            <TD width=225 valign=top bgcolor="#DDF5FF">
                                            <P><font color=#E00A55><b>Top XMEC Employers</b></font></P>
                                            <?php
                                            $dbh =& XMEC::getDB();
                                            $sql = "SELECT company, COUNT(*) AS Entries FROM xmec_user GROUP BY company ORDER by Entries DESC LIMIT 1,5;";
                                                    if (DB::isManip($sql)) {
                                                            echo "No manipulation queries please !";
                                                    } else {
                                                            $r = $dbh->query(XMEC_user::unQuote($sql));
                                                            if (DB::isError($r)) {
                                                                    echo "Query: $sql failed.";
                                                            } else {
                                                                    echo "<table border=0>";
                                                                    while (is_array($x = $r->fetchRow())) {
                                                                      echo "<tr>";
                                                                      for ($i=0; $i<count($x); $i++) echo "<td class=body>$x[$i]</td>";
                                                                      echo "</tr>";
                                                                      }
                                                                    echo "<tr><td colspan=2 align=right><P><A href=companies.php class=link>...more</A></P></td><tr>";
                                                                    echo "</table>";
                                                            }
                                                            echo "</td>";
                                            }
                                            ?>
                                            </td>
                                             <TD width=5 height=100><img src="images/space.gif"></TD>
                                                    <TD width=225 valign=top bgcolor="#F9FFDF">
                                                    <P ><font color=#456B52><b>Top XMEC Jobs</B></font></P>
                                                    <?php
                                                    $dbh =& XMEC::getDB();
                                                    $sqle = "SELECT work_type, COUNT(*) AS Entries FROM xmec_user GROUP BY work_type ORDER by Entries DESC LIMIT 1,5;";
                                                            if (DB::isManip($sqle)) {
                                                                    echo "No manipulation queries please !";
                                                            } else {
                                                                    $r = $dbh->query(XMEC_user::unQuote($sqle));
                                                                    if (DB::isError($r)) {
                                                                            echo "Query: $sqle failed.";
                                                                    } else {
                                                                            echo "<table border=0>";
                                                                            while (is_array($x = $r->fetchRow())) {
                                                                              echo "<tr>";
                                                                              for ($i=0; $i<count($x); $i++) echo "<td class=body>$x[$i]</td>";
                                                                              echo "</tr>";
                                                                            }
                                                                            echo "<tr><td colspan=2 align=right><P><A href=aow.php class=link>...more</A></P></td><tr>";
                                                                            echo "</table>";
                                                                            echo "</td>";
                                                                    }

                                                    }
                                            ?>
                                            </td>
                                            </TR>
                                            <TR>
                                                    <TD width=225 valign=top bgcolor="#CEE3C1">
                                            <P BORDER=1><font color=#DE650C ><b>Current XMEC Poll</b></font></P>
                                    <?php
                                                    $dbh =& XMEC::getDB();
                                                    $sql = "SELECT title FROM poll_questions WHERE (".
                                            "(start_date <= NOW()) AND ".
                                            "(end_date >= NOW()) )";
                                                            if (DB::isManip($sql)) {
                                                                    echo "No manipulation queries please !";
                                                            } else {
                                                                    $r = $dbh->query(XMEC_user::unQuote($sql));
                                                                    if (DB::isError($r)) {
                                                                            echo "Query: $sql failed.";
                                                                    } else {

                                                                            while (is_array($x = $r->fetchRow())) {
                                                                              for ($i=0; $i<count($x); $i++) echo "<P><a href=polls.php class=flink>$x[$i]</a><BR></P>";
                                                                                    }
                                                                                    }
                                                                                    echo "</td>";
                                                    }
                                                    ?>
                                            </td>

                                            <TD width=5 ><img src="images/space.gif"></TD>
                                                    <TD width=225 valign=top class=name bgcolor="#FBB3AA">
                                                    <P ><font color=#574844><B>Webmasters' Note</B></font></P>
                                                    <P><a href=invite.php class=flink>Wish to join the XMEC.net development?</A></P>
                                            </td>
                                            </TR>

                                            <TR>

                                    <?} else { ?>
					<p><b>xMEC</b> is the abbreviation for exMECians, the Alumni Association of <b>Model Engineering College, Thrikkakara, Kochi</b>. xMEC is an autonomous body representing thousand three hundred and more engineers who have earned their degrees in
  	Model Engineering College. It binds together MECians who are spread out in institutions and industries around the globe.</p><p> The backbone of xMEC is the relentless support and cooperation of all exMECians who live in India and abroad and
  	who are proud to announce <b>"MEC made me what I'm today"</b>.</p> <? } ?>
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
                                            <td align="center"><input id="rollno" name=rollno type=text class=box size=10 /></td>
                                      </tr>
                                      <tr>
                                            <td class=fname>Password</td>
                                            <td align="center"><input id="passwd" name=passwd type=password class=box  size=10 /></td>
                                      </tr>
                                      <tr rowspan="2">
                                          <td></td><td align="center"><button>Submit</button></td>
                                      </tr>
                                      <tr>
                                          <td></td><td align="center"><a class=link href="loginerror.php"><b>Forgot Password?</b></a></td>
                                      </tr>
                                      <tr align="right"><td></td>
                                          <td align="center">
                                              <div href="login.php" class="fb-login-button" data-scope="email,user_checkins" align="center">
                                                    Login with Facebook
                                              </div>
<!--                                              <fb:login-button href="login.php" autologoutlink='true' perms='email,user_checkins'>Login with Facebook</fb:login-button>-->
                                          </td>
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

                <div class="Cpad">
                    <br class="clear" /><div class="Cbottomleft"></div><div class="Cbottom" style="background-image: url('images/bg_page_index.gif')"></div><div class="Cbottomright"></div>
                </div><!-- Cpad -->
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
