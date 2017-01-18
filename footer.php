<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
?>

		</div><!-- .container -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">

		<div class="row">
			<div class="site-footer-inner col-sm-12">

				<p class="text-center">
				A project by Dominick Bizzarri&nbsp;&nbsp;&nbsp;<a href="mailto:dom@coostr.com"><span class="glyphicon glyphicon-envelope"></span></a><br />
                &copy; <?php echo date('Y'); ?> Coostr, LLC. Patent Pending.
            	</p>
            	<p class="text-center">
	            	<small>Website by <a href="http://pixelpandas.com" target="_blank">Pixel Pandas</a></small>
            	</p>

			</div>
		</div>

		</div><!-- .container -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
