<?php if( $copyright = get_property("copyright") ) { ?>
<ul id="article-copyright-widgets" class="widget-stack body">
   <li class="subscribe">
      <section id="article-copyright" class="widget">
         <header><h1><i><?php echo esc_attr(get_property_context_title());?></i> Copyright © <?php echo $copyright ?></h1></header>
         <?php if( $message = get_property("copyright_message", "") ) { echo markup($message); } ?>
      </section>
   </li>
</ul>
<?php } ?>
