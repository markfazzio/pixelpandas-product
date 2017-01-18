<?php
	
	$args = array(
	    'post_type' => 'article',
	    'posts_per_page' => -1, // all
	    'orderby' => 'date',
	    'order' => 'DESC'
	);
	$articles = new WP_Query($args);
	
?>

<?php if (have_rows('turtle_color')): ?>

	<div class="row clearfix coostr-color-selector">
		<div class="col-md-6">
			<?php the_content(); ?>
		</div>
		<div class="col-md-6">
			<div class="turtle-selector row clearfix">
				<div class="col-md-12">
					<?php $count = 0; while(have_rows('turtle_color')) : the_row(); ?>
						<button class="color<?php echo $count == 0 ? ' active' : ''; ?><?php echo ($count == 4) ? ' break' : ''; ?>" data-color="#<?php the_sub_field('hex'); ?>" style="background-color:#<?php the_sub_field('hex'); ?>"></button>
						<?php //if($count == 3) : ?>
						<!--<div class="colors-separator"></div>-->
						<?php //endif; ?>
					<?php $count++; endwhile; ?>
				</div>
			</div>
			<?php $count = 0; while(have_rows('turtle_color')) : the_row(); ?>
				<div class="turtle-image row clearfix<?php echo $count == 0 ? ' active' : ''; ?>" data-color="#<?php the_sub_field('hex'); ?>">
					<div class="col-md-12 text-center pop-wrapper">
						
						<div class="turtle unpopped">
							<img class="turtle unpopped" src="<?php the_sub_field('turtle_unpopped'); ?>" />
							<div class="pop-indicator pop-me">
								<h4>
									<span class="popicon popicon-target"></span>
									Pop Me
								</h4>
							</div>
						</div>
						<div class="turtle popped active">
							<img class="turtle popped active" src="<?php the_sub_field('turtle_popped'); ?>" />
							<div class="pop-indicator unpop-me">
								<h4>
									<span class="popicon popicon-cancel-circle"></span>
									Flatten Me
								</h4>
							</div>
						</div>
						
						<h3 class="color-name"><?php the_sub_field('color_description'); ?></h3>
						<?php if(get_sub_field('prototype')) : ?>
						<small>*One-of-a-kind prototype, only available through <a href="/coostr-club">Coostr Club</a>.</small>
						<?php else : ?>
						<small>&nbsp;</small>
						<?php endif; ?>
					</div>
				</div>
			<?php $count++; endwhile; ?>
		</div>
	</div>
<?php endif; ?>

<?php if (have_rows('carousel')): ?>
	<div class="row clearfix carousel-wrapper">
		<div class="col-md-12">
		    <div id="carousel" class="carousel slide" data-ride="carousel">

		        <?php
		        $slideCount = count(get_field('carousel'));
		        ?>
		        <ol class="carousel-indicators">
		            <?php for ($i = 1; $i <= $slideCount; $i++) : ?>
		                <li data-target="#carousel"
		                    data-slide-to="<?php echo $i - 1; ?>" <?php echo $i == 1 ? 'class="active"' : ''; ?>></li>
		            <?php endfor; ?>
		        </ol>

		        <div class="carousel-inner">

		            <?php $count = 0; while (have_rows('carousel')): the_row();

		                $image = get_sub_field('slide_image');
		                $caption = get_sub_field('slide_caption');
		                $activeCheck = '';
		                if($count == 0)
		                    $activeCheck = ' active';
		                ?>

		                <div class="item<?php echo $activeCheck; ?>">
		                    <img src="<?php echo $image; ?>"/>

		                    <div class="carousel-caption">
		                        <?php echo $caption; ?>
		                    </div>
		                </div>

		            <?php $count++; endwhile; ?>

		        </div>

		        <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
		            <span class="icon-arrow-left" aria-hidden="true"></span>
		            <span class="sr-only">Previous</span>
		        </a>
		        <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
		            <span class="icon-arrow-right" aria-hidden="true"></span>
		            <span class="sr-only">Next</span>
		        </a>

		    </div><!-- carousel -->
		</div>
	</div>
<?php endif; ?> 

<?php while(have_rows('featurette')): the_row(); ?>
    <div class="featurette row clearfix">
        <?php $position = get_sub_field('image_position'); ?>
        <?php if('right' == $position) : ?>
            <div class="col-md-7 vcenter">
                <?php the_sub_field('description'); ?>
            </div><!--
            --><div class="col-md-5 vcenter">
                <img src="<?php the_sub_field('image'); ?>" />
            </div>
        <?php else : ?>
            <div class="col-md-5 vcenter">
                <img src="<?php the_sub_field('image'); ?>" />
            </div><!--
            --><div class="col-md-7 vcenter">
                <?php the_sub_field('description'); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endwhile; ?>

<div class="row-fluid clearfix mail-chimp text-center">
	<div class="col-md-6 col-md-offset-3">
		<?php echo do_shortcode('[mc4wp_form]'); ?>
	</div>
</div>

<div class="social-wrapper">
	<h1 class="text-center">Follow Coostr</h1>
	<?php get_template_part('template-parts/social'); ?>
</div>
