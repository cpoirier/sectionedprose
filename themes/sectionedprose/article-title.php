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

   //
   // Build a subtitle, if the content came from a note-worthy source.

   $subtitle = null;
   if( function_exists('is_syndicated') && is_syndicated() )
   {
      ob_start();
      ?><a href="<?php the_syndication_source_link()?>"><?php echo get_feed_meta("Feed Tag")?></a><?php
      $subtitle = ob_get_clean();
   }
   elseif( !is_singular() && !is_category() )
   {
      if( $section_id = get_master_section_id() )
      {
         $category = get_category($section_id);

         ob_start();
         ?><a href="<?php echo esc_url(get_category_link($section_id))?>" title="link to <?php echo esc_attr($category->cat_name)?>"><?php echo esc_attr($category->cat_name);?></a><?php
         $subtitle = ob_get_clean();
      }
   }
?>
<?php if( $subtitle ) { echo "<hgroup>\n"; } ?>
<h1><a href="<?php the_permalink()?>" title="<?php the_title_attribute()?>" rel="bookmark"><?php the_title()?></a></h1> 
<?php if( $subtitle ) { echo "<h2>"; echo $subtitle; echo "</h2>\n"; echo "</hgroup>\n"; } ?>

   
