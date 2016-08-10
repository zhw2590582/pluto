<?php
/*
 评论模块.
*/

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('请勿直接加载该页面，谢谢!');
if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('该文章受密码保护，请输入密码以访问。'); ?></p>
<?php
	return;
}
?>
<div id="comments" class="clearfix">
	<h3 id="comments-title"><?php comments_number(__('留言'),__('1条评论'),__( '%条评论') );?></h3>
	<div id="loading-comments" class="hide"><span><i class="fa fa-spinner fa-pulse"></i> Loading...</span></div>
    <ul class="commentlist comdot">
        <?php wp_list_comments("callback=island_comment"); ?>
        <div class="clearfix"></div>
    </ul>
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <nav id="comment-nav-below" class="posts-nav" role="navigation">
        <div class="nav-inside">
        <?php paginate_comments_links('prev_next=0');?>
        </div>
    </nav>
    <?php endif;?>
    <?php comment_form(); ?>
</div>
