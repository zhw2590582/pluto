<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// SHORTCODE GENERATOR OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options       = array();

// -----------------------------------------
// 常用功能                -
// -----------------------------------------
$options[]     = array(
  'title'      => '常用功能',
  'shortcodes' => array(

    // 手风琴
    array(
      'name'          => 'accordion',
      'title'         => '手风琴',
      'view'          => 'clone',
      'clone_id'      => 'accordion_sub',
      'clone_title'   => '添加',
      'fields'        => array(

        array(
          'id'        => 'option',
          'type'      => 'select',
          'title'     => '选项',
          'shortcodes'   => array(
            'value-1' =>  'Value 1',
            'value-2' =>  'Value 2',
            'value-3' =>  'Value 3',
          ),
        ),

      ),
      'clone_fields'  => array(

        array(
          'id'        => 'title',
          'type'      => 'text',
          'title'     => '标题',
        ),

        array(
          'id'        => 'content',
          'type'      => 'textarea',
          'title'     => '内容',
        ),
      )
    ),	
	

  ),
);

CSFramework_Shortcode_Manager::instance( $options );
