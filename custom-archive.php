<?php
/*
Template Name: 归档页面
*/
error_reporting(0);
?>
<?php get_header(); ?>

                      <!-- 归档 -->
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
																	<div class="archivePost">
																			 <ul class="timeline">
																			 <?php $count_posts = wp_count_posts(); $published_posts = $count_posts->publish;
																			 query_posts( 'posts_per_page=-1' );
																			 while ( have_posts() ) : the_post();
																					 echo '<li class="tl-item"><div class="tl-wrap clearfix">';
                                           echo '<span class="tl-date fl">';
                                           the_time(get_option( 'date_format' ));
																					 echo '</span><div class="tl-content fl">
																					 <a href="';
																					 the_permalink();
																					 echo '" title="'.esc_attr( get_the_title() ).'">';
																					 the_title();
                                           echo '</a></div>';
                                           echo '</div></li>';
																					 $published_posts--;
																			 endwhile;
																			 wp_reset_query(); ?>
																			 </ul>
																	 </div>
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
