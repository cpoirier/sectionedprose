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

   global $index_behaviour, $article_mode, $index_mode;
   $index_behaviour = 'excerpts';
   $article_mode    = 'content';
   $index_mode      = 'articles';

   if( is_singular() ) 
   {
      get_template_part("singular");
      exit;
   }
   else if( is_home() || is_category() )
   {
      $scope = is_home() ? "theme" : "section";
      $section_id = -1;

      if( is_home() )
      {
         $index_behaviour = get_property("home_template", $index_behaviour);
      }
      else
      {
         $section_id = get_section_id();
      }
 
      $index_behaviour = get_property("index_behaviour", $index_behaviour, $scope, 1, $section_id);
      $switch = 0 + get_property("change_index_behaviour_after", 0, $scope, 1, $section_id);
      if( $switch > 0 && have_posts() )
      {
         the_post();
         if( strtotime($post->post_date) <= time() - (3600 * 24 * $switch) )
         {
            $index_behaviour = get_property("index_behaviour_alt", $index_behaviour, $scope, 1, $section_id);
         }
         rewind_posts();
      }

      switch( $index_behaviour )
      {
         case 'category':
         case 'excerpts':
            $article_mode = 'excerpt';
            break;

         case 'titles':
            $index_mode = 'titles';
            break;
   
         case 'titles+':
            $index_mode = 'feature';
            break;
   
         case 'blank':
            $index_mode = 'empty';
            break;
    
         case "latest":
         case "first":
            query_posts(array("cat" => $section_id, "order" => $index_behaviour == "first" ? "asc" : "desc", "posts_per_page" => 1));
            if( have_posts() )
            {
               the_post();
               wp_redirect( get_permalink() );
               exit;
            }
            break;
         case "cover":
            require(STYLESHEETPATH . "/cover.php");
            exit;
      }
   }
?>
<?php $category = is_category() ? get_category(get_query_var("cat")) : null; ?>
<?php get_header(); ?>

<div id="main">
<?php get_template_part("widebar"); ?>

<section id="content" class="index">
   <?php if( is_archive() || $paged > 1 ) { ?>
   <header>
      <?php if( $category ) { ?>
         <?php if( trim($category->category_description) ) { echo markdown($category->category_description); echo "<hr/>\n"; } ?>
         <h2>Articles related to <i><?php echo esc_attr($category->cat_name);?></i></h2>
      <?php } else if( $paged > 1 ) { ?>
         <h2>. . . page <?php echo $paged?></h2>
      <?php } ?>
   </header>
   <?php } ?>

   <?php 
      if( $index_mode != "empty" )
      {
         if( have_posts() ) 
         {
            if( $index_mode == "feature" && $paged == 0 )
            {
               the_post();
               get_template_part("article"); 
            }
   
            if( $index_mode == "titles" || $index_mode == "feature" )
            {
               echo "<div class=\"title-list\">\n";
               while( have_posts() )
               {
                  the_post();
                  ?><article id="post-<?php the_ID(); ?>"><header>
                     <?php get_template_part("article-title"); ?>
                     <?php get_template_part("article-metadata"); ?>
                  </header></article>
                  <?php
               }
               echo "</div>\n";
            }
            else
            {
               while( have_posts() ) 
               {
                  the_post();
                  get_template_part("article"); 
               }
            }
         }
         else
         {
            echo "no matches";
         } 
      }
   ?>

   <?php if( $wp_query->max_num_pages > 1 ) { ?>
   <footer>
      <nav><?php next_posts_link('&larr; Older posts'); ?> <?php previous_posts_link('Newer posts &rarr;'); ?></nav>
   </footer>
   <?php } ?>
   
</section>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
