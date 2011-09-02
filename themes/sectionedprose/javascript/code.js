// Based on http://usejquery.com/posts/1/highlight-your-source-code-with-jquery-and-chili

$(document).ready(
  function() 
  {
    var examplar        = $('#content pre:first');
    var initialWidth    = examplar.width(); 
    var initialPosition = examplar.css('position');
    var initialZIndex   = examplar.css('z-index');

    $('pre').hover(
      function() 
      {
        var body   = $('#body');
        var margin = $(this).position().left - body.position().left;
        var space  = Math.round(body.width() - initialWidth - (margin * 2));
        if( $(this).width() == initialWidth )
        { 
          $(this).width(initialWidth + space);
          $(this).css('position', 'relative');
          $(this).css('z-index', 100);
        }
      }, 
      function() 
      {
        $(this).css('z-index' , initialZIndex  );
        $(this).css('position', initialPosition);
        $(this).width(initialWidth);
      }
    );
  }
);
