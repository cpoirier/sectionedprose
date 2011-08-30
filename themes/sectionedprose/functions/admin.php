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

add_filter( 'kc_plugin_settings', 'sectionedprose_theme_properties' );
function sectionedprose_theme_properties( $settings ) 
{
   $fields = array(
      'home_template' => array(
         'id'      => 'home_template',
         'title'   => 'Home Page Template',
         'type'    => 'select',
         'options' => array(
            'blog'     => 'Blog Format',
            'excerpts' => 'Blog Format, excerpts only',
         )
      ),
      'font_selection' => array(
         'id'      => 'font_selection',
         'title'   => 'Font Selection',
         'type'    => 'select',
         'options' => array(
            'serif'      => 'Seriffed body, sans-serif headings (default)',
            'sans'       => 'Sans serif body, seriffed headings',
            'all_serif'  => 'Seriffed throughout',
            'all_sans'   => 'Sans serif throughout',
         )
      ),
      'article_metadata_format' => array(
         'id'      => 'article_metadata_format',
         'title'   => 'Article Metadata Format',
         'desc'    => "A format string for metadata, if you don't like the default.  Example: \"by {author}, {posted}&lt;br/&gt;{tags tagged: %s}\"",
         'type'    => 'input'
      )
   );

   $settings[] = array(
      'prefix'        => 'sectionedprose',
      'menu_location' => 'themes.php',
      'menu_title'    => 'Theme Settings',
      'page_title'    => 'Theme Settings',
      'options'       => array(
         'sectionedprose_properties' => array(
            'id'     => 'sectionedprose_properties',
            'fields' => sectionedprose_add_global_properties(sectionedprose_add_layout_properties($fields))
         )
      )
   );
   
   return $settings;
}



add_filter( 'kc_term_settings', 'sectionedprose_category_properties' );
function sectionedprose_category_properties( $groups ) {
   $fields = array(
      'section_type' => array(
         'id'      => 'section_type',
         'title'   => "Section Type",
         'type'    => 'select',
         'options' => array(
            'container' => "article container (default)",
            'master'    => "master section (gets its own branding)",
            'sub'       => "subsection (alters the context section's branding)"
         )
      ),               
      'section_subtitle' => array(
         'id'      => 'section_subtitle',
         'title'   => "Section Subtitle",
         'desc'    => "If this category is a section, you can override the page subtitle with Markdown.  If this category is a subsection, you can only extend the page subtitle.  Default behaviour is to show the context subtitle.",
         'type'    => 'input' 
      ),
      'index_behaviour' => array(
         'id'      => 'index_behaviour',
         'title'   => 'Index Behaviour',
         'type'    => 'select',
         'options' => array(
            'category' => 'excerpts; latest first',
            'blog'     => 'full articles; latest first',
            'cover'    => 'book-like cover page',
            'latest'   => 'redirect to latest article',
            'first'    => 'redirect to first article'
         )
      ),
      'cover_text' => array(
         'id'      => 'cover_text',
         'title'   => "Cover Text",
         'desc'    => "Freeform Markdown for use on the section cover (if used).",
         'type'    => 'textarea' 
      ),
      'cover_indices' => array(
         'id'      => 'cover_indices',
         'title'   => "Show Articles on Cover",
         'type'    => 'select',
         'options' => array(
            'all'      => 'contents and recent (default)',
            'contents' => 'contents only',
            'recent'   => 'recent only',
            'disabled' => 'none'
         )
      ),
      'article_section' => array(
         'id'      => 'article_section',
         'title'   => "Article Section",
         'desc'    => "If the articles live in a subsection, this is the slug",
         'type'    => 'input',  
      ),
      'navigation_links' => array(
         'id'      => 'navigation_links',
         'title'   => "Next/Previous Links",
         'type'    => 'select',
         'options' => array(
            'enabled'  => 'enabled (default)',
            'disabled' => 'disabled'
         )
      ),
      'index_title'  => array(
         'id'      => 'index_title',
         'title'   => "Index Title",
         'desc'    => "If a section index is displayed, this is the label",
         'type'    => 'input',  
      ),
      'index_limit' => array(
         'id'      => 'index_limit',
         'title'   => "Index Limit",
         'desc'    => "The maximum number of articles to show in the article index.  Default is 30",
         'type'    => 'input',  
      ),
   );
   
   $groups[] = array(
      'category' => array(
         'sectionedprose_properties' => array(
            'id'       => 'sectionedprose_properties',
            'title'    => 'Theme Control',
            'priority' => 'high',
            'role'     => array('administrator', 'editor'),
            'fields'   => sectionedprose_add_global_properties(sectionedprose_add_layout_properties($fields))
         )
      )
   );

   return $groups;
}

add_filter( 'kc_post_settings', 'sectionedprose_post_properties' );
function sectionedprose_post_properties( $groups ) {
   $groups[] = array(
      'post' => array(
         'sectionedprose_properties' => array(
            'id'       => 'sectionedprose_properties',
            'title'    => 'Theme Control',
            'priority' => 'high',
            'role'     => array('administrator', 'editor'),
            'fields'   => sectionedprose_add_global_properties(array(), false)
         )
      )
   );

   return $groups;
}






function sectionedprose_widget_placements()
{
   static $widget_placements = array(
      'disabled' => 'Disabled',
      'sidebar1' => 'Sidebar, after global top',
      'sidebar2' => 'Sidebar, middle',
      'sidebar3' => 'Sidebar, before global bottom',
      'footer1'  => 'Footer, after global left',
      'footer2'  => 'Footer, middle',
      'footer3'  => 'Footer, before global right'
   );
   
   return $widget_placements;
}

function sectionedprose_add_layout_properties( $context )
{
   $context['article_format'] = array(
      'id'      => 'article_format',
      'title'   => 'Article Format',
      'type'    => 'select',
      'options' => array(
         'technical' => 'Technical (spacing between paragraphs, no indent)',
         'literary'  => 'Literary (indented, flowing paragraphs)',
      )
   );
   
   $context['news_sections'] = array(
      'id'      => 'news_sections',
      'title'   => 'News Sections',
      'desc'    => 'A comma-separated list of subsections that contain news that should appear in the Section News widget',
      'type'    => 'input'
   );
   
   $context['section_navigation_placement'] = array(
      'id'      => 'section_navigation_placement',
      'title'   => 'Section Navigation Placement',
      'desc'    => 'Determines the placement of the section navigation widgets on article pages',
      'type'    => 'select',
      'options' => sectionedprose_widget_placements(),
   );
   
   $context['article_copyright_placement'] = array(
      'id'      => 'article_copyright_placement',
      'title'   => 'Article Copyright Placement',
      'desc'    => 'Determines the placement of the article-specific copyright notice on article pages',
      'type'    => 'select',
      'options' => sectionedprose_widget_placements(),
   );
   
   $context['section_news_placement'] = array(
      'id'      => 'section_news_placement',
      'title'   => 'News Placement',
      'desc'    => 'Determines the placement of the section news widgets on article pages',
      'type'    => 'select',
      'options' => sectionedprose_widget_placements(),
   );
   
   $context['article_metadata_placement'] = array(
      'id'      => 'article_metadata_placement',
      'title'   => 'Article Metadata Placement',
      'desc'    => 'Determines the placement of things like an articles post date and author',
      'type'    => 'select',
      'options' => array(
         'header'   => 'Beneath article title (default)',
         'footer'   => 'In the article footer',
         'sidebar1' => 'Sidebar, after global top',
         'sidebar2' => 'Sidebar, middle',
         'sidebar3' => 'Sidebar, before global bottom',
         'disabled' => 'Nowhere',
      )
   );
   
   return $context;   
}


function sectionedprose_add_global_properties( $context, $include_header_image = true )
{
   $context['copyright'] = array(
      'id'    => 'copyright',
      'title' => 'Site Copyright',
      'desc'  => 'Everything after the copyright symbol.',
      'type'  => 'input'
   );
   
   $context['copyright_message'] = array(
      'id'    => 'copyright_message',
      'title' => 'Copyright Message',
      'desc'  => 'Optional extended message to display with the copyright notice.',
      'type'  => 'input'
   );
   
   if( true && $include_header_image )
   {
      $context['header_image'] = array(
         'id'    => 'header_image',
         'title' => 'Header Image',
         'desc'  => 'Media Library ID of a custom header image (should be 960 pixels wide).',
         'type'  => 'input'
      );
   }

   $context['header_border'] = array(
      'id'      => 'header_border',
      'title'   => 'Header Border',
      'desc'    => 'Determines the width of the border on the top of the header image',
      'type'    => 'select',
      'options' => array(
         'thick'    => "thick (default)",
         'thin'     => "thin",
         'none'     => "none",
      )
   );
   
   $context['background_colour'] = array(
      'id'    => 'background_colour',
      'title' => 'Background Colour',
      'desc'  => 'Background colour for content area (defaults to #FFF).',
      'type'  => 'input'
   );
   
   $context['frame_colour'] = array(
      'id'    => 'frame_colour',
      'title' => 'Frame Colour',
      'desc'  => 'Colour for everything outside the body (defaults to #FFF).',
      'type'  => 'input'
   );
   
   return $context;
}
