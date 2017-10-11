<ul class="comments-holder">
	<?php
		wp_list_comments(array(
			'style' => 'ul',
			'short_ping' => true,
			'avatar_size'=> 50,
			'max_depth' => 3,
		)); 
	?>
</ul>

<div class="reply-holder">
	<?php comment_form(array('title_reply' => '')); ?>
</div>