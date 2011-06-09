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
?><ul id="navigation" class="widget-stack body">
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

