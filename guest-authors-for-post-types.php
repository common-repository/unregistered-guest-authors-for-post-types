<?php
/*
Plugin Name: Unregistered (Guest) Authors for post types
Plugin URI: https://www.primisdigital.com/wordpress-plugins/
Description: Lets you add any unregistered user as post author.
Version:     1.0
Author:      Primis Digital
Author URI:  https://www.primisdigital.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// Language Directory
load_plugin_textdomain('guest-authors-posts', false, dirname(plugin_basename(__FILE__)) . '/languages/');

// Some constant defintion
define("GAP_DIR", plugin_dir_path(__FILE__), FALSE);
define("GAP_DIR_URL", plugin_dir_url(__FILE__), FALSE);

// image url constant 
define("GAP_IMG_DIR", GAP_DIR. 'assets\img\\' );
define("GAP_IMG_URL", GAP_DIR_URL. 'assets/img/' ); 

// js url constant 
define("GAP_JS_DIR", GAP_DIR. 'assets\js\\' );
define("GAP_JS_URL", GAP_DIR_URL. 'assets/js/' ); 

// css url constant 
define("GAP_CSS_DIR", GAP_DIR. 'assets\css\\' );
define("GAP_CSS_URL", GAP_DIR_URL. 'assets/css/' ); 

//Plugin Activation code
register_activation_hook(__FILE__, 'gap_activation');
function gap_activation()
{
}
// adding style sheet in admin area
add_action('admin_enqueue_scripts', function()
{
wp_enqueue_style( 'style', GAP_CSS_URL.'/style.css');
});
// adding style sheet to front end
add_action('wp_enqueue_scripts', function()
{
wp_enqueue_style( 'gap_style', GAP_CSS_URL.'/gap_style.css');
wp_enqueue_style( 'font-awesome', GAP_CSS_URL.'/fontawesome.css');
});
// Register Deactivation Hook here
register_deactivation_hook(__FILE__, 'gap_deactivation');
function gap_deactivation()
{
}
// Register Uninstall Hook here
register_uninstall_hook(__FILE__, 'gap_uninstall');

function gap_uninstall()
{
}
// Plugin post type loading : Post Type Slider
include("lib/gap-settings.php");
include("lib/gap-menu.php");

// Adding meta box for Guest Authors
add_action('add_meta_boxes', 'gap_authors_box');
function gap_authors_box()
{
wp_nonce_field( 'theme_meta_box_nonce', 'meta_box_nonce' );

if (get_option('gap_posts_types')) {
	$posts_available = get_option('gap_posts_types');
	if(!empty($posts_available)){
		$posts_available = explode(",", $posts_available);
	}
}
if(!empty($posts_available)){
	add_meta_box('guest_author', __('Guest Author', 'text-domain'), 'gap_author_lists', $posts_available, 'side', 'high'); // sfv_upload function 
}
}
// callback function of meta box
function gap_author_lists($posts){
	$args = array(
	  'numberposts' => -1,
	  'post_type'   => 'guest_authors'
	);
	wp_nonce_field( 'gap_myplugin_inner_custom_box', 'gap_myplugin_inner_custom_box_nonce' );
	$meta_key = 'gap_post_author';
	// get the meta value of gap_post_author
	$meta_value = get_post_meta($posts->ID, $meta_key, true);
	?>
	<select name="gap_post_author"> 
	<option value="" >Select Author</option>
		<?php 
			$pages = get_posts($args); 
			foreach ( $pages as $page ) {
			$selected ='';
			if(!empty($meta_value)){
			$pageid=$page->ID;
			if($meta_value == $pageid){
				$selected = 'selected';
			}
			}
			$option = '<option value="' . $page->ID . '" '.$selected.'>'.$page->post_title.'</option>';
			echo $option;
			}
		?>
	</select>
	<?php 
}

// Saving post by updating , "gap_post_author" meta key
add_action('save_post', 'gap_author_save', 10, 1);
function gap_author_save($post_id)
{
    if( !current_user_can( 'edit_post' ) ) return;
	
	 // Check if our nonce is set.
        if ( ! isset( $_POST['gap_myplugin_inner_custom_box_nonce'] ) ) {
            return $post_id;
        }
 
        $nonce = $_POST['gap_myplugin_inner_custom_box_nonce'];
 
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'gap_myplugin_inner_custom_box' ) ) {
            return $post_id;
        }
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
	
	
    $meta_key = 'gap_post_author';
	$keyvalue = sanitize_text_field($_POST[$meta_key]);
    update_post_meta($post_id, $meta_key,$keyvalue );
    return $post_id;
}
// Automatically add after post contents


// automatically add after post excerpt

$gap_after_contents = get_option('gap_after_contents');
if($gap_after_contents == "true"){
	add_filter( 'the_content', 'gap_after_contents' );
}
function gap_after_contents( $content ) { 
	global $post;
	$type = $post->post_type; // current post type
	$postid = $post->ID;
	if(is_single() || is_page() ) {
	$posts_available = get_option('gap_posts_types');
	if(!empty($posts_available)){
	$posts_available = explode(",", $posts_available);
	// check whether post type checked for display the author box
	if(in_array($type,$posts_available)){
	
	$meta_key = 'gap_post_author';
	// get the meta value of gap_post_author
	$authorid = get_post_meta($post->ID, $meta_key, true);
	if($authorid){
		$authorname = get_post_meta($authorid, 'gap_author_name', true);
		$gap_author_email = get_post_meta($authorid, 'gap_author_email', true);
		$gap_author_design = get_post_meta($authorid, 'gap_author_design', true);
		$gap_author_organization = get_post_meta($authorid, 'gap_author_organization', true);
		$gap_author_info = get_post_meta($authorid, 'gap_author_info', true);
		$gap_author_phone = get_post_meta($authorid, 'gap_author_phone', true);
		$gap_author_address = get_post_meta($authorid, 'gap_author_address', true);
		$gap_facebook = get_post_meta($authorid, 'gap_facebook', true);
		$gap_twitter = get_post_meta($authorid, 'gap_twitter', true);
		$gap_linkedin = get_post_meta($authorid, 'gap_linkedin', true);
		$gap_instagram = get_post_meta($authorid, 'gap_instagram', true);
		$gap_profile_pic = get_post_meta($authorid, 'gap_profile_pic', true);
		$gap_display_box_title ="Blog Author";
		if($authorname){
		$gap_display_box_title = get_option('gap_display_box_title'); 
		$authordetails ='<span class="gap_title">'.$gap_display_box_title.'</span>';
		$authordetails .='<div class="author_info_details">';
		$authordetails .='<span class="gap_author_name">'.$authorname.'</span>';
		}
		if($gap_author_email){
		$authordetails .='<span class="gap_author_email"><a href="mailto:'.$gap_author_email.'"><i class="fa fa-envelope"></i>'.$gap_author_email.'</a></span>';
		}
		if($gap_author_design){
		$authordetails .='<span class="gap_author_design"> '.$gap_author_design.' </span>';
		}
		if($gap_author_organization){
		$authordetails .='<span class="gap_author_organization"> at '.$gap_author_organization.'</span>';
		}  
		if($gap_author_info){
		$authordetails .='<span class="gap_author_info">'.$gap_author_info.'</span>';
		}
		if($gap_author_phone){
		$authordetails .='<span class="gap_author_phone"><a href="tel:'.$gap_author_phone.'"><i class="fa fa-phone"></i>'.$gap_author_phone.'</a></span>';
		}
		if($gap_author_address){
		$authordetails .='<span class="gap_author_address"><i class="fa fa-map-marker"></i>'.$gap_author_address.'</span>';
		}
		if($gap_facebook){
		$authordetails .='<a href="'.$gap_facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
		}
		if($gap_twitter){
		$authordetails .='<a href="'.$gap_twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
		}
		if($gap_linkedin){
		$authordetails .='<a href="'.$gap_linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></span></a>';
		}
		if($gap_instagram){
		$authordetails .='<a href="'.$gap_instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
		}
		if($authorname){
		$authordetails .='</div>';
		}
		if($gap_profile_pic){
		$authordetails .='<div class="gap_author_photo">'.$gap_profile_pic.'</div>';
		}
		$content .= '<div class="gap_post_author_details">'.$authordetails.'</div>';
	}
}
}
}
return $content;
}

// Author displaying shortcode
add_shortcode( 'guest_author', 'gap_shortcodes_func' );
function gap_shortcodes_func() { 
	global $post;
	$type = $post->post_type; // current post type
	$postid = $post->ID;
	$posts_available = get_option('gap_posts_types');
	if(!empty($posts_available)){
	$posts_available = explode(",", $posts_available);
	// check whether post type checked for display the author box
	if(in_array($type,$posts_available)){
	
	$meta_key = 'gap_post_author';
	// get the meta value of gap_post_author
	$authorid = get_post_meta($post->ID, $meta_key, true);
	if($authorid){
		$authorname = get_post_meta($authorid, 'gap_author_name', true);
		$gap_author_email = get_post_meta($authorid, 'gap_author_email', true);
		$gap_author_design = get_post_meta($authorid, 'gap_author_design', true);
		$gap_author_organization = get_post_meta($authorid, 'gap_author_organization', true);
		$gap_author_info = get_post_meta($authorid, 'gap_author_info', true);
		$gap_author_phone = get_post_meta($authorid, 'gap_author_phone', true);
		$gap_author_address = get_post_meta($authorid, 'gap_author_address', true);
		$gap_facebook = get_post_meta($authorid, 'gap_facebook', true);
		$gap_twitter = get_post_meta($authorid, 'gap_twitter', true);
		$gap_linkedin = get_post_meta($authorid, 'gap_linkedin', true);
		$gap_instagram = get_post_meta($authorid, 'gap_instagram', true);
		$gap_profile_pic = get_post_meta($authorid, 'gap_profile_pic', true);
		$gap_display_box_title ="Blog Author";
		if($authorname){
		$gap_display_box_title = get_option('gap_display_box_title'); 
		$authordetails ='<span class="gap_title">'.$gap_display_box_title.'</span>';
		$authordetails .='<div class="author_info_details">';
		$authordetails .='<span class="gap_author_name">'.$authorname.'</span>';
		}
		if($gap_author_email){
		$authordetails .='<span class="gap_author_email"><a href="mailto:'.$gap_author_email.'"><i class="fa fa-envelope"></i>'.$gap_author_email.'</a></span>';
		}
		if($gap_author_design){
		$authordetails .='<span class="gap_author_design"> '.$gap_author_design.' </span>';
		}
		if($gap_author_organization){
		$authordetails .='<span class="gap_author_organization"> at '.$gap_author_organization.'</span>';
		}  
		if($gap_author_info){
		$authordetails .='<span class="gap_author_info">'.$gap_author_info.'</span>';
		}
		if($gap_author_phone){
		$authordetails .='<span class="gap_author_phone"><a href="tel:'.$gap_author_phone.'"><i class="fa fa-phone"></i>'.$gap_author_phone.'</a></span>';
		}
		if($gap_author_address){
		$authordetails .='<span class="gap_author_address"><i class="fa fa-map-marker"></i>'.$gap_author_address.'</span>';
		}
		if($gap_facebook){
		$authordetails .='<a href="'.$gap_facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
		}
		if($gap_twitter){
		$authordetails .='<a href="'.$gap_twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
		}
		if($gap_linkedin){
		$authordetails .='<a href="'.$gap_linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></span></a>';
		}
		if($gap_instagram){
		$authordetails .='<a href="'.$gap_instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>';
		}
		if($authorname){
		$authordetails .='</div>';
		}
		if($gap_profile_pic){
		$authordetails .='<div class="gap_author_photo">'.$gap_profile_pic.'</div>';
		}
		$contents = '<div class="gap_post_author_details">'.$authordetails.'</div>';
		return __('<div class="gap_shortcodes" id="gap_shortcodes_'.$postid.'" >'.$contents.'</div>'); 
	}
}
}
}
