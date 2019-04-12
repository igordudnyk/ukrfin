<?php
/**
 * Edit page form
 *
 * This template can be overridden by copying it to yourtheme/user-registration/myaccount/form-edit-password.php.
 *
 * HOWEVER, on occasion UserRegistration will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.wpeverest.com/user-registration/template-structure/
 * @author  WPEverest
 * @package UserRegistration/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'user_registration_before_edit_page_form' ); ?>

<div class="ur-frontend-form login" id="ur-frontend-form">
	<?php
	global $current_user;


	$bus_categories = get_terms( array(
	    'taxonomy' => 'businesses',
	    'hide_empty' => false,
	) );
	foreach ( $bus_categories as $bus_cat ) { $bus_string .= $bus_cat->term_id.':'.$bus_cat->name.',';	}

	$args = array(
		'post_type' => array ( 'business' ),
		'posts_per_page' => 1,
		'meta_key'		=>	'owner',
		'meta_value'	=>	$current_user->ID
	);
	$current_user_post = get_posts( $args );
	foreach( $current_user_post as $post ){
		echo '<div class="ugc-input-wrapper">
				<label for="ugc-your-logo">Your current logo:</label><br>'.get_the_post_thumbnail($post).
			 '</div>';
		echo '<a href="'.get_permalink($post).'" class="btn btn-primary btn-orange" style="float: right;margin-top: 1px; background-color: #3dbc15; border-color: #3dbc15;display: none;" id="view_page_btn" >View page</a>';

		$my_post_type = $post->post_type;
	    if ($my_post_type == 'business') {
			$post_category = $bus_string;
			$post_taxonomy = 'businesses';

		$tmp = '[fu-upload-form post_id="'.$post->ID.'" title="" suppress_default_fields="true"]
				[input type="file" name="my-logo" description="Upload your new logo"]
				[input type="text" name="post_title" description="Page Title" value="'.$post->post_title.'" class="required"]
				[textarea name="post_content" description="Page Description" value="'.$post->post_content.'"]
				[input type="text" name="funding_goal" description="Funding Goal" value="'.get_field('funding_goal', $post->ID).'"]
				[input type="text" name="funds_raised" description="Funds Raised" value="'.get_field('funds_raised', $post->ID).'"]
				[textarea name="campaign_description" description="Campaign Description" value="'.get_field('campaign_description', $post->ID).'"]
				[input type="url" name="campaign_video" description="Campaign Video: Youtube, Vimeo... etc. video URL" value="'.get_field('campaign_video', $post->ID).'"]
				
				[input type="submit" class="btn btn-primary btn-orange" value="Save changes"][/fu-upload-form]';
		}
		
		echo do_shortcode($tmp);
	}
	?>
</div>

<script type="text/javascript">
    jQuery(document).ready( function($) {
      jQuery("select[id=ugc-input-post_category]").val("<?php echo wp_get_post_terms($post->ID, $post_taxonomy)[0]->term_id ?>");
    });
</script>

<?php do_action( 'user_registration_after_edit_page_form' ); ?>
