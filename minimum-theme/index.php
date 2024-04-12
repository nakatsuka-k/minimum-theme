<?php
/**
* サイトのindexページ
*
* @link 
*
* @package WordPress
* @subpackage minimum-theme
* @since 1.0.0
*/
?>

<?php
get_header();
?>

<main class="main">

<?php 
// ページ内容の出力
if ( is_home() ) {
	// トップページ
	get_template_part( 'pages/home' );
} else if ( is_page() || is_singular() ) {
	// 固定ページ
	get_template_part( 'pages/page' );
} else if ( is_single() ) {
	// シングルページ
	get_template_part( 'pages/single' );
} else if ( is_category() ) {
	// カテゴリページ
	get_template_part( 'pages/category' );
} else if ( is_archive() ) {
	// アーカイブページ
	get_template_part( 'pages/archive' );
} else if ( is_search() ) {
	// 検索ページ
	get_template_part( 'pages/search' );
} else {
	get_template_part( 'pages/404' );
}
?>

<?php
get_sidebar();
?>

</main>

<?php
get_footer();
?>