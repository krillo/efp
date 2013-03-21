<?php
/**
 * @package WordPress
 * @subpackage Eriks Fönsterputs
 */
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php wp_title(''); ?></title>
	<meta name="google-site-verification" content="2XDq2VQS1lf9KL8sPQR3r61WGJDdM1bOE78ERtBAOwI" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicons/eriks-fonsterputs-icon.png">
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-touch-icon-72x72.png" sizes="72x72" />
	<link rel="apple-touch-icon" href="<?php bloginfo('template_directory'); ?>/img/favicons/apple-touch-icon-114x114.png" sizes="114x114" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Signika+Negative:400,300,600,700" type="text/css">
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/normalize.css"  type="text/css"/>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ui-lightness/jquery-ui-1.10.0.custom.min.css"  type="text/css"/>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />

	<!--[if lt IE 9]>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/ie.css" type="text/css" />
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php wp_head(); ?>

	<?php
		if ( is_front_page() ) {
			echo "<script src='/wp-content/themes/eriksfonsterputs/js/jquery.easing.1.3.js' type='text/javascript'></script>";
			echo "<script src='/wp-content/themes/eriksfonsterputs/js/jquery.flipCounter.1.2.pack.js' type='text/javascript'></script>";
		}
	?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	
	
</head>
<body>

<header>
	<section>

		<div class="column grid_12">

			<a id="logo" href="<?php bloginfo('url'); ?>/" title=" Till startsidan "><img src="<?php bloginfo('template_directory'); ?>/img/inline/eriks-fonsterputs-logotype.png" alt="Eriks Fönsterputs - logotype" /></a>

			<ul id="toplist">
				<li id="kundtjanst">Kundtjänst: 0771-42 42 42</li>
				<!--li id="chatt"><a href="/">Chatta med kundtjänst</a></li>-->
				<li id="facebook"><a href="http://www.facebook.com/eriksfonsterputs" target="_blank">Facebook</a></li>
			</ul>

			<?php
				wp_nav_menu(
					array(
						'items_wrap' => '<nav><ul>%3$s</ul></nav>',
						'container' => 'false',
						'theme_location' => 'primary'
					)
				);
			?>

		</div>

	</section>
</header>