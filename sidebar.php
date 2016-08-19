<?php
error_reporting(0);
?>
<!-- sidebar 开始-->
<aside id="sidebar" class="m_hide">
  <div class="sideinner">
    <div class="sidebar-content">
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
