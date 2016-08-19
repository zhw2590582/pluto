<?php
/*
Template Name: 友链页面
*/
error_reporting(0);
?>

<?php get_header(); ?>

                      <!-- 友情链接 -->
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
        														<ul class="link_box">
                                        <?php wp_list_bookmarks('orderby=id&category_orderby=id'); ?>
        														</ul>
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
                      <a href="#top" class="post-top"></a>
                  </div>
                      <!-- content-inner 结束-->
                </div>
                  <!-- container 结束-->
              </section>
              <!-- content 结束-->

<?php get_footer(); ?>
