<!DOCTYPE html>
<!--[if IE 6]> <html id="ie ie67  ie6" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 7]> <html id="ie ie67  ie7" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 8]> <html id="ie ie678 ie8" dir="ltr" lang="en-US"> <![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!--> <html dir="ltr" lang="en-US"> <!--<![endif]-->
	<head>
		<title>Crossings Community - Sermons</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="en-us" />
		<meta http-equiv="imagetoolbar" content="false" />
		<meta name="robots" content="all" />
		<meta name="MSSmartTagsPreventParsing" content="true" />
		<meta name="author" content="Crossings Community Church" />
		<meta name="Copyright" content="Copyright (c) <?php echo date('Y'); ?>" />
		<meta name="description" content="Sermons from the Leaders of Crossings Community Church" />
		<meta name="keywords" content="Biblical Sermons, Crossings, Podcast, Christianity, Campbell CA," />
		<link rel="alternate" type="application/rss+xml" title="Series Podcast" href="http://crossingscommunity.com/sermons/app/podcast/" />
		<link href="/sermons/public/stylesheets/basic.css" type="text/css" media="all" rel="stylesheet" />
		<script type="text/javascript" src="/js/jquery.js"></script>
		<?php	if($_SERVER['REQUEST_URI'] == '/sermons/') { ?>
			<script type="text/javascript" charset="utf-8">
				$(document).ready(function(){
					$("#sermons").addClass("selected");
				});
			</script>
		<?php	} ?>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<a href="/" style="width:100%;height:100%;display:block;">
				</a>
			</div>
			<div id="nav">
				<ul>
					<li id="about"><a href="/about.php">About Crossings</a></li>
					<li id="sermons"><a href="/sermons/">Sermons</a></li>
					<li id="worship"><a href="/songs.php">Songs</a></li>
					<li id="critter"><a href="/critter-crossings.php">Critter Crossings</a></li>
					<li id="members"><a href="/members.php">Members</a></li>
					<li id="events"><a href="/events.php">Rest of Week</a></li>
					<li id="contact"><a href="/contact.php">Contact Us</a></li>
				</ul>
			</div>
			<div id="content">
				<?php $__layout->yield(); ?>
			</div>
		</div>

		<?php include($_SERVER['DOCUMENT_ROOT'] . '/inc/_footer.php'); ?>

	</body>
</html>
