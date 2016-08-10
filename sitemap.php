<?php 
ob_start();
if (! defined( 'ABSPATH' )) exit;
if(str_replace('-', '', get_option('gmt_offset'))<10) { $tempo = '-0'.str_replace('-', '', get_option('gmt_offset')); } else { $tempo = get_option('gmt_offset'); }
if(strlen($tempo)==3) { $tempo = $tempo.':00'; }
  $postsForSitemap = get_posts(array(
'numberposts' => -1,
'orderby' => 'modified',
'post_type'  => array('post','page','property','product'),
'order'=> 'DESC'));
$sitemap .= '<?xml version="1.0" encoding="UTF-8"?>';
$sitemap .= "\n".'<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
      http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'."\n";
$sitemap .=  "<!-- created Sitemap with One Click xml Sitemap. Generator https://wordpress.org/plugins/one-click-xml-sitemap/ By www.studio45.in -->"; 
$sitemap .= "\t".'<url>'."\n".
  "\t\t".'<loc>'. esc_url( home_url( '/' ) ) .'</loc>'.
  "\n\t\t".'<lastmod>' . date( "Y-m-d\TH:i:s", current_time( 'timestamp', 0 ) ) . $tempo . '</lastmod>'.
  "\n\t\t".'<changefreq>monthly</changefreq>'.
    "\n\t\t".'<priority>1.0</priority>'.
"\n\t".'</url>'."\n";
foreach($postsForSitemap as $post) {
setup_postdata($post);
$postdate = explode(" ", $post->post_modified);
$sitemap .= "\t".'<url>'."\n".
  "\t\t".'<loc>'. get_permalink($post->ID) .'</loc>'.
  "\n\t\t".'<lastmod>'. $postdate[0] . 'T' . $postdate[1] . $tempo . '</lastmod>'.
  "\n\t\t".'<changefreq>Weekly</changefreq>'.
    "\n\t\t".'<priority>0.5</priority>'.
"\n\t".'</url>'."\n";
  }
$sitemap .= '</urlset>';
$fp = fopen(ABSPATH . "sitemap.xml", 'w');
fwrite($fp, $sitemap);
fclose($fp);