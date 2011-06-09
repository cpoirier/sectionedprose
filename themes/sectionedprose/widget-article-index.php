<?php

global $article_section_id;
if( !$article_section_id )
{
   $article_section_id = get_section_id();
   if( $article_section = get_property("article_section") )
   {
      if( $child_section_id = get_child_section_id($article_section_id, $article_section) )
      {
         $article_section_id = $child_section_id;
      }
   }
}

$article_limit = 0 + get_property("index_limit", 30);
if( $article_limit < 1 )
{
   $article_limit = 30;
}

$query = new WP_Query(array("cat" => $article_section_id, "order" => "asc", "posts_per_page" => $article_limit + 1));
if( $query->have_posts() ) 
{
   ?>
   <li><section id="article-index" class="widget">
   <?php if( $title = get_property("index_title") ) { ?>
      <header>
         <h1><?php echo esc_attr($title)?></h1>
      </header>
   <?php } ?>
   <ol class="inline">
   <?php 
      $m = null;
      $limit = $article_limit;
      while( $query->have_posts() && $limit > 0 ) 
      { 
         $query->the_post();
         ?><li><a href="<?php the_permalink();?>" title="direct link to <?php the_title();?>"><?php echo esc_attr(sectionedprose_simplify_article_title());?></a></li>
         <?php

         $limit -= 1;

         //
         // Disqus does bad things in an empty $query->have_posts(), and it must be stopped.

         ob_start();
         if( !$query->have_posts() )
         {
            ob_end_clean();
            break;
         }
         ob_end_clean();
      } 

      if( count($query->posts) > $article_limit )
      {
         echo "<li>. . . </li>";
      }
   ?>
   </ol>
   </section></li>
   <?php
   ob_start();
   wp_reset_query();
   ob_end_clean();
}
