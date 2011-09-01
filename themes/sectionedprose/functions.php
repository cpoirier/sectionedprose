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



require(STYLESHEETPATH . "/functions/initialization.php");
require(STYLESHEETPATH . "/functions/admin.php"         );   
require(STYLESHEETPATH . "/functions/theme.php"         );
require(STYLESHEETPATH . "/functions/properties.php"    );
require(STYLESHEETPATH . "/functions/github.php"        );


function markup( $text, $inline = false )
{
   if( function_exists("Markdown") )
   {
      $text = str_replace("</p>", "", str_replace("<p>", "", $text));
      $text = Markdown( $inline ? strip_tags($text) : $text );

      if( $inline )
      {
         $text = str_replace("</p>", "<br />", str_replace("<p>", "", $text) );
         $text = preg_replace( '/(<br ?\/>)*/', '', $text );
      }

      return $text;
   }
   else
   {
      return strip_tags($text);
   }
}

add_filter('widget_links_args', 'sectionedprose_order_widget_links');
function sectionedprose_order_widget_links($array)
{
   $array["orderby"] = "rating,name";
   $array["order"  ] = "ASC";

   return $array;
}

add_filter('widget_text', 'markdown');
add_filter('widget_title', 'sectionedprose_markdown_widget_title');
function sectionedprose_markdown_widget_title( $title, &$instance, &$id_base )
{
   return markdown($title);
}

