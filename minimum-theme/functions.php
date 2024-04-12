<?php
/**
* WordPress全体に関わる処理
*
* @link 
*
* @package WordPress
* @subpackage minimum-theme
* @since 1.0.0
*/


/************************************************
 * 
 * セキュリティ
 * 
 ************************************************/
// RestAPIを禁止する
function my_rest_endpoints( $endpoints ) {
	if ( isset( $endpoints["/wp/v2/users"] ) ) {
		unset( $endpoints["/wp/v2/users"] );
	}
	if ( isset( $endpoints["/wp/v2/users/(?P[\d]+)"] ) ) {
		unset( $endpoints["/wp/v2/users/(?P[\d]+)"] );
	}
	return $endpoints;
}
add_filter( "rest_endpoints", "my_rest_endpoints", 10, 1 );

// オーナー情報を保護する
function my_template_redirect() {
	if( is_author() ) {
		wp_redirect( home_url());
		exit;
	}
}
add_action("template_redirect", "my_template_redirect" );

// Pingbackを無効化する
function my_pre_ping( &$links ) {
	$home = get_option( "home" );
	foreach ( $links as $l => $link ){
		if ( 0 === strpos( $link, $home ) ){
			unset($links[$l]);
		}
	}
}
add_action("pre_ping", "my_pre_ping" );

// バージョン情報を非表示にする
remove_action("wp_head", "wp_generator" );

// ログインエラーメッセージを非表示にする
function my_login_errors() {
	return "ログイン情報が間違っています。";
}
add_filter("login_errors", "my_login_errors" );

// ログイン画面のリンクを変更する
function my_login_logo_url() {
	return home_url();
}
add_filter("login_headerurl", "my_login_logo_url" );

// WordPressのバージョンを非表示
remove_action('wp_head','wp_generator');

// 短縮URLを非表示
remove_action('wp_head', 'wp_shortlink_wp_head');

// テーマファイル以外のバージョン情報非表示
function remove_cssjs_ver2( $src ) {
	if ( strpos( $src, 'ver=' ) && !strpos( $src, get_template() ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
foreach ( array( 'rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header',
	'atom_head', 'comments_atom_head', 'opml_head', 'app_head' ) as $action ) {
	if ( has_action( $action, 'the_generator' ) )
		remove_action( $action, 'the_generator' );
}
add_filter( 'style_loader_src', 'remove_cssjs_ver2', 9999 );
add_filter( 'script_loader_src', 'remove_cssjs_ver2', 9999 );

// 不要な情報を削除
remove_action('do_feed_rdf', 'do_feed_rdf');
remove_action('do_feed_rss', 'do_feed_rss');
remove_action('do_feed_rss2', 'do_feed_rss2');
remove_action('do_feed_atom', 'do_feed_atom');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

/************************************************
 * 
 * 軽量化
 * 
 ************************************************/
// 不要な機能を削除
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wlwmanifest_link' );
remove_action('wp_head', 'rsd_link');


/************************************************
 * 
 * CSS、JS読み込み
 * 
 ************************************************/
// CSS、JS読み込み
function my_enqueue_scripts() {
	// CSS
	wp_enqueue_style('main-style', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style('reset', get_template_directory_uri() . '/css/reset.css' );
	// JS
	wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts' );