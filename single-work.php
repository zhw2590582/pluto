<?php
 // 作品详情
 error_reporting(0);
 $date = cs_get_option( 'i_post_date' );
 $view = cs_get_option( 'i_post_view' );
 $com = cs_get_option( 'i_post_com' );
 $cat = cs_get_option( 'i_post_cat' );
 $tag = cs_get_option( 'i_post_tag' );
 $like = cs_get_option( 'i_post_like' );
?>

<?php get_header(); ?>

                      <!-- 作品详情 -->
        	            <div class="posts clearfix">
        								<article <?php post_class('single-post'); ?>>
                          <?php if (!is_mobile()) { ?>
                                <div class="post-tool m_hide">
                                  <?php if ($date == true) { ?>
                                    <!-- 日期  -->
                                    <div class="post-date">
                                      <span class="date-month"><?php the_time('m'); ?>月</span>
                                      <span class="date-day"><?php the_time('d'); ?></span>
                                      <span class="date-year"><?php the_time('Y'); ?></span>
                                    </div>
                                  <?php } ?>
                                  <?php if ($view == true) { ?>
                                    <!-- 浏览  -->
                                    <div class="post-view">
                                      <a href="javascript:void(0)">
                                        <i class="fa fa-eye"></i><span class="view-num"><?php echo getPostViews(get_the_ID()); ?></span>
                                      </a>
                                    </div>
                                  <?php } ?>
                                  <?php if(current_user_can('level_10')){  ?>
                                    <!-- 编辑  -->
                                    <div class="post-edit">
                                        <?php edit_post_link( __( '<i class="fa fa-edit"></i><span class="view-num">编辑</span>' ), '<div class="edit-link">', '</div>' ); ?>
                                    </div>
                                  <?php } ?>
                                </div>
                          <?php } ?>
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
                            <ul class="post-meta clearfix">
                              <?php if ($cat == true) { ?>
                                <li class="mate-cat fl clearfix"><i class="fa fa-bookmark"></i><?php $terms_as_text = get_the_term_list( $post->ID, 'genre', '', ', ', '' ) ; echo strip_tags($terms_as_text); ?></li>
                              <?php } ?>
                              <?php if ($like == true) { ?>
                                <li class="meta-like fr mr0"><?php echo getPostLikeLink( get_the_ID() ); ?></li>
                              <?php } ?>
                              <?php if ($com == true) { ?>
                                <li class="mate-com fr"><i class="fa fa-comments-o"></i><span class="mate-num"><?php comments_number(__('0','island'),__('1','island'),__( '%','island') );?></span></li>
                              <?php } ?>
                            </ul>
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
