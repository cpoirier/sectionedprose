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


   ob_start(); 
   ?><abbr class="published" title="<?php the_time("c")?>"><?php echo get_the_date()?></abbr><?php 
   $posted_meta = ob_get_clean();
   
   ob_start();
   ?><span class="vcard author"><a class="url fn n" href="<?php echo esc_attr(get_author_posts_url(get_the_author_meta('ID')))?>" title="View all posts by <?php echo esc_attr(get_the_author())?>"><?php echo esc_attr(get_the_author())?></a></span><?php
   $author_meta = ob_get_clean();
   
   ob_start();
   the_tags("", ", and ", "");
   $tags_meta = ob_get_clean();
   $terms = substr_count($tags_meta, ">, and <") + 1;
   if( $terms == 2 )
   {
      $tags_meta = str_replace( ">, and <", "> and <", $tags_meta );
   }
   elseif( $terms > 2 )
   {
      $tags_meta = preg_replace("/>, and </", ">, <", $tags_meta, $terms - 2);
   }
   
   $metadata_format = get_property("article_metadata_format", "Posted {posted} by {author}[ under {tags}]");
?>
<div class="article-meta">
   <?php echo sectionedprose_format_article_metadata($metadata_format, $posted_meta, $author_meta, $tags_meta); ?>
</div>
