<?php
error_reporting(0);
$excerpt = cs_get_option( 'i_post_readmore' );
$view = cs_get_option( 'i_post_view' );
$meta_data = get_post_meta( get_the_ID(), 'standard_options', true );
$state = $meta_data['i_state'];
$state_text = $meta_data['i_state_text'];
$state_icon = $meta_data['i_state_icon'];
$music = $meta_data['i_post_music'];
$download = $meta_data['i_download'];
$web = $meta_data['i_download_web'];
$charge = $meta_data['i_download_charge'];
$link = $meta_data['i_download_link'];
$code = $meta_data['i_download_code'];
$jieya = cs_get_option( 'i_download_jieya' );
$dlview = cs_get_option( 'i_download_view' );
$feature_num = cs_get_option( 'i_feature_num' );
?>

<header class="post-title clearfix wb">

  <?php if ( $state == true && !is_mobile()  ) { ?>
    <i class="with-tooltip fl state fa <?php echo $state_icon; ?>" data-tooltip="<?php echo $state_text; ?>" aria-hidden="true"></i>
  <?php }?>

  <div class="fl">
    <a class="" href="<?php the_permalink(); ?>#content" title="<?php the_title(); ?>">
      <?php the_title(); ?>
    </a>
  </div>
</header>

<div class="post-inner colbox">

  <?php if ( !is_single() && !is_page() ) { ?>
    <div class="post-left col">

      <!-- 特色图 开始 -->
      <?php if ( has_post_thumbnail() ) { ?>
        <div class="post-featured" >
          <a href="<?php the_permalink(); ?>#content" title="<?php the_title(); ?>">
            <?php the_post_thumbnail( 'thumbnail' ); ?>
          </a>
        </div>
      <?php }else{?>
        <div class="post-featured" >
          <a href="<?php the_permalink(); ?>#content" title="<?php the_title(); ?>">
            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-echo="<?php bloginfo('template_directory'); ?>/images/thumbnail/img<?php echo rand(1,$feature_num)?>.png" alt="<?php the_title(); ?>" />
          </a>
        </div>
      <?php } ?>
      <!-- 特色图 结束 -->

      <?php if (!empty($music)) { ?>
        <!-- 播放器 开始 -->
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
        <!-- 播放器 结束 -->
      <?php } ?>

      <?php if ( is_sticky() ) : ?>
        <!-- 置顶文章 -->
        <div class="post-sticky with-tooltip m_hide" data-tooltip="置顶文章"></div>
        <?php else : ?>
      <?php endif; ?>

    </div>
  <?php } ?>

  <div class="post-right col">

    <div class="post-content wb clearfix">
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

<?php if ( is_single() && $download && !is_mobile() ) {?>
  <!-- 下载盒子 开始 -->
  <div class="download-wrap m_hide">
    <div class="post-download <?php if ( !current_user_can('level_10') && $dlview == true ){echo 'dlview';}?>">
      <div class="dl-item dl-title"><i class="fa fa-download"></i>资源下载</div>
      <div class="dl-box">
        <div class="dl-item dl-web">官方网站：<a href="<?php echo $web; ?>" target="_black">访问</a></div>
        <div class="dl-item dl-fei">软件性质：<?php if ( $charge == 'i_charge01' ) {echo '免费';}else { echo '收费';} ?></div>
        <div class="dl-item dl-link">下载地址：<a href="javascript:void(0)" data-dl="<?php echo $link; ?>" data-code="<?php if ( $code ) {echo $code;}else { echo '无';} ?>"><span>点击下载</span></a></div>
        <div class="dl-code">解压密码：<?php if ( $jieya ) {echo $jieya;}else { echo '无';} ?></div>
      </div>
      <div class="dl-view">资源评论回复可见！</div>
    </div>
  </div>
  <!-- 下载盒子 结束 -->
<?php } ?>
