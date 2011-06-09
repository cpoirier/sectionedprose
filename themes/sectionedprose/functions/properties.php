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
// Retrieves a named property from the post or local section.

function get_property( $name, $default = null, $finest_grain = "post", $section_id = 0, $attempts = 1000000 )
{
   global $post, $property_found_at;
   $property_found_at = 0;
   $rewind = false;
   if( !$post && is_singular() && ($rewind = !!have_posts()) )
   {
      the_post();
   }

   if( $finest_grain == "post" && is_singular() )
   {
      $attempts -= 1;
      if( ($value = get_post_meta($post->ID, $name, true)) || ($value = get_post_meta($post->ID, ucwords($name), true)) || ($value = get_post_meta($post->ID, "_$name", true)) )
      {
         $property_found_at = $post;
         if( $rewind ) { rewind_posts(); }
         return $value;
      }
   }

   if( $attempts > 0 && $finest_grain != "theme" && ($section_id = get_section_id($section_id)) )
   {
      while( $attempts > 0 && $section_id )
      {
         if( $value = get_metadata('term', $section_id, $name, true) )
         {
            $property_found_at = $section_id;
            if( $rewind ) { rewind_posts(); }
            return $value;
         }

         $section_id = get_parent_section_id($section_id);
         $attempts -= 1;
      }
   }
   
   if( $attempts > 0 && function_exists('kc_get_option') && ($value = kc_get_option('sectionedprose', 'sectionedprose_properties', $name)) )
   {
      $attempts -= 1;
      
      $property_found_at = -1;
      if( $rewind ) { rewind_posts(); }
      return $value;
   }
  
   if( $rewind ) { rewind_posts(); }
   return $default;
}


//
// Returns the link to the post or category from where the last property was found.

function get_property_context_link()
{
   global $property_found_at;

   $url = null;
   if( is_object($property_found_at) )
   {
      $url = get_post_permalink( $property_found_at->ID );
   }
   elseif( $property_found_at == -1 )
   {
      $url = get_bloginfo('site_url');
   }
   elseif( $property_found_at )
   {
      $url = get_category_link($property_found_at);
   }
   
   if( $url )
   {
      $title = get_property_context_title();
      
      ob_start();
      ?><a href="<?php echo esc_attr($url) ?>" rel="bookmark" title="<?php echo esc_attr($title); ?>"><?php echo esc_attr($title)?></a><?php
      return ob_get_clean();
   }
   
   return null;
}


//
// Returns the link to the post or category from where the last property was found.

function get_property_context_title()
{
   global $property_found_at;
   if( is_object($property_found_at) )
   {
      return get_the_title( $property_found_at->ID );
   }
   elseif( $property_found_at == -1 )
   {
      return get_bloginfo('name');
   }
   elseif( $property_found_at )
   {
      return get_category($property_found_at)->cat_name;
   }
   
   return null;
}



//
// Figures out which section we are in.  Returns 0 if sections aren't supported.
// If you pass a number, it won't be overridden unless sections aren't supported.

function get_section_id( $section_id = 0 )
{
   if( function_exists('get_metadata') && $section_id >= 0 )
   {
      if( $section_id == 0 )
      {
         if( is_page() )
         {
            global $post;
            if( $post->post_name && $post->post_parent == 0 )
            {
               if( $obj = get_category_by_slug($post->post_name) )
               {
                  $section_id = $obj->cat_ID;
               }
            }
         }
         elseif( is_category() )
         {
            if( $section_id <= 1 )
            {
               $category = get_category(get_query_var('cat'));
               $section_id = 0 + $category->cat_ID;
            }
         }
         else
         {
            foreach( (get_the_category()) as $category ) 
            {
               if( $section_id <= 1 )
               {
                  $section_id = $category->cat_ID;
               }
            }
         }
      }
   }
   else
   {
      $section_id = 0;
   }

   return $section_id;
}


//
// Given a section id, returns the parent section id.

function get_parent_section_id( $section_id )
{
   $parent_id = 0;
   if( $section_id > 0 )
   {
      if( $obj = get_category($section_id) )
      {
         $parent_id = $obj->category_parent;
      }
   }
   
   return $parent_id;
} 


//
// Returns ID of the nearest master section.

function get_master_section_id( $section_id = 0 )
{
   $section_id = get_section_id($section_id);
   while( $section_id && get_property("section_type", "container", "section", $section_id) != "master" )
   {
      $section_id = get_parent_section_id($section_id);
   } 
   
   return $section_id;
}


//
// Given a section id and a child name, returns the child section id.

function get_child_section_id( $section_id, $slug )
{
   //
   // Unfortunately, WordPress has really fucked us.  Category slugs are now globally-unique,
   // so there is no real hierarchy any more.  :-(  Time to get off the WordPress train, methinks.
      
   if( $term = get_term_by('slug', $slug, 'category', OBJECT) )
   {
      return $term->term_id;
   }
   
   return 0;
}



//
// Gets a full URL for an url property.

function get_url_property( $name, $default = null, $finest_grain = "post", $section_id = 0 )
{
  $url = $default;
  if( $value = get_property($name, $default, $finest_grain, $section_id) )
  {
     if( 0 === strpos($value, "http://") )
     {
        $url = $value;
     }
     elseif( 0 === strpos($value, "/") )
     {
        $url = get_bloginfo('url') . $value;
     }
  }

  return $url;
}


//
// Gets a CSS colour property.

function get_colour_property( $name, $default = null, $finest_grain = "post", $section_id = 0 )
{
   $colour = $default;
   if( $value = get_property($name, $default, $finest_grain, $section_id) )
   {
      if( preg_match('/^#[a-fA-F0-9]+$/', $value) && strlen($value) == 4 || strlen($value) == 7 )
      {
         $colour = $value;
      }
   }
   
   return $colour;
}
