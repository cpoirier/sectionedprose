<?php
   global $copyright_placement, $navigation_placement, $news_placement;
   $copyright_placement = $navigation_placement = $news_placement = "disabled";

   if( is_home() )
   {
      $navigation_placement = "sidebar1";
   }
   elseif( is_singular() )
   {
      $copyright_placement  = get_property("article_copyright_placement" , "disabled");
      $navigation_placement = get_property("section_navigation_placement", "sidebar1");   
      $news_placement       = get_property("section_news_placement"      , "sidebar1");   
   }
   else
   {
      $navigation_placement = "sidebar1";
      $news_placement       = "sidebar1";
   }
   
   function get_special_sidebars( $position )
   {      
      global $copyright_placement, $navigation_placement, $news_placement;
      if( $copyright_placement  == $position ) { get_template_part("widget-stack-article-copyright");  }
      if( $navigation_placement == $position ) { get_template_part("widget-stack-section-navigation"); }
      if( $news_placement       == $position ) { get_template_part("widget-stack-section-news");       }
   }
?>
<aside id="sidebar" class="<?php echo is_singular() ? "singular" : "";?>">

   <?php if( is_active_sidebar('global-sidebar-top') ) { ?>
   <ul id="global-sidebar" class="widget-stack body">
		<?php dynamic_sidebar('global-sidebar-top'); ?>
   </ul>
   <?php } ?>
   
   <?php get_special_sidebars( $at = "sidebar1" ); ?>

   <?php if( is_home() && is_active_sidebar('home-sidebar') ) { ?>
   <ul id="home-sidebar" class="widget-stack body">
   	<?php dynamic_sidebar('home-sidebar'); ?>
   </ul>
   <?php } ?>

   <?php if( !is_singular() && is_active_sidebar('index-sidebar') ) { ?>
   <ul id="index-sidebar" class="widget-stack body">
   	<?php dynamic_sidebar('index-sidebar'); ?>
   </ul>
   <?php } ?>
   
   <?php get_special_sidebars( $at = "sidebar2" ); ?>
   <?php get_special_sidebars( $at = "sidebar3" ); ?>

   <?php if( is_active_sidebar('global-sidebar-bottom') ) { ?>
   <ul id="global-sidebar" class="widget-stack body">
		<?php dynamic_sidebar('global-sidebar-bottom'); ?>
   </ul>
   <?php } ?>
   
</aside>

<?php if( is_singular() ) { ?>
<script>fadeWorthy.push("#sidebar");</script>
<?php } ?>
