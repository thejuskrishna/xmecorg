<?php

/*
    Command to generate thumbnails of images:
    mogrify -resize 100x80 -background white -gravity center -extent 100x80 *
 */

$secure_page=0;
$this_page = "gallery";

$imgdir="gallery/big";
$imghandle=opendir($imgdir);
$thumbdir="gallery/thumbnails";

$imgFiles = array();
if ($imghandle = opendir($imgdir)) {
    while (false !== ($file = readdir($imghandle))) {

        $crap   = array(".jpg", ".jpeg", ".JPG", ".JPEG", ".png", ".PNG", ".gif", ".GIF", ".bmp", ".BMP", "_", "-");
        $newstring = str_replace($crap, " ", $file );
        if ($file != "." && $file != ".." && $file != "index.php" && $file != "Thumbnails") {
                $imgFiles[] = $file;
        }
    }
    closedir($imghandle);
}

sort($imgFiles);

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
    $(document).ready(function() {
        $("#content").css('background-image','url(images/bg_page_index.gif)');
        $(".Cbottom").css('background-image','url(images/bg_page_index.gif)');
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
                <div id="gallery" class="content">
                    <div id="controls" class="controls"></div>
                    <div class="slideshow-container">
                            <div id="loading" class="loader"></div>
                            <div id="slideshow" class="slideshow"></div>
                    </div>
                    <div id="caption" class="caption-container"></div>
                </div>

                <div id="navigation">
                    <ul class="thumbs noscript">
                        <?
                        //$picinfo=fopen("gallery/pictureinfo-en.txt", "r");

                        foreach($imgFiles as $file)
                        {
                //            $line=fgetss($picinfo);
                //            $pic_title=str_replace($file, "", $line);
                //            echo $pic_title.'<br><br>';
                            echo
                            '<li>
                                    <a class="thumb" href="gallery/scaled/'.$file.'">
                                            <img src="'.$thumbdir.'/'.$file.'" />
                                    </a>
                                    <div class="caption">
                                            <div class="download">
                                                    <a href="'.$imgdir.'/'.$file.'">Download</a>
                                            </div>
                                            <div class="image-title"></div>
                                            <div class="image-desc"></div>
                                    </div>
                            </li>';
                        }
                        //fclose($picinfo);
                        ?>

                <!--        <li>
                                <a class="thumb" name="leaf" href="http://farm4.static.flickr.com/3261/2538183196_8baf9a8015.jpg" title="Title #0">
                                        <img src="http://farm4.static.flickr.com/3261/2538183196_8baf9a8015_s.jpg" alt="Title #0" />
                                </a>
                                <div class="caption">
                                        <div class="download">
                                                <a href="http://farm4.static.flickr.com/3261/2538183196_8baf9a8015_b.jpg">Download Original</a>
                                        </div>
                                        <div class="image-title">Title #0</div>
                                        <div class="image-desc">Description</div>
                                </div>
                        </li>-->
                    </ul>
                </div>

<?php
include 'footer.php';
?>
