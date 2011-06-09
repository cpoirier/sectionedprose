<?php $category = is_category() ? get_category(get_query_var("cat")) : null; ?>
<?php get_header(); ?>

<section id="content" class="<?php echo is_singular() ? "singular" : "index"?>">
   <?php if( is_archive() || (false && $wp_query->max_num_pages > 1) ) { ?>
   <header>
      <?php if( false && $wp_query->max_num_pages > 1 ) { ?>
      <nav><?php next_posts_link('&larr; Older posts'); ?> <?php previous_posts_link('Newer posts &rarr;'); ?></nav>
      <?php } ?>
      <?php if( $category ) { ?>
         <?php if( trim($category->category_description) ) { echo markdown($category->category_description); echo "<hr/>\n"; } ?>
         <h2>Articles related to <i><?php echo esc_attr($category->cat_name);?></i></h2>
      <?php } ?>
   </header>
   <?php } ?>

   <?php 
      if( have_posts() ) 
      {
         while( have_posts() ) 
         { 
            the_post();
            get_template_part("article"); 
         }
      }
      else
      {
         echo "no matches";
      }
   ?>

   <?php if( $wp_query->max_num_pages > 1 ) { ?>
   <footer>
      <nav><?php next_posts_link('&larr; Older posts'); ?> <?php previous_posts_link('Newer posts &rarr;'); ?></nav>
   </footer>
   <?php } elseif( is_singular() ) {  ?>
   <footer>
      <section id="comments">
      <?php comments_template( '', true ); ?>   
      </section>
   </footer>
   <?php } ?>
   
   
   
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
