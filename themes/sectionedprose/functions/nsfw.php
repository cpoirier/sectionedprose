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
// Hide content for NSFW content until explicitly requested.

add_filter('the_content_rss', 'sectionedprose_filter_nsfw_content', 20000);  // FeedWordPress tries to outsmart us at 10000
add_filter('the_content'    , 'sectionedprose_filter_nsfw_content', 20000);  // FeedWordPress tries to outsmart us at 10000
add_filter('the_excerpt_rss', 'sectionedprose_filter_nsfw_content', 20000);
add_filter('the_excerpt'    , 'sectionedprose_filter_nsfw_content', 20000);
function sectionedprose_filter_nsfw_content( $text )
{
   if( !is_user_logged_in() && has_tag("nsfw") )
   {
      if( is_singular() && isset($_GET["nsfw"]) )
      {
         if( $_GET["nsfw"] == "okay" || $_GET["nsfw"] == "set" )
         {
            if( !defined("DONOTCACHEPAGE") )
            {
               define("DONOTCACHEPAGE", 1);
            }
     
            if( $_GET["nsfw"] == "set" )
            {
               $parts = parse_url(site_url());
               setcookie("nsfw", "okay", 0, $parts["path"], $parts["host"]);
               header("Location: " . preg_replace('/([?&])nsfw=[^&]*/i', '\\1nsfw=okay', $_SERVER['REQUEST_URI']));
               exit;
            }
            else if( isset($_COOKIE["nsfw"]) && $_COOKIE["nsfw"] == "okay" )
            {
               // fall through with the unaltered text
            }
            else
            {
               header("Location: " . preg_replace('/[?&]nsfw=[^&]*/i', "", $_SERVER['REQUEST_URI']));
               exit;
            }
         }
         else
         {
            header("Location: " . preg_replace('/[?&]nsfw=[^&]*/i', "", $_SERVER['REQUEST_URI']));
            exit;
         }
      }
      else
      {
         global $post, $withcomments;
         $withcomments = false;
         $post->comment_status = 'closed';
         ob_start(); 
?>
<form class="nsfw" name="nsfw-<?php echo $post->ID?>" method="GET" action="<?php the_permalink()?>">
<p>This entry has been marked Not Safe For Work. 
   <input name="nsfw" type="hidden" value="set"/>
   <input type="submit" value="Open it?"/>
</p>
</form>
<?php
         $text = ob_get_clean();
      }
   }

   return $text;
}


