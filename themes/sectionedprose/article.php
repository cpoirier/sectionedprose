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

   if( sectionedprose_in_github_commit_message() )
   {
      get_template_part("github-commit");
      return;
   }

   global $article_mode;

   $use_excerpt        = ($article_mode == "excerpt");
   $metadata_placement = get_property("article_metadata_placement", "header");
   $article_format     = get_property("article_format", "technical"); 
   $navigation_links   = get_property("navigation_links", "automatic");
   

   //
   // Build a pretty excerpt, if necessary. The WordPress-generated one can be pretty ugly.

   $excerpt = "";
   if( $use_excerpt || (function_exists('is_syndicated') && is_syndicated()) ) 
   {
      ob_start(); 
      the_excerpt(); 
      $excerpt = str_replace("&nbsp;", "", strip_tags(ob_get_clean()));

      ob_start(); 
      ?>&nbsp;.&nbsp;.&nbsp;. <a class="more" title="<?php the_title?>" href="<?php the_permalink()?>">continue&nbsp;reading&nbsp;&raquo;</a><?php
      $more_link = ob_get_clean();

      if( preg_match("/\s*\\[?\\.\\.\\.\\]?\s*$/", $excerpt) )
      {
         $use_excerpt = true;
         ob_start();
         echo "<p>";
         echo preg_replace( "/\s*\\[?\\.\\.\\.\\]?\s*$/", $more_link, $excerpt );
         echo "</p>\n";
         $excerpt = ob_get_clean();
      }
      else
      {
         $use_excerpt = false;
      }
   }
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($article_format)?>>
   <header>
      <?php get_template_part("article-title"); ?>
      <?php if( is_singular() ) { ?>
      <nav>
         <?php edit_post_link('edit', '', '&nbsp;&nbsp; '); ?>
         <?php if( is_single() && $navigation_links != "disabled" ) { ?>
         <?php sectionedprose_previous_page_link("%link &nbsp;", "&laquo; previous")?>
         <?php sectionedprose_next_page_link("&nbsp; %link", "next &raquo;")?>
         <?php } ?>
      </nav>
      <?php } ?>

      <?php
         if( (is_single() && $metadata_placement == "header") || (!is_singular() && $metadata_placement != "disabled") ) 
         { 
            get_template_part("article-metadata"); 
         } 
      ?>
   </header>
   
   
   <div class="<?php echo $use_excerpt ? "excerpt" : "content"?> clear hyphenate">
      <!-- <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit accumsan</p> -->
      <?php 
         if( $use_excerpt )
         {
            echo $excerpt;
         }
         else
         {
            the_content();
         }
      ?>
   </div>
   
   <?php if( is_single() ) { ?>
   <footer>
      <?php if( $navigation_links != "disabled" ) { ?>
      <nav>
         <?php sectionedprose_previous_page_link("%link &nbsp;", "&laquo; previous")?>
         <?php sectionedprose_next_page_link("&nbsp; %link", "next &raquo;")?>
      </nav>
      <?php } ?>
      <?php
         ob_start();
         foreach( array("Afterword") as $field )
         {
            if( $value = get_post_meta($post->ID, $field, true) )
            {
               ?><dt><?php echo esc_attr($field)?></dt><dd><?php echo markup($value)?></dd>
               <?php
            }
         }

         if( $fields = ob_get_clean() ) 
         {
            echo "<dl id=\"meta\">\n";
            if( $metadata_placement == "footer" ) 
            {  
               echo "<dt></dt><dd>\n";
               get_template_part("article-metadata"); 
               echo "</dd>\n";
            } 
            echo $fields;
            echo "</dl>\n";
            echo "<script>fadeWorthy.push(\"#meta\");</script>\n";
         }
         else if( $metadata_placement == "footer" )  
         {
            get_template_part("article-metadata"); 
         }
  
         get_sidebar("article-footer");
      ?>
      
   </footer>
   <?php } ?>
</article>

   
