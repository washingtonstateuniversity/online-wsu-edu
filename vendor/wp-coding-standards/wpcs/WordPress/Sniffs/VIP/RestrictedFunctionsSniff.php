<?php
/**
 * Restricts usage of some functions in VIP context
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   Shady Sharaf <shady@x-team.com>
 */
class WordPress_Sniffs_VIP_RestrictedFunctionsSniff extends WordPress_Sniffs_Functions_FunctionRestrictionsSniff
{

	/**
	 * Groups of functions to restrict
	 *
	 * Example: groups => array(
	 * 	'lambda' => array(
	 * 		'type' => 'error' | 'warning',
	 * 		'message' => 'Use anonymous functions instead please!',
	 * 		'functions' => array( 'eval', 'create_function' ),
	 * 	)
	 * )
	 *
	 * @return array
	 */
	public function getGroups() {
		return array(

			'switch_to_blog' => array(
				'type'      => 'error',
				'message'   => '%s is not something you should ever need to do in a VIP theme context. Instead use an API (XML-RPC, REST) to interact with other sites if needed.',
				'functions' => array( 'switch_to_blog' ),
				),

			'create_function' => array(
				'type' => 'warning',
				'message' => '%s is discouraged, please use Anonymous functions instead.',
				'functions' => array(
					'create_function',
				),
			),

			'eval' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use Anonymous functions instead.',
				'functions' => array(
					'eval',
				),
			),

			'file_get_contents' => array(
				'type' => 'warning',
				'message' => '%s is highly discouraged, please use wpcom_vip_file_get_contents() instead.',
				'functions' => array(
					'file_get_contents',
					'vip_wp_file_get_contents',
				),
			),

			'get_term_link' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use wpcom_vip_get_term_link() instead.',
				'functions' => array(
					'get_term_link',
					'get_tag_link',
					'get_category_link',
				),
			),

			'get_page_by_path' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use wpcom_vip_get_page_by_path() instead.',
				'functions' => array(
					'get_page_by_path',
				),
			),

			'get_page_by_title' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use wpcom_vip_get_page_by_title() instead.',
				'functions' => array(
					'get_page_by_title',
				),
			),

			'get_term_by' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use wpcom_vip_get_term_by() instead.',
				'functions' => array(
					'get_term_by',
					'get_cat_ID',
				),
			),

			'get_category_by_slug' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use wpcom_vip_get_category_by_slug() instead.',
				'functions' => array(
					'get_category_by_slug',
				),
			),

			'url_to_postid' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use wpcom_vip_url_to_postid() instead.',
				'functions' => array(
					'url_to_postid',
					'url_to_post_id',
				),
			),

			'attachment_url_to_postid' => array(
				'type' => 'error',
				'message' => '%s is prohibited, please use wpcom_vip_attachment_url_to_postid() instead.',
				'functions' => array(
					'attachment_url_to_postid',
				),
			),

			'wp_remote_get' => array(
				'type' => 'warning',
				'message' => '%s is highly discouraged, please use vip_safe_wp_remote_get() instead.',
				'functions' => array(
					'wp_remote_get',
					),
				),

			'curl' => array(
				'type' => 'warning',
				'message' => 'Using cURL functions is highly discouraged within VIP context. Check (Fetching Remote Data) on VIP Documentation.',
				'functions' => array(
					'curl_*',
					),
				),

			'extract' => array(
				'type' => 'warning',
				'message' => '%s() usage is highly discouraged, due to the complexity and unintended issues it might cause.',
				'functions' => array(
					'extract',
					),
				),

			'custom_role' => array(
				'type' => 'error',
				'message' => 'Use wpcom_vip_add_role() instead of add_role()',
				'functions' => array(
					'add_role',
					),
				),

			'cookies' => array(
				'type' => 'warning',
				'message' => 'Due to using Batcache, server side based client related logic will not work, use JS instead.',
				'functions' => array(
					'setcookie',
					),
				),

			'user_meta' => array(
				'type' => 'error',
				'message' => '%s() usage is highly discouraged, check VIP documentation on "Working with wp_users"',
				'functions' => array(
					'get_user_meta',
					'update_user_meta',
					'delete_user_meta',
					'add_user_meta',
					),
				),

			// @todo Introduce a sniff specific to get_posts() that checks for suppress_filters=>false being supplied.
			'get_posts' => array(
				'type' => 'warning',
				'message' => '%s is discouraged in favor of creating a new WP_Query() so that Advanced Post Cache will cache the query, unless you explicitly supply suppress_filters => false.',
				'functions' => array(
					'get_posts',
					'wp_get_recent_posts',
				),
			),

			'get_pages' => array(
				'type' => 'error',
				'message' => '%s is highly discouraged in favor of creating a new WP_Query() so that Advanced Post Cache will cache the query.',
				'functions' => array(
					'get_children',
					'get_pages',
				),
			),

			'wp_get_post_terms' => array(
				'type' => 'error',
				'message' => '%s is highly discouraged due to not being cached; please use get_the_terms() along with wp_list_pluck() to extract the IDs.',
				'functions' => array(
					'wp_get_post_terms',
					'wp_get_post_categories',
					'wp_get_post_tags',
					'wp_get_object_terms',
				),
			),

			'term_exists' => array(
				'type' => 'error',
				'message' => '%s is highly discouraged due to not being cached; please use wpcom_vip_term_exists() instead.',
				'functions' => array(
					'term_exists',
				),
			),

			'count_user_posts' => array(
				'type' => 'error',
				'message' => '%s is highly discouraged due to not being cached; please use wpcom_vip_count_user_posts() instead.',
				'functions' => array(
					'count_user_posts',
				),
			),

			'wp_old_slug_redirect' => array(
				'type' => 'error',
				'message' => '%s is highly discouraged due to not being cached; please use wpcom_vip_old_slug_redirect() instead.',
				'functions' => array(
					'wp_old_slug_redirect',
				),
			),

			'get_adjacent_post' => array(
				'type' => 'error',
				'message' => '%s is highly discouraged due to not being cached; please use wpcom_vip_get_adjacent_post() instead.',
				'functions' => array(
					'get_adjacent_post',
					'get_previous_post',
					'get_next_post',
				),
			),

			'parse_url' => array(
				'type' => 'warning',
				'message' => '%s is discouraged due to a lack for backwards-compatibility in PHP versions; please use wp_parse_url() instead.',
				'functions' => array(
					'parse_url',
				),
			),

		);
	}
}//end class
