<?php
error_reporting(0);
$profile = cs_get_option( 'i_profile' );
$profile_avatar = cs_get_option( 'i_profile_avatar' );
$profile_name = cs_get_option( 'i_profile_name' );
$profile_content = cs_get_option( 'i_profile_content' );
?>
<!-- sidebar 开始-->
<aside id="sidebar" class="m_hide">
  <div class="sideinner">
    <div class="sidebar-content">
      <?php if ($profile == true) {?>
        <aside id="profile" class="widget">
          <div class="profile-avatar">
            <div class="profile-avatar-inner">
              <img src="<?php echo $profile_avatar; ?>" alt="" />
            </div>
          </div>
          <div class="profile-name">
            <div class="profile-name-inner">
              <?php echo $profile_name; ?>
            </div>
          </div>
          <div class="profile-content">
            <?php echo $profile_content; ?>
          </div>
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
