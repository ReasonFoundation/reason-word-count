<?php
/**
 * Plugin Name:     Reason Word Count
 * Plugin URI:      https://reason.org
 * Description:     Add a Word Count column to the posts table
 * Author:          Reason Foundation
 * Author URI:      https://reason.org
 * Text Domain:     reason-word-count
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Reason_Word_Count
 */

require __DIR__ . '/vendor/autoload.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://kernl.us/api/v1/updates/67128220c835aaa22f623f3a/',
	__FILE__,
	'reason-word-count'
);

// https://www.wpbeginner.com/plugins/how-to-get-word-count-stats-in-wordpress-with-word-stats/#add-word-count-stats-wordpress-code
add_filter('manage_posts_columns', 'reason_wordcount_add_column');
function reason_wordcount_add_column($reason_wordcount_wordcount_column) {
	$reason_wordcount_wordcount_column['reason_wordcount_wordcount'] = 'Word Count';
	return $reason_wordcount_wordcount_column;
}

//Link the word count to our new column//
add_action('manage_posts_custom_column',  'reason_wordcount_display_wordcount');
function reason_wordcount_display_wordcount($name)
{
	global $post;
	switch ($name)
	{
		case 'reason_wordcount_wordcount':
			//Get the post ID and pass it into the get_wordcount function//
			$reason_wordcount_wordcount = reason_wordcount_get_wordcount($post->ID);
			echo $reason_wordcount_wordcount;
	}
}

function reason_wordcount_get_wordcount($post_id) {
	//Get the post, remove any unnecessary tags and then perform the word count//
	$reason_wordcount_wordcount = str_word_count( strip_tags( strip_shortcodes(get_post_field( 'post_content', $post_id )) ) );
	return $reason_wordcount_wordcount;
}