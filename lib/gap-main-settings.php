<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly?>
<div class="wrap">
	<h1>Guest Author Settings</h1>
	<?php 
		if(isset($_POST['gap_posts_submit'])){
		
			if (!isset($_POST['gap_settings_non'])) { 
				die('<br><br>NO CSRF For you'); 
			}
			if (!wp_verify_nonce($_POST['gap_settings_non'],'gap_settings_non_num')) 
			{
			die('<br><br>NO CSRF For you'); 
			}
			// saving value in option variable into option table
			$gap_display_box_title = sanitize_text_field($_POST['gap_display_box_title']);
			$gap_after_contents = sanitize_text_field($_POST['gap_after_contents']);
			
			// sanitizing $_POST['gap_post_type']
			$gap_post_type_temp = array();
			if(is_array($_POST['gap_post_type'])){
			$gap_post_type = $_POST['gap_post_type'];
				foreach($gap_post_type as $key => $typevalue){
					$gap_post_type_temp[] = sanitize_text_field( $typevalue );
				}
				$gap_post_type = $gap_post_type_temp;
			}
			if(!empty($gap_post_type) && is_array($gap_post_type)) {  
				$gap_post_type = implode(",",$gap_post_type);
			}else $gap_post_type ='';  // if empty
			$gap_post_type = sanitize_text_field($gap_post_type); // sanitize data
			update_option('gap_posts_types',$gap_post_type);
			
			// display box title
			
			$option_name = 'gap_display_box_title' ;
			$new_value = $gap_display_box_title;
			if ( get_option( $option_name ) !== false ) {
				// The option already exists, so update it.
				update_option( $option_name, $new_value );
			} else {
				// The option hasn't been created yet, so add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( $option_name, $new_value, $deprecated, $autoload );
			}
			
			// save automatic show option
			
			$option_name = 'gap_after_contents' ;
			$new_value = $gap_after_contents;
			if ( get_option( $option_name ) !== false ) {
				// The option already exists, so update it.
				update_option( $option_name, $new_value );
			} else {
				// The option hasn't been created yet, so add it with $autoload set to 'no'.
				$deprecated = null;
				$autoload = 'no';
				add_option( $option_name, $new_value, $deprecated, $autoload );
			}
			
			
			
			// Success message	
			echo sprintf(__( '<div id="setting-error-page_for_privacy_policy" class="updated settings-error notice is-dismissible">  
			<p><strong>Posts updated successfully.</strong></p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>' ));
		}
	?>
	<h2>Select post type in which Guest author should be enabled:</h2>
	<?php 
		// Getting all public post type in wordpress
		$args       = array(
		'public' => true,
		);
		$post_types = get_post_types( $args, 'objects' );
		$selected =array();
		
		// Selected posts variables
		if(get_option('gap_posts_types')){
			$selected = get_option('gap_posts_types');
			$selected = explode(",",$selected);
		}


	?>
	<form action="" name="gap_posts_form" method="post">
		<div>
			<?php foreach ( $post_types as $post_type_obj ):
				// Exclude Media type
				if( $post_type_obj->name == "guest_authors" || $post_type_obj->name == "media" || $post_type_obj->name == "attachment" || $post_type_obj->name == "revision"){
					continue;
				}
				$labels = get_post_type_labels( $post_type_obj );
			?>
			<p>
				<input type="checkbox" id="<?php echo esc_attr( $post_type_obj->name ); ?>" value="<?php echo esc_attr( $post_type_obj->name ); ?>" name="gap_post_type[]" <?php if(in_array($post_type_obj->name,$selected)) echo "checked"; ?>>
				<label for="<?php echo esc_attr( $post_type_obj->name ); ?>"><?php echo esc_html( $labels->name ); ?></label>
			</p>
			<input name="gap_settings_non" type="hidden" value="<?php echo wp_create_nonce('gap_settings_non_num'); ?>" />
			
			<?php endforeach; ?>
		</div> 
		<div> 
		<?php $gap_display_box_title = get_option('gap_display_box_title'); ?>
		<label>Author Box Title : </label>  <input name="gap_display_box_title" placeholder="Blog Author" value="<?php if($gap_display_box_title) echo $gap_display_box_title; ?>" type="text" />
		</div> 
		<div> 
		<br />
		<?php $gap_after_contents = get_option('gap_after_contents'); ?>
		<label for="gap_after_contents">Show author box after every posts contents? </label>
		<input type="checkbox" id="gap_after_contents" value="true" name="gap_after_contents" <?php if($gap_after_contents == "true") echo "checked"; ?>>
		<p>(display author box after the_content(); ) Or you have use the shortcode [guest_author] to show the author box.</p>
		</div>
		<?php echo sprintf(__( '<p class="submit"><input type="submit" name="gap_posts_submit" id="gap_posts_submit" class="button button-primary" value="Save Changes"></p>')); ?>
	</form>
	<?php 
	echo sprintf(__( 'Go To "Guest Authors" to Add Authors' )); 
		?>
</div> 