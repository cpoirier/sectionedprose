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
// Outputs a complete title for the page.

function sectionedprose_title()
{
 	wp_title( '|', true, 'right' );
	bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if( $site_description && (is_home() || is_front_page()) )
	{
		echo " | $site_description";
	}

   global $page, $paged;
	if( $paged >= 2 || $page >= 2 )
	{
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
	}
}


//
// Outputs the header image for the page.

function sectionedprose_header_image()
{
   global $post, $header_id;

   if( is_singular() && current_theme_supports('post-thumbnails') && has_post_thumbnail($post->ID) )
   {
      $header_id = get_post_thumbnail_id($post->ID);
   }
   elseif( is_singular() )
   {
      $header_id = 0 + get_property("header_image", 0);
   }
   else
   {
      $header_id = 0 + get_property("header_image", 0, is_category() ? "section" : "theme");
   }
   
   if( $header_id && ($image_data = wp_get_attachment_image_src($header_id, 'post-thumbnail')) )
   {
      $class = get_property("header_border", "thick");
      ?><img class="<?php echo esc_attr($class);?>" src="<?php echo esc_url($image_data[0])?>" width="<?php echo $image_data[1]?>" height="<?php echo $image_data[2]?>" alt="" /><?php
      return;  // <<<<<<<<<<<<<<<< FLOW CONTROL <<<<<<<<<<<<<<<<
   }
}


function sectionedprose_header_description( $prefix = "", $suffix = "", $inline = true )
{
   global $header_id;
   if( $header_id )
   {
      $data = new WP_Query(array("p" => $header_id, "post_type" => "attachment", "posts_per_page" => 1));
      if( $data->have_posts() )
      {
         if( ($description = $data->posts[0]->post_content) && substr($description, 0, 7) != "http://"  )
         {
            echo $prefix;
            echo markup( $description, $inline );
            echo $suffix;
         }
      }
   }
}



//
// Outputs a navigation menu, properly formatted.  The default code leaves somethings 
// to be desired.

function sectionedprose_nav_menu( $location, $use_nav_tag = true )
{
   $menu = wp_nav_menu(array('container' => false, 'theme_location' => $location, 'echo' => false));

   echo $use_nav_tag ? "<nav>" : "";
   echo preg_replace( "/<\/?div[^>]*?>/", "", $menu );
   echo $use_nav_tag ? "</nav>" : "";
}


//
// Outputs any configurable styles.

function sectionedprose_styles()
{
   $frame_colour      = get_colour_property("frame_colour"     , null);
   $background_colour = get_colour_property("background_colour", null);
   $font_selection    = get_property("font_selection", "serif");
   $font_stylesheet   = "/styling/fonts/" . $font_selection . ".css";
   
   if( $frame_colour || $background_colour || $font_selection != "serif" )
   {
      echo "<style>\n";
      if( file_exists(TEMPLATEPATH . $font_stylesheet) )
      {
         printf( "@import url(%s);\n", get_bloginfo("template_directory") . $font_stylesheet );
         // readfile( TEMPLATEPATH . $font_stylesheet );
      }
      
      if( $frame_colour      ) { printf("html { background: %s; }\n", $frame_colour     ); }
      if( $background_colour ) { printf("body { background: %s; }\n", $background_colour); }
      echo "</style>\n";
   }
}


//
//

function sectionedprose_section_title( $section_id = 0 )
{
   $titled = false;
      
   if( !is_home() && !is_search() && ($section_id = get_section_id($section_id)) )
   {
      $category = get_category($section_id);
      switch( get_property("section_type", "container", "section", $section_id) )
      {
         case "container":
            sectionedprose_section_title( $category->category_parent > 0 ? $category->category_parent : -1 );
            $titled = true;
            break;
         case "master":
            printf("<a href=\"%s\" title=\"%s home page\">%s</a>", esc_url(get_category_link($section_id)), esc_attr($category->name), esc_attr($category->name));
            $titled = true;
            break;
         case "sub":
            sectionedprose_section_title( $category->category_parent > 0 ? $category->category_parent : -1 );
            printf(": <a href=\"%s\" title=\"%s home page\">%s</a>", esc_url(get_category_link($section_id)), esc_attr($category->name), esc_attr($category->name));
            $titled = true;
            break;
      }
   }
   
   if( !$titled )
   {
      ?><a href="<?php echo home_url("/")?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'))?>" rel="home"><?php bloginfo('name')?></a><?php
   }
}

function sectionedprose_section_subtitle( $section_id = 0, $prefix = "" )
{
   $subtitled = false;
   
   if( !is_home() && !is_search() && ($section_id = get_section_id($section_id)) )
   {
      $category  = get_category($section_id);
      $parent_id = $category->category_parent > 0 ? $category->category_parent : -1;
      switch( get_property("section_type", "container", "section", $section_id) )
      {
         case "container":
            sectionedprose_section_subtitle( $parent_id );
            $subtitled = true;
            break;
         case "master":
            if( $subtitle = get_property("section_subtitle", "", "section", $section_id) )
            {
               echo markup( strip_tags($subtitle), true );
            }
            else
            {
               sectionedprose_section_title( $parent_id ); echo " &gt; ";
               sectionedprose_section_subtitle( $parent_id, "&#8212;" );
            }
            $subtitled = true;
            break;
         case "sub":
            if( $subtitle = get_property("section_subtitle", "", "section", $section_id, 1) )
            {
               echo markup(get_bloginfo("description"), true); echo " ";
            }
            sectionedprose_section_subtitle( $parent_id, "&#8212;" );
            $subtitled = true;
            break;
      }
   }
   
   if( !$subtitled )
   {
      echo markup(get_bloginfo("description"), true);
   }
}



function sectionedprose_next_page_link( $link = '<h3 class="pager">%link</h3>', $title = 'next page &raquo;' )
{
   $links = wp_link_pages( "echo=0&before=&after=&link_before=&link_after=&next_or_number=next&previouspagelink=PREVIOUS&nextpagelink=NEXT" );
   if( !$links || strpos($links, ">NEXT<") === false )
   {
      next_post_link($link, $title, !!get_query_var("cat") || !!get_query_var("category_name"));
   }
   else
   {
      $individuals = explode( "/a><a", $links );
      $individual  = (strpos($individuals[0], ">NEXT<") === false) ? $individuals[1] : $individuals[0];
      if( preg_match('/href=["\']([^"\']+)["\']/', $individual, $matches) )
      {
         $href = $matches[1];
         echo str_replace( "%link", str_replace("%title", $title, str_replace("%href", $href, '<a href="%href">%title</a>')), $link );
      }
   }
}



function sectionedprose_previous_page_link( $link = '<h3 class="pager">%link</h3>', $title = '&laquo; previous page' )
{
   $links = wp_link_pages( "echo=0&before=&after=&link_before=&link_after=&next_or_number=next&previouspagelink=PREVIOUS&nextpagelink=NEXT" );
   if( !$links || strpos($links, ">PREVIOUS<") === false )
   {
      previous_post_link($link, $title, !!get_query_var("cat") || !!get_query_var("category_name"));
   }
   else
   {
      $individuals = explode( "/a><a", $links );
      $individual  = $individuals[0];
      if( preg_match('/href=["\']([^"\']+)["\']/', $individual, $matches) )
      {
         $href = $matches[1];
         echo str_replace( "%link", str_replace("%title", $title, str_replace("%href", $href, '<a href="%href">%title</a>')), $link );
      }
   }
}


//
// Given a format string for article metadata and the formatted pieces of metadata, builds the string.

function sectionedprose_format_article_metadata( $format, $posted_meta, $author_meta, $tags_meta )
{
   $inputs  = preg_split("/((?:\\{[^\\}]+\\})|(?:\\[[^\\]]+\\]))/", $format, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
   $outputs = array();
   foreach( $inputs as $input )
   {
      $outputs[] = sectionedprose_process_article_metadata_specifier($input, $posted_meta, $author_meta, $tags_meta);
   }
   
   $output = implode("", $outputs);
   return substr($output, 0, 1) != "<" ? "<p>" . $output . "</p>" : $output;
}


function sectionedprose_process_article_metadata_specifier( $specifier, $posted_meta, $author_meta, $tags_meta )
{
   switch( $specifier )
   {
      case "{posted}": return $posted_meta;
      case "{author}": return $author_meta;
      case "{tags}"  : return $tags_meta;
   }
   
   if( substr($specifier, 0, 1) == "[" && substr($specifier, -1, 1) == "]" )
   {
      $conditional = substr($specifier, 1, strlen($specifier) - 2);
      $inputs  = preg_split("/(\\{[^\\}]+\\})/", $conditional, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
      $outputs = array();
      
      foreach( $inputs as $input )
      {
         if( substr($input, 0, 1) == "{" && substr($input, -1, 1) == "}" )
         {
            $output = sectionedprose_process_article_metadata_specifier($input, $posted_meta, $author_meta, $tags_meta );
            if( strlen(trim($output)) > 0 && $output != $input )
            {
               $outputs[] = $output;
            }
            else
            {
               return "";
            }
         }
         else
         {
            $outputs[] = $input;
         }
      }
      
      return implode("", $outputs);
   }
   else
   {
      return $specifier;
   }
}


function sectionedprose_simplify_article_title( $title = null )
{
   $m = $complex = false;
   if( !$title )
   {
      $title = get_the_title();
   }
   
   if( $title )
   {
      $complex = preg_match("/^(?:chapter|part) (\d+)$/i"      , $title, $m) ||
                 preg_match("/(?:chapter|part) \d+:\s*(.*)$/i" , $title, $m) ||
                 preg_match("/[:,] (?:chapter|part)\s*(\d+)$/i", $title, $m);
   }
 
   return $complex ? $m[1] : $title; 
}
