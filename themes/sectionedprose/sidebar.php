<?php
// =============================================================================================
// SectionedProse
//
// [Copyright] Copyright 2011 Chris Poirier
// [License]   Licensed under the Apache License, Version 2.0 (the "License");
//             you may not use this file except in compliance with the License.
//             You may obtain a copy of the License at
//
//                 http://www.apache.org/licenses/LICENSE-2.0
//
//             Unless required by applicable law or agreed to in writing, software
//             distributed under the License is distributed on an "AS IS" BASIS,
//             WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//             See the License for the specific language governing permissions and
//             limitations under the License.
// =============================================================================================

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

   <?php if( is_front_page() && is_active_sidebar('home-sidebar') ) { ?>
   <ul id="home-sidebar" class="widget-stack body">
   	<?php dynamic_sidebar('home-sidebar'); ?>
   </ul>
   <?php } ?>

   <?php if( (is_front_page() || !is_singular()) && is_active_sidebar('index-sidebar') ) { ?>
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

<?php if( is_singular() && !is_front_page() ) { ?>
<script>fadeWorthy.push("#sidebar");</script>
<?php } ?>
