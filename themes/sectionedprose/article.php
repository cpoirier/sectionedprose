<?php 
   $use_excerpt = is_archive() || is_search() || (is_home() && get_property('home_template', 'blog') == 'excerpts'); 
   $metadata_placement = get_property("article_metadata_placement", "header");
   $article_format = get_property("article_format", "technical"); 
   
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
<article id="post-<?php the_ID(); ?>" <?php post_class($article_format)?>>
   <header>
      <?php if( $subtitle ) { echo "<hgroup>\n"; } ?>
      <h1><a href="<?php the_permalink()?>" title="<?php the_title_attribute()?>" rel="bookmark"><?php the_title()?></a></h1> 
      <?php if( $subtitle ) { echo "<h2>"; echo $subtitle; echo "</h2>\n"; echo "</hgroup>\n"; } ?>

      <?php if( is_singular() ) { ?>
      <nav>
         <?php edit_post_link('edit', '', '&nbsp;&nbsp; '); ?>
         <?php if( is_single() ) { ?>
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
               echo "<p>";
               echo preg_replace( "/\s*\\[?\\.\\.\\.\\]?\s*$/", $more_link, $excerpt );
               echo "</p>\n";
            }
            else
            {
               $use_excerpt = false;
            }
         }

         if( !$use_excerpt )
         {
            the_content();
         }
      ?>
   </div>
   
   <?php if( is_single() ) { ?>
   <footer>
      <nav>
         <?php sectionedprose_previous_page_link("%link &nbsp;", "&laquo; previous")?>
         <?php sectionedprose_next_page_link("&nbsp; %link", "next &raquo;")?>
      </nav>
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

   
