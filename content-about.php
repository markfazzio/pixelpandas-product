<?php $dom = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>

<div class="row">
	<div class="col-md-8">
		<?php the_content(); ?>
	</div>
	<div class="col-md-4">
		<img class="pull-right" src="<?php echo $dom; ?>" />
	</div>
</div>