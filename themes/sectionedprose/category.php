<?php
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
