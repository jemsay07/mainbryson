<?php

/**
 * @package Main Bryson
 */
namespace Inc\Base;

use Inc\Base\BaseController;
use \Inc\Api\Callbacks\BannerCallbacks;
use \Inc\Api\Callbacks\AdminCallbacks;

class BannerWidgetController extends BaseController
{
	
	public $settings;
	public $callbacks;
	public $subpages = array();
	public $custom_post_types = array();
	public $taxonomies = array();
	public $feature_groups = array();

	public function register(){

		if ( ! $this->activated('banner_manager') ) return;

		$banner_callbacks = new BannerCallbacks();

		$banner_callbacks->register();

		$this->storeCustomPostTypes();

		$this->storeCustomTaxonomies();

		$this->storeFeatureGroups();

		//if ( ! empty( $this->custom_post_types ) ) {
		add_action( 'init', array( $this, 'registerBanner' ) );
		//}
		add_action( 'add_meta_boxes', array( $this, 'registerAddMetaBox') );
		add_action( 'save_post', array( $this, 'saveMetaBox') );

		//register taxonomy
		add_action( 'init', array( $this, 'registerCustomTaxonomy' ) );

	}

	public function storeCustomPostTypes(){
		$this->custom_post_types[] = array(
			'post_type'             => 'mb_banner',
			'name'                  => __( 'Banner', 'main_bryson_plugin' ),
			'singular_name'         => __( 'Banner', 'main_bryson_plugin' ),
			'add_new'               => __( 'Add New Banner', 'main_bryson_plugin' ),
			'add_new_item' 			=> __( 'Add New Banner', 'main_bryson_plugin' ),
			'edit_item' 			=> __( 'Edit Banner', 'main_bryson_plugin' ),
			'new_item'				=> __( 'Add New Banner', 'main_bryson_plugin' ),
			'view_item' 			=> __( 'View Banner', 'main_bryson_plugin' ),
			'search_items' 			=> __( 'Search Banner' , 'main_bryson_plugin'),
			'not_found' 			=> __( 'No banner found', 'main_bryson_plugin' ),
			'not_found_in_trash' 	=> __( 'No banner found in trash', 'main_bryson_plugin' ),
			'public' 				=> false,
			'show_ui' 				=> true,
			'show_in_nav_menus' 	=> false,
			'show_tagcloud'     	=> false,
			'hierarchical' 			=> false,
			'query_var'         	=> false,
			'rewrite'           	=> false,
			'menu_position' 		=> 20,
			'supports' 				=> array('title'),
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> true,
			'has_archive' 			=> false,
			'menu_icon' 			=> 'dashicons-images-alt',
		);
	}

	public function registerBanner(){
		$options = get_option('mb_banner') ?: array();
		foreach ( $this->custom_post_types as $post_type ) {

			register_post_type( $post_type['post_type'], 
				array(
					'labels' => array(
						'name' 					=> $post_type['name'],
						'singular_name' 		=> $post_type['singular_name'],
						'add_new' 				=> $post_type['add_new'],
						'add_new_item' 			=> $post_type['add_new_item'],
						'edit_item' 			=> $post_type['edit_item'],
						'new_item' 				=> $post_type['new_item'],
						'view_item' 			=> $post_type['view_item'],
						'search_items' 			=> $post_type['search_items'],
						'not_found' 			=> $post_type['not_found'],
						'not_found_in_trash' 	=> $post_type['not_found_in_trash']
					),
					'public' 					=> $post_type['public'],
					'show_ui' 					=> $post_type['show_ui'],
					'show_in_nav_menus' 		=> $post_type['show_in_nav_menus'],
					'show_tagcloud'     		=> $post_type['show_tagcloud'],
					'hierarchical' 				=> $post_type['hierarchical'],
					'query_var'         		=> $post_type['query_var'],
					'rewrite'           		=> $post_type['rewrite'],
					'menu_position' 			=> $post_type['rewrite'],
					'supports' 					=> $post_type['supports'],
					'publicly_queryable' 		=> $post_type['publicly_queryable'],  // you should be able to query it
					'exclude_from_search' 		=> $post_type['exclude_from_search'],  // you should exclude it from search results
					'has_archive' 				=> $post_type['has_archive'],  // it shouldn't have archive menu_icon
					'menu_icon' 				=> $post_type['menu_icon'],  // it shouldn't have archive page
				)
			);
		}
	}

	/**
	 * Register the Custom Meta Box
	 *--------------------------------*/
	public function registerAddMetaBox(){
		
		add_meta_box( 'mb_meta_attr', 'Banner Attributes', array($this, 'mbRenderAttr'), 'mb_banner', 'normal', 'high');
		add_meta_box( 'mb_meta_box_sections','Banner Details',array($this, 'mbRenderBox'),'mb_banner','normal','high');
	}

	/**
	 * Render the Custom Meta Box For Add Attr
	 *-----------------------------------------*/

	 public function mbRenderAttr( $post ){
			 wp_nonce_field( 'mb_banner_sections', 'mb_banner_sections_nonce' );
			 $data = get_post_meta( $post->ID, '_mb_banner_key' ,true );
			 $mb_type = isset( $data['mb_type'] ) ? $data['mb_type'] : '';
			 $mb_layout = isset( $data['mb_layout'] ) ? $data['mb_layout'] : ''; ?>
			<div class="meta-container">
				<p class="meta-attr-title">Types</p>
				<p>
					<input type="radio" name="mb_type" id="mb_type_rich" class="widefat mb_rl" value="mb_type_rich" <?php echo ( $mb_type === 'mb_type_rich' ) ? 'checked' : ''; ?> >
					<label for="mb_type_rich" class="meta-attr-label">Rich Content</label>
					<span class="meta-description">The full content editor from wordpress.</span>
				</p>
				<p>
					<input type="radio" name="mb_type" id="mb_type_url" class="widefat mb_rl" value="mb_type_url" <?php echo ( $mb_type === 'mb_type_url' ) ? 'checked' : ''; ?>>
					<label for="mb_type_url" class="meta-attr-label">Attachment</label>
					<span class="meta-description">Banner that specify the path of url with shortcode.</span>
				</p>
			</div>
			<div class="meta-container">
				<p class="meta-attr-title">Layout</p>
				<p>
					<input type="radio" name="mb_layout" id="mb_attr_full" value="mb_attr_full" <?php echo ( $mb_layout === 'mb_attr_full' ) ? 'checked' : ''; ?> >
					<label for="mb_attr_full" class="meta-attr-label">Full</label>
					<span class="meta-description">Display a full width of the box.</span>
				</p>
				<p>
					<input type="radio" name="mb_layout" id="mb_attr_half" value="mb_attr_half" <?php echo ( $mb_layout === 'mb_attr_half' ) ? 'checked' : ''; ?> >
					<label for="mb_attr_half" class="meta-attr-label">Half</label>
					<span class="meta-description">Display a half width of the box.</span>
				</p>
			</div>
			<?php 
	 }

	 /**
	 * Render the Custom Meta Box
	 *--------------------------------*/
	public function mbRenderBox($post){
		wp_nonce_field( 'mb_banner_sections', 'mb_banner_sections_nonce' );

		$data = get_post_meta( $post->ID, '_mb_banner_key' ,true );

		$title = isset( $data['title'] ) ? $data['title'] : ''; // title
		$alt_text = isset( $data['alt_text'] ) ? $data['alt_text'] : ''; // alt text
		$img = isset( $data['img'] ) ? $data['img'] : ''; // image path
		$link = isset( $data['link'] ) ? $data['link'] : ''; // link url
		$caption = isset( $data['caption'] ) ? $data['caption'] : ''; // image caption
		$desc = isset( $data['desc'] ) ? $data['desc'] : ''; // image description
		$new_tab = isset( $data['new_tab'] ) ? $data['new_tab'] : false; // new tab
		$rel_xfn = isset( $data['rel_xfn'] ) ? $data['rel_xfn'] : false;
		$meta_biography = isset( $data['meta_biography'] ) ? $data['meta_biography'] : ''; // rich content

		$args = array(
		    'wpautop'       => false,
		    'media_buttons' => true,
		    'textarea_name' => 'meta_biography',
		    'textarea_rows' => 10,
		    'teeny'         => true,
		    'drag_drop_upload' => true

		); ?>
		<div id="mb_type_elem_rich">
			<?php wp_editor( $meta_biography, '_mb_banner_key', $args ); ?>
		</div>
		<div id="mb_type_elem_url">
			<div class="meta-container">
				<label class="meta-label" for="mb_banner_title">Title:</label>
				<input type="text" id="mb_banner_title" name="mb_banner_title" value="<?php echo esc_attr( $title ); ?>">
			</div>
			<?php if( ! empty( $img ) ): ?>
				<div class="meta-container">
					<label class="meta-label" for="mb_banner_img">&nbsp;</label>
					<img src="<?php echo $img; ?> ">
				</div>
			<?php endif; ?>
			<div class="meta-container">
				<label class="meta-label" for="mb_banner_img">Image URL:</label>
				<input type="text" name="mb_banner_img" id="mb_banner_img" value="<?php echo esc_attr( $img ); ?>">
			</div>
			<div class="meta-container">
				<label class="meta-label" for="mb_banner_link">Link To:</label>
				<input type="text" id="mb_banner_link" name="mb_banner_link" value="<?php echo esc_attr( $link ); ?>">
			</div>
			<div class="meta-container">
				<label class="meta-label" for="mb_banner_alt_text">Alternative Text:</label>
				<input type="text" id="mb_banner_alt_text" name="mb_banner_alt_text" value="<?php echo esc_attr( $alt_text ); ?>">
			</div>
			<div class="meta-container">
				<label class="meta-label w-50 text-left" for="mb_banner_new_tab">Link Rel (XFN):</label>
				<select name="mb_banner_rel_xfn" id="mb_banner_rel_xfn">
					<option value="" <?php echo ( $rel_xfn == '' ) ? 'selected' : ''; ?>>Dofollow</option>
					<option value="nofollow" <?php echo ( $rel_xfn == 'nofollow' ) ? 'selected' : ''; ?>>Nofollow</option>
				</select>
			</div>
			<div class="meta-container">
				<label class="meta-label w-50 text-left" for="mb_banner_new_tab">Open New Tab:</label>
				<input type="checkbox" id="mb_banner_new_tab" name="mb_banner_new_tab" value="1" <?php echo $new_tab ? 'checked':''; ?> >
			</div>
			<div class="meta-container meta-collapse">
				<div class="meta-collapse-header <?php echo ( ! empty( $caption ) || ! empty( $desc ) ) ? 'active' : ''; ?>">
					<p>Sample</p>
				</div>
				<div id="meta-collapse-body">
					<div class="meta-container">
						<label class="meta-label" for="mb_banner_cap">Caption:</label>
						<input type="text" id="mb_banner_cap" name="mb_banner_cap" value="<?php echo esc_attr( $caption ); ?>">
					</div>
					<div class="meta-container">
						<label class="meta-label" for="mb_banner_cap">Description:</label>
						<textarea name="mb_banner_desc" id="mb_banner_desc" cols="10" rows="10"><?php echo esc_html( $desc ); ?></textarea>
					</div>
				</div>
			</div>
		</div>
	<?php }

	/**
	 * Save the data from CMB
	 *--------------------------------*/
	public function saveMetaBox( $post_id ){

		//$nonce = $_POST['mb_banner_sections_nonce'];

		// if our nonce isn't there, or we can't verify it, bail
		if ( ! isset( $_POST['mb_banner_sections_nonce'] ) || ! wp_verify_nonce( $_POST['mb_banner_sections_nonce'], 'mb_banner_sections' )) return $post_id;

		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;


		// if our current user can't edit this post, bail
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$data = array(
			'mb_type' => sanitize_text_field( $_POST['mb_type'] ) ,
			'mb_layout' => sanitize_text_field( $_POST['mb_layout'] ) ,
			'title' => sanitize_text_field( $_POST['mb_banner_title'] ),
			'alt_text' => sanitize_text_field( $_POST['mb_banner_alt_text'] ),
			'img' =>  isset( $_POST['mb_banner_img'] ) ? strip_tags( $_POST['mb_banner_img'] )  : '',
			'link' => isset( $_POST['mb_banner_link'] ) ? esc_url( $_POST['mb_banner_link'] )  : '',
			'caption' => isset( $_POST['mb_banner_cap'] ) ? esc_attr( $_POST['mb_banner_cap'] )  : '',
			'desc' => isset( $_POST['mb_banner_desc'] ) ? esc_html( $_POST['mb_banner_desc'] )  : '',
			'new_tab' => isset( $_POST['mb_banner_new_tab'] ) ? 1 : 0,
			'rel_xfn' => isset( $_POST['mb_banner_rel_xfn'] ) ? 'nofollow' : '',
			'meta_biography' => isset( $_POST['meta_biography'] ) ?  $_POST['meta_biography']   : '',
		);
		/* var_dump($data);
		die; */
		update_post_meta( $post_id, '_mb_banner_key', $data );
	}

	public function storeCustomTaxonomies(){

		$labels = array(
			'name' 						 => _x( 'Sections', 'taxonomy general name', 'main_bryson_plugin' ),
			'singular_name'				 => _x( 'Section', 'taxonomy singular name', 'main_bryson_plugin' ),
			'search_items'				 =>  __( 'Search Sections', 'main_bryson_plugin' ),
			'popular_items'				 => __( 'Popular Sections', 'main_bryson_plugin' ),
			'all_items'					 => __( 'All Sections', 'main_bryson_plugin' ),
			'parent_item'				 => null,
			'parent_item_colon'			 => null,
			'edit_item'					 => __( 'Edit Section', 'main_bryson_plugin' ),
			'update_item'				 => __( 'Update Section', 'main_bryson_plugin' ),
			'add_new_item'				 => __( 'Add New Section', 'main_bryson_plugin' ),
			'new_item_name'				 => __( 'New Section Name', 'main_bryson_plugin' ),
			'separate_items_with_commas' => __( 'Separate sections with commas', 'main_bryson_plugin' ),
			'add_or_remove_items'		 => __( 'Add or remove section', 'main_bryson_plugin' ),
			'menu_name'					 => __( 'Sections', 'main_bryson_plugin' ),
		);

		$this->taxonomies = array(
			'hierarchical'               => true,
			'public'               		 => false,
			'labels'                     => $labels,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'update_count_callback'      => '_update_post_term_count',
			'query_var'                  => true,
			'rewrite'          			 => array( 'slug' => 'section' ),
		);
	}

	public function registerCustomTaxonomy(){
		register_taxonomy( 'section', 'mb_banner', $this->taxonomies );
	}

	public function storeFeatureGroups(){
		 $this->feature_groups = array(
		 	'full' => __( 'Full Layout', 'main_bryson_plugin' ),
		 	'half' => __( 'Half Layout', 'main_bryson_plugin' ),
		 );
	}
}