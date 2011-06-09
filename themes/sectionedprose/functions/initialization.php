<?php
//
// Per the twentyten theme, set the content width.	 We are, of course, guessing, as the
// theme is measured in ems, not pixels.

if( !isset($content_width) )
{
	$content_width = 36.25 * 16;
}


//
// Announce our capabilities to WordPress.

if( !function_exists('sectionedprose_setup') ) 
{
	function sectionedprose_setup() 
	{
	   add_theme_support('post-thumbnails');
	   add_theme_support('automatic-feed-links');

   	register_nav_menus(array('primary' => 'Main Menu'));
	   add_custom_background();

      //
      // Per twentyten theme.  We don't support header text.
      
	   if( !defined('HEADER_TEXTCOLOR') ) { define('HEADER_TEXTCOLOR', ''); }
   	if( !defined('NO_HEADER_TEXT'  ) ) { define('NO_HEADER_TEXT', true); }

      //
      // Our header is full width (60em at 16 px/em = 960px).  We make the height large enough
      // to accomodate any reasonable banner.
      
   	define('HEADER_IMAGE_WIDTH' , 960);
      define('HEADER_IMAGE_HEIGHT', 400);

	   set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);
	}
}

add_action( 'after_setup_theme', 'sectionedprose_setup' );


//
// Per the twentyten theme, add a filter to ensure any call to wp_page_menu() includes
// a link to the home page.

function sectionedprose_page_menu_args( $args ) 
{
	$args['show_home'] = true;
	return $args;
}

add_filter('wp_page_menu_args', 'sectionedprose_page_menu_args');


//
// Per the twentyten theme, set an excerpt length.

function sectionedprose_excerpt_length( $length ) 
{
	return 80;
}

add_filter('excerpt_length', 'sectionedprose_excerpt_length');


//
// Register our widget areas.

function sectionedprose_widgets_init() 
{
   $layout = array(
      'before_widget' => '<li><section id="%1$s" class="widget %2$s">',
   	'after_widget'  => '</section></li>',
   	'before_title'  => '<header><h1>',
   	'after_title'   => '</h1></header>',
   );

   $sidebars = array(
      array('name' => 'General Navigation'             , 'id' => 'navigation'           , 'description' => 'Appears on the sidebar, footer, or nowhere, depending on the page and site configuration'),
      array('name' => 'Home Sidebar (home page)'       , 'id' => 'home-sidebar'         , 'description' => 'Appears in the middle of the sidebar on the site home page'),
      array('name' => 'Index Sidebar (index pages)'    , 'id' => 'index-sidebar'        , 'description' => 'Appears in the middle of the sidebar on index pages'       ),
      array('name' => 'Article Sidebar (article pages)', 'id' => 'article-sidebar'      , 'description' => 'Appears on the sidebar on article pages'                   ),
      array('name' => 'After Article (article pages)'  , 'id' => 'article-footer'       , 'description' => 'Appears at the bottom of all articles'                     ),
      array('name' => 'Sidebar Top (all pages)'        , 'id' => 'global-sidebar-top'   , 'description' => 'Appears at the top of the sidebar on every page'           ),
      array('name' => 'Sidebar Bottom (all pages)'     , 'id' => 'global-sidebar-bottom', 'description' => 'Appears at the bottom of the sidebar on every page'        ),
      array('name' => 'Footer First (all pages)'       , 'id' => 'global-footer-first'  , 'description' => 'Appears at the top/left of the footer on every page'       ),
      array('name' => 'Footer Last (all pages)'        , 'id' => 'global-footer-last'   , 'description' => 'Appears at the bottom/right of the footer on every page'   ),
   );

   foreach( $sidebars as $sidebar )
   {
      register_sidebar(array_merge($sidebar, $layout));
   }
}

add_action('widgets_init', 'sectionedprose_widgets_init');

