<?php
error_reporting(0);
$profile = cs_get_option( 'i_profile' );
$profile_avatar = cs_get_option( 'i_profile_avatar' );
$profile_name = cs_get_option( 'i_profile_name' );
$profile_content = cs_get_option( 'i_profile_content' );
$blog_state = cs_get_option( 'i_blog_state' );
?>
<!-- sidebar 开始-->
<aside id="sidebar" class="m_hide">
  <div class="sideinner">
    <div class="sidebar-content">
      <?php if ($profile == true) {?>
        <aside id="profile" class="widget">
          <div class="profile-avatar"><img src="<?php echo $profile_avatar; ?>" alt="" /></div>
          <p class="profile-name"><?php echo $profile_name; ?></p>
          <p class="profile-content"><?php echo $profile_content; ?></p>
          <ul class="profile-social clearfix">
             <?php
                 $my_socials = cs_get_option( 'i_social' );
                 if( ! empty( $my_socials ) ) {
                   foreach ( $my_socials as $social ) {
                     $iconstyle = $social['i_icon_style'];
                     echo '<li>';
                     if( ! empty( $social['i_social_link'] ) ){echo '<a href="'. $social['i_social_link'] .'" class="with-tooltip" data-tooltip="'. $social['i_social_title'] .'"';}else{echo '<a href="javascript:void(0)"  class="with-tooltip" data-tooltip="'. $social['i_social_title'] .'" ';}
                     if ( $social['i_social_newtab'] == true) { echo 'target="_black"';}
                     if ($iconstyle == 'i_icon') {echo '><i class="'. $social['i_social_icon'] .'"></i>';} else {echo '><img src="'. $social['i_social_image'] .'">';}
                     echo '</a>';
                     echo '</li>';
                   }
                 }
             ?>
         </ul>
         <?php if ($blog_state == true) {?>
           <ul class="profile-blog clearfix">
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
         <?php }?>
        </aside>
      <?php }?>

      <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar') ) : else : ?>
      <?php endif; ?>
    </div>
  </div>
  <div class="sidectrl">
    <div class="sidebar-ctrl">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</aside>
<!-- sidebar 结束-->
