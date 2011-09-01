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
<?php $navigation_links = get_property("navigation_links", "automatic"); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("github-commit")?>>
   <header>
      <?php if( $subtitle ) { echo "<hgroup>\n"; } ?>
      <h1>
         <a href="<?php the_permalink()?>" title="<?php the_title_attribute()?>" rel="bookmark"><?php echo get_the_date("Y-m-d H:i")?></a>:
         committed to <?php $category = get_the_category(); echo $category[0]->cat_name; ?>
      </h1>

      <?php if( is_singular() ) { ?>
      <nav>
         <?php if( is_single() && $navigation_links != "disabled" ) { ?>
         <?php sectionedprose_previous_page_link("%link &nbsp;", "&laquo; previous")?>
         <?php sectionedprose_next_page_link("&nbsp; %link", "next &raquo;")?>
         <?php } ?>
      </nav>
      <?php } ?>
   </header>
   
   <div class="content clear">
      <?php $content = get_the_content(); $pieces = explode("</pre>", $content, 2); ?>
      <p class="message"><?php echo strip_tags($pieces[1]);?></p>
      <pre><code><?php echo trim(strip_tags($pieces[0]));?></code></pre>
   </div>
   
   <?php if( is_singular() ) { ?>
   <footer>
      <?php if( $navigation_links != "disabled" ) { ?>
      <nav>
         <?php sectionedprose_previous_page_link("%link &nbsp;", "&laquo; previous")?>
         <?php sectionedprose_next_page_link("&nbsp; %link", "next &raquo;")?>
      </nav>
      <?php } ?>
      
   </footer>
   <?php } ?>
</article>

   
