<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Bristol Big Youth Vote
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
  <ul class="acknowledgements">
    <li><img src="<?php bloginfo('template_directory'); ?>/img/bristol-city-council.png" alt="Bristol City Council"></li>
    <li><img src="<?php bloginfo('template_directory'); ?>/img/bristol-city-youth-council.png" alt="Bristol City Youth Council"></li>
    <li><img src="<?php bloginfo('template_directory'); ?>/img/bristol-youth-links.png" alt="Bristol Youth Links"></li>
    <li><img src="<?php bloginfo('template_directory'); ?>/img/knowle-west-media-centre.jpg" alt="Knowle West Media Centre"></li>
  </ul>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'bristolbigyouthvote' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'bristolbigyouthvote' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'bristolbigyouthvote' ), 'Bristol Big Youth Vote', '<a href="http://davidbiddle.co.uk" rel="designer" title="David Biddle - Bristol Web Developer">David Biddle</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
