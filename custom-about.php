<?php
/*
Template Name: 关于页面
*/
error_reporting(0);
?>
<?php get_header(); ?>

                      <!-- 关于 -->
        	            <div class="posts clearfix">
        								<article <?php post_class('single-post'); ?>>
        									<div class="post-wrap">
                            <header class="post-title wb">
                              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                <?php the_title(); ?>
                              </a>
                            </header>
        										<div class="post-inner">
                              <div class="post-right">
                                <div class="post-content wb clearfix">
																	<?php if ( have_posts() ) : the_post(); ?>
																			<?php the_content(); ?>
																	<?php endif; ?>
        												</div>
                              </div>
        										</div>
        									</div>
        								</article>
                        <!-- 评论 -->
                        <?php if ('open' == $post->comment_status) { ?>
                          <div id="comment-jump" class="comments">
                              <?php comments_template(); ?>
                          </div>
                        <?php } ?>
        	            </div>


<?php get_footer(); ?>
