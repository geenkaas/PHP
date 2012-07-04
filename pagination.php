<?php if ( have_posts()) : while(have_posts() ) : the_post (); 
	
	if ( !isset($_SESSION['randomPosts']) || !is_array($_SESSION['randomPosts']) ) {
		// Get $db instance
		$db = Db::get_instance();
		
		// Get random posts
		$postRes = $db->query('
			SELECT post_name FROM nrcca_posts
			WHERE post_type = "post" AND post_status = "publish"
		');
		$randomPosts = array();
		while ($row = $postRes->fetch_assoc()) {
			$randomPosts[] = $row['post_name'];
		}
		$_SESSION['randomPosts'] = $randomPosts;
	}
	$postPosition = array_search($post->post_name, $_SESSION['randomPosts']);
	$nextPost = ($postPosition+1) >= count($_SESSION['randomPosts']) ? 0 : $postPosition+1;
	$previousPost = ($postPosition-1) < 0 ? count($_SESSION['randomPosts']) -1 : $postPosition-1;
		
	?>
	
	<div id="btn-prev" class="btn-prev-next">
		<a href="/inzendingen/<?=$_SESSION['randomPosts'][$previousPost]?>/">Vorige</a> 
	</div>
	<div id="btn-next" class="btn-prev-next"> 
		<a href="/inzendingen/<?=$_SESSION['randomPosts'][$nextPost]?>/">Volgende</a>
	</div>	

<?php endwhile; endif; ?>