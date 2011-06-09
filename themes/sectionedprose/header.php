<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php sectionedprose_title();?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="<?php bloginfo("template_url")?>/javascript/hyphenate.js" async></script>
<?php if( current_user_can('manage_options') ) { ?>
<script src="<?php bloginfo("template_url")?>/javascript/faders.js"></script>
<script src="<?php bloginfo("template_url")?>/javascript/code.js"></script>
<?php } else { ?>
<script src="<?php bloginfo("template_url")?>/javascript/all.js"></script>
<?php } ?>
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php wp_head();?>
<?php sectionedprose_styles();?>
<script>var fadeWorthy = ["#footer"];</script>
</head>




<body id="body" <?php body_class(); ?>>

<header id="header" class="container">
   <hgroup>
      <h1><?php sectionedprose_section_title()?></h1>
      <h2><?php sectionedprose_section_subtitle()?></h2>
   </hgroup>

   <?php sectionedprose_header_image(); ?>

   <?php sectionedprose_nav_menu("primary"); ?>
</header>

<div id="main" class="container">

