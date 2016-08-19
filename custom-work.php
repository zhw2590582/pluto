<?php
/*
Template Name: 作品页面
*/
error_reporting(0);
$worksnum = cs_get_option( 'i_works_num' );

?><?php get_header(); ?>

                      <!-- 作品 -->
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
																	<?php
																		$temp = $wp_query;
																		$wp_query = null;
																		$wp_query = new WP_Query();
																		$show_posts = $worksnum;
																		$permalink = 'Post name';
																		$post_type = 'work';
																		$req_uri =  $_SERVER['REQUEST_URI'];
																		if($permalink == 'Default') {
																				$req_uri = explode('paged=', $req_uri);
																				if($_GET['paged']) {
																					$uri = $req_uri[0] . 'paged=';
																				} else {
																					$uri = $req_uri[0] . '&paged=';
																				}
																		} elseif ($permalink == 'Post name') {
																				if (strpos($req_uri,'page/') !== false) {
																						$req_uri = explode('page/',$req_uri);
																						$req_uri = $req_uri[0] ;
																				}
																					$uri = $req_uri . 'page/';
																		}
																		$wp_query->query('showposts='.$show_posts.'&post_type='. $post_type .'&paged='.$paged);
																		$count_posts = wp_count_posts('projects');
																		while ($wp_query->have_posts()) : $wp_query->the_post();
																		?>

																		<div <?php post_class('grid-item'); ?>>
																			<div class="grid-inner">
																				<div class="work-wrap">
																					<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
																						<?php the_post_thumbnail('thumbnail'); ?>
																						<div class="work-content" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
																							<?php the_title();?>
																						</div>
																					</a>
																				</div>
																				<ul class="work-mate clearfix">
																					<li class="work_tabs fl"><?php $terms_as_text = get_the_term_list( $post->ID, 'genre', '', ', ', '' ) ; echo strip_tags($terms_as_text); ?></li>
																					<ul class="clearfix fr">
																						<li class="fl"><?php echo getPostLikeLink( get_the_ID() ); ?></li>
																						<li class="fl"><i class="fa fa-eye"></i><?php echo getPostViews(get_the_ID()); ?></li>
																					</ul>
																				</ul>
																			</div>
																		</div>

																	<?php endwhile;?>
																</div>

																<div class="work-nav">
																	<div class="post-nav">
																		<div class="post-nav-inside">
																			<?php previous_posts_link('上一页 ') ?>
																			<?php
																			$count_post = $count_posts->publish / $show_posts;

																			if( $count_posts->publish % $show_posts == 2 ) {
																			$count_post++;
																			$count_post = intval($count_post);
																			};

																			for($i = 1; $i <= $count_post ; $i++) { ?>
																			<a <?php if($req_uri[1] == $i) { echo 'class=active_page'; } ?> href="<?php echo $uri . $i; ?>" rel="external nofollow" ><?php echo $i; ?></a>
																			<?php }
																			?>
																			<?php next_posts_link(' 下一页') ?>
																		</div>
																	</div>
																</div>
																<?php
																$wp_query = null;
																$wp_query = $temp;  // Reset
																?>

																<script>
																	jQuery(document).ready(function($) {
																			if($(".post-nav-inside a").length==0){
																					$(".post-nav").removeClass("post-nav");
																			} else if ($(".post-nav-inside a").length==1){

																			}else{
																					$(".post-nav-inside a:eq(0)").wrap("<div class='post-nav-left'></div>");
																					$(".post-nav-inside a:eq(1)").wrap("<div class='post-nav-right'></div>");
																			}
																	});
																</script>
		  												</div>
		                        </div>
		  										</div>
		  								</article>
		  	            </div>
                    <span class="post-top"></span>
                  </div>
                      <!-- content-inner 结束-->
                </div>
                  <!-- container 结束-->
              </section>
              <!-- content 结束-->

<?php get_footer(); ?>
