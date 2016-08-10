<?php 
/* 
Template Name: 作品页面
*/ 
error_reporting(0);
$pagination = cs_get_option('i_pagination');
$loadmore = cs_get_option( 'i_ajax_loading' );  
$loadend = cs_get_option( 'i_ajax_end' ); 
$loadnum = cs_get_option( 'i_ajax_num' ); 
$worksnum = cs_get_option( 'i_works_num' ); 
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
                        <div id="main" class="col m_hide">
                            <div class="main-inner">
        	                    <div id="posts-box">
        	                        <div class="posts grids clearfix">

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

                                        <article <?php post_class('grid-item'); ?>>
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
                                        </article>

                                        <?php endwhile;?>
        	                        </div>

                                    <div class="work-nav fadeInDown animated">
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
                    </div>
                </div>
            </div>
        </section>

<?php get_footer(); ?>