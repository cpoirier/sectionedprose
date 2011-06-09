// Based on http://usejquery.com/posts/1/highlight-your-source-code-with-jquery-and-chili

$(document).ready(
  function() 
  {
    var initialWidth = $('#content pre:first').width(); 

    $('pre').hover(
      function() 
      {
        var main = $('#main');
        var openSpace = Math.round(main.width() - initialWidth - main.position().left); 
        if( $(this).width() == initialWidth )
        { 
          $(this).width(initialWidth + openSpace);
        }
      }, 
      function() 
      {
        $(this).width(initialWidth);
      }
    );
  }
);
