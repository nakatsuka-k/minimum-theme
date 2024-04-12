<?php
/**
 * 検索フォーム
 */
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div id="sea-box-hom">
		<input name="s" id="s" type="text" class="inp-hom" placeholder="検索ワード" value="<?php echo get_search_query(); ?>" required="required">
	</div>
	<button type="submit" class="but-inp-hom" value="検索">
</form>