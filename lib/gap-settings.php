<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
	/* Plugin custom post type creation for slider */
	add_action( 'init', 'gap_custom_post_type' );
	
	// add custom post type with all terms related to slider only
	function gap_custom_post_type(){
		$labels = array(
		'name'               => _x( 'Guest Authors', 'post type general name', 'guest-authors' ),
		'singular_name'      => _x( 'Guest Author', 'post type singular name', 'guest-author' ),
		'menu_name'          => _x( 'Guest Author', 'admin menu', 'post-type-slider' ),
		'name_admin_bar'     => _x( 'Guest Author', 'add new on admin bar', 'guest-authors' ),
		'add_new_item'       => __( 'Add New Author', 'guest-authors' ),
		'new_item'           => __( 'New Author', 'guest-authors' ),
		'edit_item'          => __( 'Edit Author', 'guest-authors' ),
		'view_item'          => __( 'View Author', 'guest-authors' ),
		'all_items'          => __( 'All Authors', 'guest-authors' ),
		'search_items'       => __( 'Search Author', 'guest-authors' ),
		'parent_item_colon'  => __( 'Parent Author:', 'guest-authors' ),
		'not_found'          => __( 'No Author found.', 'guest-authors' ),
		'not_found_in_trash' => __( 'No Author found in Trash.', 'guest-authors' )
		);
		
		$args1 = array(
		'public' => true,
		'label'  => 'Guest Authors',
		'labels' => $labels,
		'supports' => array('title')
		);
		register_post_type('guest_authors', $args1 );
		
		// removing content editor
		remove_post_type_support( 'guest_authors', 'editor' );
	}
	
	// Adding custom boxes
	add_action( 'add_meta_boxes', 'gap_custom_fieldsservices' );
	function gap_custom_fieldsservices() {
		add_meta_box(
		'gap_author_details', // $id
		'Author Details', // $title
		'gap_author_details', // $callback
		'guest_authors', // post type
		'normal', // $context
		'high' // $priority
		);
		add_meta_box(
		'gap_author_sm_details', // $id
		'Social Media Details', // $title
		'gap_author_sm', // $callback
		'guest_authors', // post type
		'normal', // $context
		'high' // $priority
		);
	}
	function gap_author_details(){
		global $post;
		wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	?>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="blogname">Name Of Author</label></th>
				<td>
					<div class="formfields">
						<input name="gap_author_name" type="text" value="<?php if(!empty($gap_author_name= get_post_meta($post->ID, 'gap_author_name', true))){ echo $gap_author_name; } ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="gap_author_email">Email</label></th>
				<td>
					<div class="formfields">
						<input name="gap_author_email" type="text" value="<?php if(!empty($gap_author_email= get_post_meta($post->ID, 'gap_author_email', true))){ echo $gap_author_email; } ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="blogname">Designation</label></th>
				<td>
					<div class="formfields">
						<input name="gap_author_design" type="text" value="<?php if(!empty($gap_author_design= get_post_meta($post->ID, 'gap_author_design', true))){ echo $gap_author_design; } ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="gap_author_organization">Organization</label></th>
				<td>
					<div class="formfields">
						<input name="gap_author_organization" type="text" value="<?php if(!empty($gap_author_organization= get_post_meta($post->ID, 'gap_author_organization', true))){ echo $gap_author_organization; } ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="gap_author_organization">Biographical Info</label></th>
				<td>
					<div class="formfields">
						<textarea name="gap_author_info" ><?php if(!empty($gap_author_info= get_post_meta($post->ID, 'gap_author_info', true))){ echo $gap_author_info; } ?> </textarea>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="gap_author_phone">Phone</label></th>
				<td>
					<div class="formfields">
						<input name="gap_author_phone" type="text" value="<?php if(!empty($gap_author_phone= get_post_meta($post->ID, 'gap_author_phone', true))){ echo $gap_author_phone; } ?>" />
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="gap_author_address">Address</label></th>
				<td>
					<div class="formfields">
						<textarea name="gap_author_address" ><?php if(!empty($gap_author_address= get_post_meta($post->ID, 'gap_author_address', true))){ echo $gap_author_address; } ?> </textarea>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row" class="gap-table-form-row"><label for="gap_author_address">Profile Picture</label></th>
				<td>
				<?php 
				$gap_profile_pic = get_post_meta($post->ID, 'gap_profile_pic', true);  
				wp_editor( $gap_profile_pic, 'gap_profile_pic', array( 'textarea_name' => 'gap_profile_pic', 'textarea_rows' =>8,'quicktags' => false,'tinymce' => array('paste_as_text' => true,
					'paste_auto_cleanup_on_paste'   => false,
					'paste_remove_spans'            => false,
					'paste_remove_styles'           => false,
					'paste_remove_styles_if_webkit' => false,
					'paste_strip_class_attributes'  => false,
					'toolbar1'                      => 'image media',
					'toolbar2'                      => '',
					'contenteditable' => 'false'
					))); 
				?>  
				</td>
			</td>
		</tr>
		
	</tbody>
</table>
<?php
}
function gap_author_sm(){
	global $post;
?>
<table class="form-table" role="presentation">
	<tbody>
		<tr>
			<th scope="row" class="gap-table-form-row"><label for="facebook">Facebook</label></th>
			<td>
				<div class="formfields">
					<input name="gap_facebook" type="text" value="<?php if(!empty($gap_facebook= get_post_meta($post->ID, 'gap_facebook', true))){ echo $gap_facebook; } ?>" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" class="gap-table-form-row"><label for="twitter">Twitter</label></th>
			<td>
				<div class="formfields">
					<input name="gap_twitter" type="text" value="<?php if(!empty($gap_twitter= get_post_meta($post->ID, 'gap_twitter', true))){ echo $gap_twitter; } ?>" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" class="gap-table-form-row"><label for="gap_linkedin">LinkedIn</label></th>
			<td>
				<div class="formfields">
					<input name="gap_linkedin" type="text" value="<?php if(!empty($gap_linkedin= get_post_meta($post->ID, 'gap_linkedin', true))){ echo $gap_linkedin; } ?>" />
				</div>
			</td>
		</tr>
		<tr>
			<th scope="row" class="gap-table-form-row"><label for="gap_instagram">Instagram</label></th>
			<td>
				<div class="formfields">
					<input name="gap_instagram" type="text" value="<?php if(!empty($gap_instagram= get_post_meta($post->ID, 'gap_instagram', true))){ echo $gap_instagram; } ?>" />
				</div>
			</td>
		</tr>
		
	</tbody>
</table>
<?php
}
// save post type post_type_slider
add_action( 'save_post_guest_authors', 'gap_save_custom_field_guest_authors' );
function gap_save_custom_field_guest_authors( $post_id ) {
	if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
	return $post_id;
	
	// author name
	$gap_author_name = sanitize_text_field($_POST['gap_author_name']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_author_name' ) ) {
		update_post_meta(
		$post_id,
		'gap_author_name',
		$gap_author_name
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_author_name',
		$gap_author_name
		);
	}
	// author designation 
	$gap_author_design = sanitize_text_field($_POST['gap_author_design']); // sanitize data
	if (metadata_exists( 'post', $post_id, 'gap_author_design' ) ) {
		update_post_meta(
		$post_id,
		'gap_author_design',
		$gap_author_design
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_author_design',
		$gap_author_design
		);
	}
	// gap_author_organization
	$gap_author_organization = sanitize_text_field($_POST['gap_author_organization']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_author_organization' ) ) {
		update_post_meta(
		$post_id,
		'gap_author_organization',
		$gap_author_organization
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_author_organization',
		$gap_author_organization
		);
	}
	// gap_author_info
	$gap_author_info = sanitize_text_field($_POST['gap_author_info']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_author_info' ) ) {
		update_post_meta(
		$post_id,
		'gap_author_info',
		$gap_author_info
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_author_info',
		$gap_author_info
		);
	}
	// gap_author_email
	$gap_author_email = sanitize_text_field($_POST['gap_author_email']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_author_email' ) ) {
		update_post_meta(
		$post_id,
		'gap_author_email',
		$gap_author_email
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_author_email',
		$gap_author_email
		);
	}
	// gap_author_phone
	$gap_author_phone = sanitize_text_field($_POST['gap_author_phone']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_author_phone' ) ) {
		update_post_meta(
		$post_id,
		'gap_author_phone',
		$gap_author_phone
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_author_phone',
		$gap_author_phone
		);
	}
	// gap_author_address
	$gap_author_address = sanitize_text_field($_POST['gap_author_address']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_author_address' ) ) {
		update_post_meta(
		$post_id,
		'gap_author_address',
		$gap_author_address
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_author_address',
		$gap_author_address
		);
	}
	// gap_facebook
	$gap_facebook = sanitize_text_field($_POST['gap_facebook']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_facebook' ) ) {
		update_post_meta(
		$post_id,
		'gap_facebook',
		$gap_facebook
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_facebook',
		$gap_facebook
		);
	}
	// gap_twitter
	$gap_twitter = sanitize_text_field($_POST['gap_twitter']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_twitter' ) ) {
		update_post_meta(
		$post_id,
		'gap_twitter',
		$gap_twitter
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_twitter',
		$gap_twitter
		);
	}
	
	//gap_linkedin
	$gap_linkedin = sanitize_text_field($_POST['gap_linkedin']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_linkedin' ) ) {
		update_post_meta(
		$post_id,
		'gap_linkedin',
		$gap_linkedin
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_linkedin',
		$gap_linkedin
		);
	}
	// gap_instagram
	$gap_instagram = sanitize_text_field($_POST['gap_instagram']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_instagram' ) ) {
		update_post_meta(
		$post_id,
		'gap_instagram',
		$gap_instagram
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_instagram',
		$gap_instagram
		);
	}
	// profile_pic
	
	$gap_profile_pic = wp_kses_post($_POST['gap_profile_pic']); // sanitize data
	if ( metadata_exists( 'post', $post_id, 'gap_profile_pic' ) ) {
		update_post_meta(
		$post_id,
		'gap_profile_pic',
		$gap_profile_pic
		);
		}else {
		add_post_meta(
		$post_id,
		'gap_profile_pic',
		$gap_profile_pic
		);
	}
}