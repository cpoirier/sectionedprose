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

$query = new WP_Query(array("cat" => $article_section_id, "order" => "desc", "posts_per_page" => 5));
if( $query->have_posts() ) 
{
   ?>
   <li><section id="recent-articles" class="widget">
      <header>
         <h1>Recent Updates</h1>
      </header>
   <ul>
   <?php 
      while( $query->have_posts() ) 
      { 
         $query->the_post();
         $raw_excerpt = strip_tags(substr($post->post_content, 0, 200));
         $words       = explode(" ", $raw_excerpt);
         $excerpt     = trim(strip_tags(markup(implode(" ", array_slice($words, 0, 10)), true)));
         
         ?><li><a href="<?php the_permalink();?>" title="direct link to <?php the_title();?>"><?php the_title();?></a> <?php echo $excerpt;?>&nbsp;.&nbsp;.&nbsp;. </li>
         <?php
      } 
   ?>
   </ul>
   </section></li>
   <?php
   wp_reset_query();
}
