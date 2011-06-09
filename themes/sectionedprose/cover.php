<?php 
   $section_id = get_section_id(); 
   $category   = get_category($section_id); 
   
   global $article_section_id;
   $article_section_id = $section_id;
   if( $article_section = get_property("article_section") )
   {
      if( $child_section_id = get_child_section_id($section_id, $article_section) )
      {
         $article_section_id = $child_section_id;
      }
   }
   
   $first_page_url = null;
   $query = new WP_Query(array("cat" => $article_section_id, "order" => "asc", "posts_per_page" => 1));
   if( $query->have_posts() )
   {
      $query->the_post();
      $first_page_url = get_permalink();
   }
?>
<?php get_header(); ?>

<section id="content" class="body">
<article class="cover <?php echo get_property("article_format", "technical")?>">
   <header>
      <h1><?php echo esc_attr($category->cat_name);?></h1>
      <p><?php echo markup($category->category_description, true);?></p>
   </header>
   
   <?php if( $cover_text = get_property("cover_text") ) { ?>
   <div class="hyphenate">
   <?php echo markup($cover_text);?>
   </div>
   <?php } ?>
   
   <?php if( $first_page_url ) { ?>
   <footer>
   <nav><a rel="next" href="<?php echo esc_url($first_page_url)?>">start reading now &raquo;</a></nav>
   </footer>
   <?php } ?>
</article>
</section>


<aside id="sidebar" class="cover <?php echo is_singular() ? "singular" : "";?>">
<ul class="widget-stack">

<?php if( $first_page_url ) { ?>
   <li><section class="widget">
   <header><h1><a href="<?php echo esc_url($first_page_url)?>">Start reading now &raquo;</a></h1></header>
   </section></li>
<?php } ?>

<?php get_template_part("widget-article-index"); ?>

<?php get_template_part("widget-recent-articles"); ?>

</ul>   
</aside>


<?php get_footer(); ?>
