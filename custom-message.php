<?php 
/* 
Template Name: 留言页面
*/ 
error_reporting(0);
$layout = cs_get_option('i_layout');
$wall = cs_get_option('i_comment_wall');
$num = cs_get_option('i_comment_num');
$avatar_image = cs_get_option( 'i_avatar_image' );
$avatar_content = cs_get_option( 'i_avatar_content' );
$me = cs_get_option( 'i_me_switch' );
$bulletin = cs_get_option( 'i_bulletin' );

?>
<?php get_header(); ?>

		<section id="content">
            <div class="container">
                <div class="content-inner">

        <?php if (!is_mobile()) { ?>
            <div class="main_header colbox m_hide">
                <div class="avatar_box col">
                    <div class="me_img">
                        <div class="me_avatar">
                            <img src="<?php echo $avatar_image; ?>">
                        </div>
                        <ul class="me_name">
                            <li>
                                <p class="me_num"><?php $count_posts = wp_count_posts(); echo $published_posts =$count_posts->publish;?></p>
                                <p class="me_title">文章</p>
                            </li>
                            <li>
                                <p class="me_num"><?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");?></p>
                                <p class="me_title">评论</p>
                            </li>
                            <li>
                                <p class="me_num"><?php $link = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'"); echo $link; ?></p>
                                <p class="me_title">邻居</p>
                            </li>
                        </ul>                   
                    </div>
                <?php if ($bulletin) { ?>
                    <div class="bulletin">
                        <?php
                            $my_bulletins = cs_get_option( 'i_bulletin_custom' );
                            echo '<ul class="bulletin_list">';
                            if( ! empty( $my_bulletins ) ) {
                              foreach ( $my_bulletins as $bulletin ) {
                                echo '<li style="display:none">';
                                if( ! empty( $bulletin['i_bulletin_link'] ) ){ echo '<a href="'. $bulletin['i_bulletin_link'] .'"';}
                                if ( ! empty( $bulletin['i_bulletin_link'] ) && $bulletin['i_bulletin_newtab'] == true) { echo 'target="_black">';}else{ if ( ! empty( $bulletin['i_bulletin_link'] )){ echo '>';}}
                                echo ''. $bulletin['i_bulletin_text'] .'';
                                if( ! empty( $bulletin['i_bulletin_link'] ) ){ echo '</a>';}
                                echo '</li>';
                              }
                            }
                            echo '</ul>';
                        ?>
                    </div>
                <?php } ?>
                </div>
                <div class="main-menu col">
                    <?php wp_nav_menu(array('theme_location' => 'main', 'container' => 'div', 'container_class' => 'header-menu-wrapper', 'menu_class' => 'header-menu-list')); ?>
                </div>
            </div>
        <?php } ?>

                    <div class="main_body colbox">
                        <?php if (!is_mobile() && $layout == 'i_layout_two') { ?>
                            <aside id="sidebar" class="col m_hide">
                                <?php if ($me == true) {?>
                                    <div id="about">
                                        <p class="me_content">
                                            <?php echo $avatar_content; ?>
                                        </p>
                                        <div class="social_link">
                                            <?php
                                                $my_socials = cs_get_option( 'i_social' );
                                                echo '<ul class="clearfix">';
                                                if( ! empty( $my_socials ) ) {
                                                  foreach ( $my_socials as $social ) {
                                                    $iconstyle = $social['i_icon_style'];
                                                    echo '<li>';
                                                    if( ! empty( $social['i_social_link'] ) ){echo '<a href="'. $social['i_social_link'] .'" title="'. $social['i_social_title'] .'"';}else{echo '<a href="javascript:void(0)" title="'. $social['i_social_title'] .'" ';}
                                                    if ( $social['i_social_newtab'] == true) { echo 'target="_black"';}
                                                    if ($iconstyle == 'i_icon') {echo '><i class="'. $social['i_social_icon'] .'"></i>';} else {echo '><img src="'. $social['i_social_image'] .'">';}
                                                    echo '</a>';
                                                    echo '</li>';
                                                  }
                                                }
                                                echo '</ul>';
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div id="widget" class="widgets">
                                    <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Aside') ) : else : ?>
                                    <?php endif; ?>
                                </div>
                            </aside>
                        <?php }?>
                        <div id="main" class="col">
                            <div class="main-inner">
        	                    <div id="posts-box">
        	                        <div class="posts clearfix">
        								<article>
        									<div class="post-wrap">
        										<div class="post-inner">
        											<div class="post-body">
        												<header>
															<h2 class="entry-title">
																<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
																	<?php the_title(); ?>
																</a>
															</h2>
        												</header>
        												<div class="post-content">
        													<div calss="content clearfix">
        														<?php the_content(); ?>
                                                                <!-- start 读者墙  Edited By iSayme-->
                                                                <?php if ($wall == true) {
                                                                    $query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email != '改成你的邮箱账号' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT ".$num."";//大家把管理员的邮箱改成你的,最后的这个39是选取多少个头像，大家可以按照自己的主题进行修改,来适合主题宽度
                                                                    $wall = $wpdb->get_results($query);
                                                                    $maxNum = $wall[0]->cnt;
                                                                    foreach ($wall as $comment)
                                                                    {
                                                                        $width = round(40 / ($maxNum / $comment->cnt),2);//此处是对应的血条的宽度
                                                                        if( $comment->comment_author_url )
                                                                        $url = $comment->comment_author_url;
                                                                        else $url="#";
                                                                        $avatar = get_avatar( $comment->comment_author_email, $size = '24', $default = get_bloginfo('wpurl').'/avatar/default.jpg' );
                                                                        $tmp = "
                                                                        <li>
                                                                        <a target=\"_blank\" href=\"".$comment->comment_author_url."\">
                                                                            <div class='readers-inner colbox'>
                                                                                <div class='col avatar-img'>
                                                                                    ".$avatar."
                                                                                </div>
                                                                                <div class='col'>
                                                                                    <p class='name'>
                                                                                        ".$comment->comment_author."
                                                                                    </p>
                                                                                    <p class='cnt'>
                                                                                        ".$comment->cnt."条评论
                                                                                    </p>
                                                                                </div>

                                                                            </div>
                                                                        </a>
                                                                        </li>";
                                                                        $output .= $tmp;
                                                                     }
                                                                    $output = "<ul class=\"readers-list clearfix\">".$output."<div class='clearfix'></div></ul>";
                                                                    echo $output ;
                                                                }?>
                                                                <!-- end 读者墙 -->	
        													</div>
        												</div>
        											</div>
        										</div>
        									</div>
        								</article>
        	                        </div>

									<!-- 评论 -->
									<?php if ('open' == $post->comment_status) { ?>
									<div id="comment-jump" class="comments">
										<?php comments_template(); ?>
									</div>
									<?php } ?>

        	                    </div>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php get_footer(); ?>