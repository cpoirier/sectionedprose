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
<?php get_header(); ?>
<section id="content" class="singular">
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

   <footer>
      <section id="comments">
      <?php comments_template( '', true ); ?>   
      </section>
   </footer>
   
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
