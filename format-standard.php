<?php
error_reporting(0);
$excerpt = cs_get_option( 'i_post_readmore' );
$view = cs_get_option( 'i_post_view' );
$sticky_img = cs_get_option( 'i_related_image' );
$featured = cs_get_option( 'i_post_featured' );
$meta_data = get_post_meta( get_the_ID(), 'standard_options', true );
$music = $meta_data['i_post_music'];
$download = $meta_data['i_download'];
$web = $meta_data['i_download_web'];
$charge = $meta_data['i_download_charge'];
$link = $meta_data['i_download_link'];
$code = $meta_data['i_download_code'];
$player = cs_get_option('i_player');
$player_mobi = cs_get_option('i_player_mobi');
$author = cs_get_option( 'i_post_author' );
$jieya = cs_get_option( 'i_download_jieya' );
$dlview = cs_get_option( 'i_download_view' );
$feature_num = cs_get_option( 'i_feature_num' );
?>

<ul class="post_meta shadow clearfix">
    <li class="mate-view"><div class="mate-num ofh"><?php echo getPostViews(get_the_ID()); ?></div><i class="fa fa-eye"></i></li>
    <li class="mate-com"><div class="mate-num ofh"><?php comments_number(__('0','island'),__('1','island'),__( '%','island') );?></div><i class="fa fa-comments-o"></i></li>
    <?php if(current_user_can('level_10')){  ?>
      <li class="mate-edit"><?php edit_post_link( __( '<i class="fa fa-edit"></i>' ), '<div class="edit-link" alt="编辑文章"  title="编辑文章">', '</div>' ); ?></li>
    <?php } ?>
</ul>

<div class="post-inner flex">
    <?php if ( !is_single() && !is_page() ) { ?>
        <div class="post_left featured-box clearfix">
            <?php if ( has_post_thumbnail() ) { ?>
                <div class="featured-image" >
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php the_post_thumbnail( 'thumbnail' ); ?>
                    </a>
                </div>
            <?php }else{?>
                <div class="featured-image" >
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-echo="<?php bloginfo('template_directory'); ?>/images/thumbnail/img<?php echo rand(1,$feature_num)?>.png" alt="<?php the_title(); ?>" />
                    </a>
                </div>
            <?php } ?>
            <?php if (!empty($music)) { ?>
                <div class="audio-wrapper">
                    <audio class="wp-audio-shortcode" preload="none" style="width: 100%">
                        <source type="audio/mpeg" src="<?php echo $music; ?>">
                    </audio>
                    <?php wp_enqueue_script('mediaelement'); ?>
                    <?php wp_enqueue_style('mediaelement'); ?>
                    <script>
                        jQuery(document).ready(function($) {
                            $('.audio-wrapper audio').mediaelementplayer();
                        });
                    </script>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

  <div class="post_right flex_item">
      <header>
          <h4 class="entry-title ofh"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
      </header>

      <div class="post-content">
          <div class="content clearfix">
          <?php if(is_search() || is_archive()) { ?>
              <div class="excerpt-more">
                  <?php the_excerpt(__( 'Read More','island')); ?>
              </div>
          <?php } else { ?>
              <?php if(is_home()) { ?>
                  <?php if ($excerpt == true) {
                      the_excerpt(__( 'Read More','island'));
                  }else{
                      the_content(__( 'Read More','island'));
                  }?>
              <?php } else { ?>
                  <?php the_content(__( 'Read More','island')); ?>
              <?php } ?>
          <?php } ?>
          </div>
      </div>
  </div>
</div>

<?php if ( is_single() && $download && !is_mobile() ) {?>
    <div class="download-wrap m_hide">
        <div class="post-download <?php if ( !current_user_can('level_10') && $dlview == true ){echo 'dlview';}?>">
            <div class="dl-title"><i class="fa fa-download"></i>资源下载</div>
            <div class="dl-box">
                <div class="dl-web">官方网站：<a href="<?php echo $web; ?>" target="_black">访问</a></div>
                <div class="dl-fei">软件性质：<?php if ( $charge == 'i_charge01' ) {echo '免费';}else { echo '收费';} ?></div>
                <div class="dl-link">下载地址：<a href="javascript:void(0)" data-dl="<?php echo $link; ?>" data-code="<?php if ( $code ) {echo $code;}else { echo '无';} ?>"><span>点击下载</span></a></div>
                <div class="dl-code">解压密码：<?php if ( $jieya ) {echo $jieya;}else { echo '无';} ?></div>
            </div>
            <div class="dl-view">资源评论回复可见！</div>
        </div>
    </div>
<?php } ?>
