<?php


require(STYLESHEETPATH . "/functions/initialization.php");
require(STYLESHEETPATH . "/functions/admin.php"         );   
require(STYLESHEETPATH . "/functions/theme.php"         );
require(STYLESHEETPATH . "/functions/properties.php"    );


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
