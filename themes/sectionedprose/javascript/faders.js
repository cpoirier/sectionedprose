  
function sectionedProseInitFaders(fadeWorthy)
{
   $.each(fadeWorthy, function(index, value){
      $(value).fadeTo(1, 0.2);
      $(value).hover(
         function() {
            $(this).stop().fadeTo('fast', 1.0);
         },
         function() {
            $(this).stop().fadeTo('slow', 0.2);
         }
      );
   });
}


function sectionedProseInitDisqusFader(fadeWorthy)
{
   var comments = $("#comments");
   if( comments.length > 0 )
   {
      var disqusMinimized = false;
      var disqusMaximized = false;
      var disqusMinimizer = 0;
      var attemptsRemaining = 20;  

      disqusMinimizer = setInterval(
         function()
         {
            var disqusReply = $("#dsq-reply");
            if( disqusReply.length == 1 )
            {
               clearInterval(disqusMinimizer);
               if( !disqusMaximized ) 
               {
                  $("#dsq-reply ~ *").hide();
                  disqusMinimized = true;
               }
            }
            else
            {
              attemptsRemaining = attemptsRemaining - 1;
            }

            if( attemptsRemaining == 0 )
            {
              clearInterval(disqusMinimizer);
            }
         },
         500
      );

      comments.fadeTo(1, 0.2);
      comments.hover(
         function() 
         {
            $(this).stop().fadeTo('fast', 1.0);
            if( disqusMinimizer > 0 && !disqusMaximized )
            {
               $("#dsq-reply ~ *").show();
               disqusMaximized = true;

               //
               // Ensure any faders above us are disabled, for cosmetic reasons. 

               $.each(fadeWorthy, 
                  function(index, value)
                  {
                     var fader = $(value, $("section#content"));
                     if( fader.length > 0 )
                     {
                        fader.unbind('mouseenter mouseleave');
                        fader.fadeTo('fast', 1.0);
                     }
                  }
               );
            }
         }
      );
   }
}
