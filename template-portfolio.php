<?php
function post_type_work() {
register_post_type(
	'work', 
	array( 'public' => true,
		'publicly_queryable' => true,
		'hierarchical' => false,
		'labels'=>array(
			'name' => _x('图集', 'post type general name'),
			'singular_name' => _x('图集', 'post type singular name'),
			'add_new' => _x('添加新图集', '图集'),
			'add_new_item' => __('添加新图集'),
			'edit_item' => __('编辑图集'),
			'new_item' => __('新的图集'),
			'view_item' => __('预览图集'),
			'search_items' => __('搜索图集'),
			'not_found' =>  __('您还没有发布图集'),
			'not_found_in_trash' => __('回收站中没有图集'),
			'parent_item_colon' => ''
			),
		 'show_ui' => true,
		 'menu_position'=>5,
			'supports' => array(
			'title',
			'author', 
			'excerpt',
			'thumbnail',
			'trackbacks',
			'editor', 
			'comments',
			'custom-fields',
			'revisions'	) ,
		'show_in_nav_menus'	=> true ,
		'taxonomies' => array(	
		    'menutype')
			) 
	); 
} 
add_action('init', 'post_type_work');

function create_genre_taxonomy() {
  $labels = array(
		 'name' => _x( '图集分类', 'taxonomy general name' ),
		 'singular_name' => _x( 'genre', 'taxonomy singular name' ),
		 'search_items' =>  __( '搜索分类' ),
		 'all_items' => __( '全部分类' ),
		 'parent_item' => __( '父级分类目录' ),
		 'parent_item_colon' => __( '父级分类目录:' ),
		 'edit_item' => __( '编辑图集分类' ),
		 'update_item' => __( '更新' ),
		 'add_new_item' => __( '添加新图集分类' ),
		 'new_item_name' => __( 'New Genre Name' ),
  ); 
  register_taxonomy('genre',array('work'), array(
         'hierarchical' => true,
         'labels' => $labels,
         'show_ui' => true,
         'query_var' => true,
         'rewrite' => array( 'slug' => 'genre' ),
  ));
}
add_action( 'init', 'create_genre_taxonomy', 0 );
?>