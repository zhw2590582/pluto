<?php
 // 作品详情
 error_reporting(0);
?>

<?php get_header(); ?>

                      <!-- 作品详情 -->
        	            <div class="posts clearfix">
        								<article <?php post_class('single-post'); ?>>
                          <div class="post-tool">
                            <!-- 日期  -->
                            <div class="post-date">
                              <span class="date-month"><?php the_time('m'); ?>月</span>
                              <span class="date-day"><?php the_time('d'); ?></span>
                              <span class="date-year"><?php the_time('Y'); ?></span>
                            </div>
                            <!-- 浏览  -->
                            <div class="post-view">
                              <a href="javascript:void(0)">
                                <i class="fa fa-eye"></i><span class="view-num"><?php echo getPostViews(get_the_ID()); ?></span>
                              </a>
                            </div>
                            <?php if(current_user_can('level_10')){  ?>
                              <!-- 编辑  -->
                              <div class="post-edit">
                                  <?php edit_post_link( __( '<i class="fa fa-edit"></i><span class="view-num">编辑</span>' ), '<div class="edit-link">', '</div>' ); ?>
                              </div>
                            <?php } ?>
                          </div>
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
                      <a href="#top" class="post-top"></a>
                  </div>
                      <!-- content-inner 结束-->
                </div>
                  <!-- container 结束-->
              </section>
              <!-- content 结束-->

<?php get_footer(); ?>
