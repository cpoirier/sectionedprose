<?php
/*
Plugin Name: Clean Categories
Plugin URI: http://courage-my-friend.org/projects/clean-categories
Description: Removes '/category' from your category permalinks and ensures category names can be reused in separate hierarchies, by mapping between WordPress's globally-unique category names and simple, hierarchical URLs.  Based on <a href="http://wordpresssupplies.com/wordpress-plugins/no-category-base/">WP No Category Base</a>, by Saurabh Gupta. 
Version: 1.0
Author: Chris Poirier
Author URI: http://courage-my-friend.org/
*/

/*  Copyright 2008  Saurabh Gupta  (email : saurabh0@gmail.com)
    Copyright 2011  Chris Poirier  (email : chris@courage-my-friend.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//
// Registers for category change events, as we'll need to update the rewrite rules.

register_activation_hook(__FILE__,'clean_categories_refresh_rules');
add_action('created_category','clean_categories_refresh_rules');
add_action('edited_category','clean_categories_refresh_rules');
add_action('delete_category','clean_categories_refresh_rules');

function clean_categories_refresh_rules() 
{
   global $wp_rewrite;
   $wp_rewrite->flush_rules();
}


//
// Registers a deactivation hook, to ensure we put the rewrite rules back the way they were.

register_deactivation_hook(__FILE__,'clean_categories_deactivate');

function clean_categories_deactivate() 
{
   remove_filter('category_rewrite_rules', 'clean_categories_rewrite_rules');
   clean_categories_refresh_rules();
}


//
// Removes the category base from the permalink structures, per Saurabh's code.

add_action('init', 'clean_categories_permastruct');
function clean_categories_permastruct() 
{
   global $wp_rewrite;
   $wp_rewrite->extra_permastructs['category'][0] = '%category%';
}

//
// Add our custom category rules.  This routine is significantly extended from Saurabh's
// version, in that we eliminate repetition from within subordinate slugs.  Here are some
// example mappings, from internal to external:
//   trains                               => trains
//   trains/trains+news                   => trains/news
//   trains/trains+news/trains+news+child => trains/news/child
//   planes                               => planes
//   planes/planes+news                   => planes/news
//   planes/planes+news/planes+news+child => plains/news/child
//   x-y                                  => x-y
//   x-y/x-y+news                         => x-y/news
//   x-y/x-y+news/x-y+news+child          => x-y/news/child

add_filter('category_rewrite_rules', 'clean_categories_rewrite_rules');
function clean_categories_rewrite_rules($category_rewrite) 
{
   //var_dump($category_rewrite); // For Debugging
   
   $category_rewrite = array();
   $categories = get_categories(array('hide_empty'=>false));
   foreach( $categories as $category ) 
   {
      $category_nicename = $category->slug;
      if ( $category->parent == $category->cat_ID ) 
      {
         $category->parent = 0;  // Just a safety check.  I assume Saurabh put it in for a reason....
      }
      elseif( $category->parent != 0 )
      {
         $slu
         $parent_path = get_category_parents($category->parent, false, '/', true);
         $slug_prefix = str_replace( "/", "-", $parent_path );
         if( substr($category_nicename, 0, strlen($slug_prefix) + 1 == $slug_prefix . "-" )
         {
            $category_nicename = $parent_path . substr($category_nicename, strlen($slug_prefix) + 1);
         }
         else
         {
            $category_nicename =  . $category_nicename;
            
         }
         
      }


      $category_rewrite['('.$category_nicename.')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
      $category_rewrite['('.$category_nicename.')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
      $category_rewrite['('.$category_nicename.')/?$'] = 'index.php?category_name=$matches[1]';
   }
   // Redirect support from Old Category Base
   global $wp_rewrite;
   $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
   $old_category_base = trim($old_category_base, '/');
   $category_rewrite[$old_category_base.'/(.*)$'] = 'index.php?category_redirect=$matches[1]';
   
   //var_dump($category_rewrite); // For Debugging
   return $category_rewrite;
}

// Add 'category_redirect' query variable
add_filter('query_vars', 'clean_categories_query_vars');
function clean_categories_query_vars($public_query_vars) {
   $public_query_vars[] = 'category_redirect';
   return $public_query_vars;
}
// Redirect if 'category_redirect' is set
add_filter('request', 'clean_categories_request');
function clean_categories_request($query_vars) {
   //print_r($query_vars); // For Debugging
   if(isset($query_vars['category_redirect'])) {
      $catlink = trailingslashit(get_option( 'home' )) . user_trailingslashit( $query_vars['category_redirect'], 'category' );
      status_header(301);
      header("Location: $catlink");
      exit();
   }
   return $query_vars;
}
?>