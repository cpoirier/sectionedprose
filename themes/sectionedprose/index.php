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
?>
<?php $home_template = get_property('home_template', 'blog'); ?>
<?php $category = is_category() ? get_category(get_query_var("cat")) : null; ?>
<?php get_header(); ?>

<?php if( is_home() && ($home_template == 'widgets' || is_active_sidebar('home-sidebar')) ) { ?>
<aside id="widebar">
   <ul id="home-main" class="widget-stack body">
        <?php dynamic_sidebar('home-main'); ?>
   </ul>
</aside>
<?php } ?>


<?php if( !is_home() || $home_template != 'widgets' ) { ?>
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
            if( function_exists('is_syndicated') && is_syndicated() && !(strpos(get_permalink(), "https://github.com") === false) )
            {
               get_template_part("github-commit");
            }
            else
            {
               get_template_part("article"); 
            }
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
<?php } ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
