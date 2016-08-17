<?php
error_reporting(0);
?>

<?php get_header(); ?>

                      <!-- 作品详情 -->
        	            <div class="posts clearfix">
        								<article <?php post_class('post-404'); ?>>
        									<div class="post-wrap">
                            <header class="post-title wb">
                              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                404
                              </a>
                            </header>
        										<div class="post-inner">
                              <div class="post-right">
                                <div class="post-content wb clearfix">
                                  <p>对不起，你要查看的页面已经不存在，请返回！</p>
        												</div>
                              </div>
        										</div>
        									</div>
        								</article>
        	            </div>
                  </div>
                      <!-- content-inner 结束-->
                </div>
                  <!-- container 结束-->
              </section>
              <!-- content 结束-->

<?php get_footer(); ?>
