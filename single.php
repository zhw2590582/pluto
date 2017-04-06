<?php
error_reporting(0);
$link = cs_get_option( 'i_post_link' );
$related = cs_get_option( 'i_post_related' );
$date = cs_get_option( 'i_post_date' );
$view = cs_get_option( 'i_post_view' );
$com = cs_get_option( 'i_post_com' );
$cat = cs_get_option( 'i_post_cat' );
$tag = cs_get_option( 'i_post_tag' );
$like = cs_get_option( 'i_post_like' );
?>

<?php get_header(); ?>

            <div class="posts">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php setPostViews(get_the_ID());?>
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
                      <?php get_template_part('format', 'standard'); ?>

                      <?php if ($link == true && !is_mobile()) { ?>
                        <div class="post-copyright m_hide">
                          <div class="post-copyright-inner">
                            转载原创文章请注明，转载自： <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> » <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="post-related m_hide">
                        <?php if ($related == true && !is_mobile()) { ?>
                        <ul class="related_box clearfix">
                            <?php
                            $post_num = 5;
                            $exclude_id = $post->ID;
                            $posttags = get_the_tags(); $i = 0;
                            if ( $posttags ) {
                                $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
                                $args = array(
                                    'post_status' => 'publish',
                                    'tag__in' => explode(',', $tags),
                                    'post__not_in' => explode(',', $exclude_id),
                                    'caller_get_posts' => 1,
                                    'orderby' => 'comment_date',
                                    'posts_per_page' => $post_num
                                );
                                query_posts($args);
                                while( have_posts() ) { the_post(); ?>
                                    <li class="related_box"  >
                                    <div class="r_pic">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
                                    <img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
                                    </a>
                                    </div>
                                    <div class="r_title"><a class="wb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"  rel="bookmark"><?php the_title(); ?></a></div>
                                    </li>
                                <?php
                                    $exclude_id .= ',' . $post->ID; $i ++;
                                } wp_reset_query();
                            }
                            if ( $i < $post_num ) {
                                $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
                                $args = array(
                                    'category__in' => explode(',', $cats),
                                    'post__not_in' => explode(',', $exclude_id),
                                    'caller_get_posts' => 1,
                                    'orderby' => 'comment_date',
                                    'posts_per_page' => $post_num - $i
                                );
                                query_posts($args);
                                while( have_posts() ) { the_post(); ?>
                                <li>
                                    <div class="r_pic">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
                                    <img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
                                    </a>
                                    </div>
                                    <div class="r_title"><a class="wb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"  rel="bookmark"><?php the_title(); ?></a></div>
                                </li>
                                <?php $i++;
                                } wp_reset_query();
                            }
                            if ( $i  == 0 )  echo '<div class="r_title"></div>';
                            ?>
                        </ul>
                        <?php } ?>
                    </div>
                    <ul class="post-meta clearfix">
                      <?php if ($cat == true) { ?>
                        <li class="mate-cat fl clearfix"><i class="fa fa-bookmark"></i><?php the_category(' '); ?></li>
                      <?php } ?>
                      <?php if ($tag == true) { ?>
                        <?php $posttags = get_the_tags(); if ($posttags) { ?><li class="meta-tabs fl clearfix m_hide"><i class="fa fa-tags"></i><?php the_tags('', ' ', ''); ?></li><?php } ?>
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
                <?php endwhile; ?>
                <?php endif; ?>

                <?php if( is_single () ) { ?>
                    <?php if ('open' == $post->comment_status) { ?>
                    <div id="comment-jump" class="comments">
                        <?php comments_template(); ?>
                    </div>
                    <?php } ?>
                <?php } ?>

            </div>


<?php get_footer(); ?>
