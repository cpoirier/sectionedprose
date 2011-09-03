// Based on http://usejquery.com/posts/1/highlight-your-source-code-with-jquery-and-chili

$(document).ready(
  function() 
  {
    var examplarPreCode   = $('#content pre code').first();
    var examplarPre       = examplarPreCode.parent();
    var initialWidth      = examplarPre.width(); 
    var initialPosition   = examplarPreCode.css('position');
    var initialZIndex     = examplarPreCode.css('z-index');
    var initialLineHeight = examplarPreCode.css('line-height');
    var initialFontSize   = parseInt(examplarPreCode.css('font-size'));

    $('pre code').hover(
      function() 
      {
        var body   = $('#body');
        var pre    = $(this).parent();
        var margin = $(this).position().left - body.position().left;
        var space  = Math.round(body.width() - initialWidth - (margin * 2));
        if( pre.width() == initialWidth )
        { 
          $(this).height($(this).height());
          $(this).css('position', 'relative');
          $(this).css('z-index', 100);
          $(this).animate({width: initialWidth + space, lineHeight: initialFontSize * 1.5}, 'fast');
        }
      }, 
      function() 
      {
        $(this).animate({width: initialWidth, lineHeight: initialLineHeight}, 'fast', 
          function() 
          {
            $(this).css('z-index' , initialZIndex  );
            $(this).css('position', initialPosition);
            $(this).height('auto');
          }
        );
      }
    );
  }
);
