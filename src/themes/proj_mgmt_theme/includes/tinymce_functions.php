<?php
// add horizontal rule button
function enable_more_buttons($buttons) {
	$buttons[] = 'hr';
	return $buttons;
}
add_filter("mce_buttons", "enable_more_buttons");