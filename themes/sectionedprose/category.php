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

   $section_id      = get_section_id();
   $index_behaviour = get_property("index_behaviour", "category", $section_id, "section", 1 );
   
   switch( $index_behaviour )
   {
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
   
   require(STYLESHEETPATH . "/index.php");      
