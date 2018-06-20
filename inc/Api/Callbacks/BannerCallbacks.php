<?php
/**
 * This is display the banner widget
 * 
 * @package Main_Bryson
 * @author jem07.say@gmail.com
 */

namespace Inc\Api\Callbacks;

use WP_Widget;
use WP_Query;

class BannerCallbacks extends WP_Widget
{
	public $widget_ID;
	public $widget_name;
	public $widget_option = array();
	public $control_options = array();

	public function __construct(){
		$this->widget_ID = 'bryson_media_widget';
		$this->widget_name = 'Bryson Image Banner';
		$this->control_options = array('classname'=> $this->widget_ID,'description'=> $this->widget_name,'customize_selective_refresh'=> true );
	}
	
	public function register(){
		parent::__construct( $this->widget_ID,$this->widget_name,$this->widget_option,$this->control_options );
		add_action( 'widgets_init', array( $this, 'widgetInit') );
	}

	public function widgetInit(){
		register_widget( $this );
	}

	public function widget($args, $instance){
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		$cat = isset( $instance['cat'] ) ? $instance['cat'] : '' ;
		$banner = new WP_Query( array('posts_per_page' => '5','tax_query' => array(array('taxonomy' => 'section','field' => 'id','terms'=> $cat ) ),'post_type' => 'mb_banner','order' => 'ASC','orderby'=> 'date') );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] .  apply_filters( 'widget_title', $title ) . $args['after_title'];
		}

		if( $banner->have_posts() ): ?>
			<div class="bryson_ads clearfix">
				<?php while( $banner->have_posts() ) : $banner->the_post();
						$custom_fields = get_post_custom( get_the_ID() );;
						$my_custom_field = $custom_fields['_mb_banner_key'];
						foreach ( $my_custom_field as $key => $value ) {
							$sample = unserialize($value);
							$mb_type = $sample['mb_type'];
							$mb_layout = $sample['mb_layout'];
							$title = $sample['title'];
							$alt_text = $sample['alt_text'];
							$img = $sample['img'];
							$link = $sample['link'];
							$caption = $sample['caption'];
							$desc = $sample['desc'];
							$new_tab = $sample['new_tab'];
							$rel_xfn = $sample['rel_xfn'];
							$meta_biography = $sample['meta_biography'];
							
							if($mb_type === 'mb_type_url') :
								$mb_layout = ($mb_layout === 'mb_attr_half') ? 'attr_half' : 'attr_full';
								if ( ! empty($link) ):
									$before_img = '<a href="' . esc_url( do_shortcode( $link ) ) . '" rel="'. $rel_xfn .'" target="' . $new_tab . '">';
									$after_img = '</a>';
								else:
									$before_img = '';
									$after_img = '';
								endif;
								?>
								<div class="ads_col mb_banner mb_<?php echo $mb_layout; ?>">
									<?php echo $before_img; ?>
										<img src="<?php echo esc_attr( $img ); ?>" alt="">
									<?php echo $after_img; ?>
								</div>
								<?php else:
								echo esc_html__( $meta_biography, 'main_bryson_plugin' );
							endif;

						}
						endwhile; ?>
			</div>
		<?php endif;
		echo $args['after_widget'];
	}

	public function form($instance) {
		$instance = wp_parse_args( (array) $instance, array('title'=> '','cat'=> '') );?>
		
		<div class="_admin_widget">
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title</label>
			<input type="text" class="widefat" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" value="<?php echo esc_attr( $instance['title'] );  ?>">
		</div>
		<div class="_admin_widget">
			<label for="<?php echo $this->get_field_id( 'cat' ); ?>" ><?php _e( 'Category 1:','main_bryson_plugin' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>">
				<?php foreach( get_terms(['taxonomy' => 'section','hide_empty' => false]) as $term) { ?>
					<option <?php selected( $instance['cat'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
				<?php } ?>
			</select>
		</div>
		<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['cat'] = $new_instance[ 'cat' ];

		return $instance;

	}
}