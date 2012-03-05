<?php
	$long_url = urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$api_user = 'nrcmediabv';
	$api_key = 'R_3e864f48d695a224d1c87b56dc94e';
	$request_url = "http://api.bit.ly/v3/shorten?login=".$api_user."&apiKey=".$api_key."&longUrl=".$long_url."&format=json";
	$curl =  new Curl();
	$bitly_content = $curl->get_data($request_url);
	$short_url = json_decode($bitly_content)->data->url;
?>
<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php the_title(); ?>: " data-url="<?php echo $short_url; ?>" data-via="nrcmedia" data-width="120" data-count="horizontal">Tweet</a>