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



//
// Clean up the GitHub commit message formatting, when displayed in_the_loop().

add_filter('the_title_rss', 'sectionedprose_filter_the_title');
function sectionedprose_filter_the_title( $title )
{
   if( sectionedprose_in_github_commit_message() )
   {
      return sectionedprose_get_github_commit_title();
   }

   return $title;
}

add_filter('the_content_rss', 'sectionedprose_filter_the_content', 20000);  // FeedWordPress tries to outsmart us at 10000
add_filter('the_content'    , 'sectionedprose_filter_the_content', 20000);
function sectionedprose_filter_the_content( $content )
{
   if( sectionedprose_in_github_commit_message() )
   {
      if( $pieces = explode("</pre>", $content, 2) )
      {
         ob_start();
         ?><p class="message"><?php echo trim(strip_tags($pieces[1]));?></p>
         <pre><code><?php echo trim(strip_tags($pieces[0]));?></code></pre><?php
         $content = ob_get_clean();
      }
   }

   return $content;
}

add_filter('the_excerpt_rss', 'sectionedprose_filter_the_excerpt', 20000);
function sectionedprose_filter_the_excerpt( $excerpt )
{
   if( sectionedprose_in_github_commit_message() )
   {
      ob_start();
      the_content();
      return ob_get_clean();
   }

   return $excerpt;
}




function sectionedprose_in_github_commit_message()
{
   global $post;
   return in_the_loop() && function_exists('is_syndicated') && is_syndicated() && is_numeric(strpos(get_post_meta($post->ID, 'syndication_feed', true), "https://github.com"));
}

function sectionedprose_get_github_commit_title()
{
   $commit = get_the_date("Y-m-d H:i");
   $repository = "";

   if( $tags = get_the_tags() ) 
   {
      foreach( $tags as $tag )
      {
         if( is_numeric(strpos($tag->description, "https://github.com")) )
         {
            $repository = $tag->name;
         }
         break;
      }
   }

   return sectionedprose_github_commit_title_format($commit, $repository);
}

function sectionedprose_the_github_commit_title()
{
   global $post;
   $permalink = get_post_meta($post->ID, 'syndication_permalink', true);

   ob_start();
   ?><a href="<?php echo esc_url($permalink)?>" title="<?php the_title_attribute()?>" rel="bookmark"><?php echo get_the_date("Y-m-d H:i")?></a><?php
   $commit = ob_get_clean();
   $repository = "";

   if( $tags = get_the_tags() ) 
   {
      ob_start();
      foreach( $tags as $tag ) 
      { 
         if( is_numeric(strpos($tag->description, "https://github.com")) )
         {
            ?><a href="<?php echo esc_url($tag->description)?>" title="github repository"><?php echo $tag->name;?></a><?php 
         }
         break; 
      } 
      $repository = ob_get_clean();
   }

   echo sectionedprose_github_commit_title_format($commit, $repository);
}

function sectionedprose_github_commit_title_format( $commit, $repository = "" )
{
   $format = null;

   if( $repository && strlen($repository) > 0 )
   {
      $format = get_property('github_tagged_commit_title_format', "{repository} updated at {commit}");
      $format = str_replace("{repository}", $repository, $format);
   }
   else
   {
      $format = get_property('github_commit_title_format', "Commit: {commit}");
   }

   return str_replace("{commit}", $commit, $format);
}


