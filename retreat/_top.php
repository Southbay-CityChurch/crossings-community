<!DOCTYPE html>
<!--[if IE 6]> <html id="ie ie67  ie6" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 7]> <html id="ie ie67  ie7" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 8]> <html id="ie ie678 ie8" dir="ltr" lang="en-US"> <![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!--> <html dir="ltr" lang="en-US"> <!--<![endif]-->
	<head>
		<title>Crossings Beach Retreat <?= date('Y'); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="en-us" />
		<meta http-equiv="imagetoolbar" content="false" />
		<meta name="robots" content="all" />
		<meta name="MSSmartTagsPreventParsing" content="true" />
		<meta name="author" content="Crossings Community Church" />
		<meta name="Copyright" content="Copyright (c) <?= date('Y'); ?>" />
		<meta name="description" content="Crossings Beach Retreat <?= date('Y'); ?>" />
		<meta name="keywords" content="Crossings Community Beach Retreat" />
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" title="Style Sheet" charset="utf-8" />
		<?php
			if(isset($here)) {
				echo '<style type="text/css">#navigation li a.' . $here[0] . ' {background-image: url("images/nav/' . $here[1] . '.gif");}</style>';
			}
			elseif(isset($inline_style)) {
				echo '<style type="text/css">' . $inline_style . '</style>';   
			}

		?>
		<link rel="stylesheet" href="css/print.css" type="text/css" media="print" charset="utf-8" />
	</head>
	<body>
		<div id="contain">