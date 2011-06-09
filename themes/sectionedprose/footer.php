<div class="clear"></div>
</div><!-- #main -->

<footer id="footer" class="container">
   <?php get_sidebar('footer'); ?>
   <p>
      <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
      <? if( $site_copyright = get_property("copyright", "", "theme") ) { printf("© %s", $site_copyright); } ?>
      <?php sectionedprose_header_description(" &nbsp;&middot;&nbsp; Header image ")?>
      
      <br/>

      Powered by <a href="http://wordpress.org/">WordPress</a>
      &nbsp;&middot;&nbsp;
      Sectioned Prose Theme
      &nbsp;&middot;&nbsp;
      <a href="/wp-admin/">Site admin</a>
      &nbsp;&middot;&nbsp;
      <?php wp_loginout(); ?>
      &nbsp;&middot;&nbsp;
      <a href="http://validator.w3.org/check/referer" title="This page validates as HTML 5.0">Valid <abbr title="HyperText Markup Language, version 5">HTML5</abbr></a>
   </p>
</footer>

<script>// <![CDATA[
   $(document).ready(function()
      {
         sectionedProseInitFaders(fadeWorthy);
         sectionedProseInitDisqusFader(fadeWorthy);
      }
   );
//]]></script>

<div style="clear: both"></div>
<?php wp_footer(); ?>
</body>
</html>
