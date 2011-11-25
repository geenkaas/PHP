//	This goes in functions.php
// get all of the images attached to the current post
function get_images($size = 'thumbnail') {
	global $post;
	$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
	$results = array();
	if ($photos) {
		foreach ($photos as $photo) {
			// get the correct image html for the selected size
			$results[] = wp_get_attachment_image($photo->ID, $size);
		};
	};
	return $results;
};


//	And this bit in your template where needed
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="postgallerywrapper" class="sliderwrapper">
		<div class="sliderdiv">
			<?php $photos = get_images('full');

			if ($photos) {
				foreach ($photos as $photo) {
					echo '<div class="slidediv">'.$photo.'</div>';
				}
			} ?>
		</div>
		<div class="slidercontrols">
			<div class="centerdiv">
				<div class="slidercontrol" btn="prev">prev</div>
				<div class="bolletjes"></div>
				<div class="slidercontrol" btn="next">next</div>
			</div>
		</div>
	</div>
<?php endwhile; endif; ?>