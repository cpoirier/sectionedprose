<ul id="navigation" class="widget-stack body">
   <?php if( !dynamic_sidebar('navigation') ) { ?>
      <li>
         <section id="search" class="widget widget_search">
   			<?php get_search_form(); ?>
   		</section>
   	</li>
   	
      <li class="subscribe">
         <section id="subscribe" class="widget">
            <header><h1>Subscribe</h1></header>
            <ul class="feed">
               <li><a href="<?php bloginfo('rss2_url'); ?>">Posts RSS</a></li>
               <li><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments RSS</a></li>
            </ul>
         </section>
      </li>

		<li>
		   <section id="archives" class="widget">
				<header><h1>Archives</h1></header>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</section>
		</li>

		<li>
		   <section id="meta" class="widget">
				<header><h1>Meta</h1></header>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</section>
		</li>
   <?php } ?>
</ul>

