<?php if ( ! defined( 'ABSPATH' ) ) { die; } //不能直接访问网页.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// 文章和页面属性选项
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options      = array();

// -----------------------------------------
// 页面选项                -
// -----------------------------------------
$options[]    = array(
  'id'        => 'default_page',
  'title'     => '默认模板选项',
  'post_type' => 'page',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'  => 'page_section_1',
      'fields' => array(

		
      ), 
    ), 

  ),
);

$options[]    = array(
  'id'        => 'archive_page',
  'title'     => '归档模板选项',
  'post_type' => 'page',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'  => 'page_section_1',
      'fields' => array(
          
		
      ), 
    ), 

  ),
);

$options[]    = array(
  'id'        => 'work_page',
  'title'     => '作品模板选项',
  'post_type' => 'page',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'  => 'page_section_1',
      'fields' => array(          
		
      ), 
    ), 

  ),
);


$options[]    = array(
  'id'        => 'friend_page',
  'title'     => '友链模板选项',
  'post_type' => 'page',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'  => 'page_section_1',
      'fields' => array(
		
      ), 
    ), 

  ),
);

$options[]    = array(
  'id'        => 'message_page',
  'title'     => '留言模板选项',
  'post_type' => 'page',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'  => 'page_section_1',
      'fields' => array(
		
		
      ), 
    ), 

  ),
);

$options[]    = array(
  'id'        => 'about_page',
  'title'     => '关于模板选项',
  'post_type' => 'page',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'  => 'page_section_1',
      'fields' => array(
		
		
      ), 
    ), 

  ),
);


// -----------------------------------------
// 文章属性选项                    -
// -----------------------------------------

// 标准文章选项
$options[]    = array(
  'id'        => 'standard_options',
  'title'     => '标准文章选项',
  'post_type' => 'post',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'   => 'aside_section_1',
      'title' => ' 音乐',
      'icon'  => 'fa fa-music',      
      'fields' => array(
	  
	  // 音乐外链
        array(
          'id'        => 'i_post_music',
          'type'      => 'text',
          'title'     => '音乐外链',
		  'help'     => '前提是正确开启Cue播放器，并且Cue歌单里存在歌曲',
          'attributes'    => array(
            'placeholder' => 'http://...'
          )		  
        ),

      ),
    ),	

    array(
      'name'   => 'aside_section_2',
      'title' => ' 下载',
      'icon'  => 'fa fa-download',        
      'fields' => array(
	  
          // 资源下载
		array(
          'id'    	  => 'i_download',
          'type'      => 'switcher',
          'title'     => '资源下载',
        ),			
          
          // 官方网站
        array(
          'id'         => 'i_download_web',
          'type'       => 'text',
          'title'      => '官方网站',
          'attributes'    => array(
            'placeholder' => 'http://...'
          ),         
        ),
          
		// 软件性质
        array(
          'id'        => 'i_download_charge',
          'type'      => 'select',
          'title'     => '软件性质',
          'options'   => array(
          'i_charge01' => '免费',
          'i_charge02' => '收费',
          ),
          'default'   => 'i_charge01',
        ),	
          
          // 下载地址
        array(
          'id'         => 'i_download_link',
          'type'       => 'text',
          'title'      => '下载地址',
          'attributes'    => array(
            'placeholder' => 'http://...'
          ),        
        ), 
          
          // 提取码
        array(
          'id'         => 'i_download_code',
          'type'       => 'text',
          'title'      => '提取码',
		  'after'  		  => '<p class="cs-text-muted">留空即无</p>',		  		              
        ),  

      ),
    ),	 
      
    array(
      'name'   => 'aside_section_3',
      'title' => ' 目录',
      'icon'  => 'fa fa-list-ul',      
      'fields' => array(
	  
        // 文章目录
		array(
          'id'    	  => 'i_index',
          'type'      => 'switcher',
          'title'     => '文章目录',
        ),	
                   
      ),
    ),	      
	
  ),
);



// -----------------------------------------
// 作品属性选项                    -
// -----------------------------------------

// 日志文章选项
$options[]    = array(
  'id'        => 'work_options',
  'title'     => '作品选项',
  'post_type' => 'work',
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(

    array(
      'name'   => 'aside_section_1',
      'fields' => array(
	  			

      ),
    ),	
	
  ),
);

CSFramework_Metabox::instance( $options );
