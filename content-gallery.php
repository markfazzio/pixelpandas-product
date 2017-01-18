<?php 
	$images = get_field('gallery');
?>

<div class="row">
	<div class="col-md-12">
		<?php the_content(); ?>
	</div>
</div>

<?php if( $images ): ?>
    <div class="gallery row">
        <?php foreach( $images as $image ): ?>
            <div class="col-md-3 col-sm-4 col-xs-6 image">
	            <div class="img-wrapper">
	                <a href="<?php echo $image['url']; ?>" data-lightbox="coostr" data-title="<?php echo $image['alt']; ?>">
	                     <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" />
	                </a>
	                <p><?php echo $image['caption']; ?></p>
	            </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>There are no images in the gallery.</p>
<?php endif; ?>