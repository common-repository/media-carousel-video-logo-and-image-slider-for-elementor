<?php
namespace WB_MC\MEDIA_CAROUSEL;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
/**
 * Elementor Media Carousel Slider Widget.
 *
 * Main widget that create the Media Carousel widget
 *
 * @since 1.0.0
*/
class WB_MC_WIDGET extends \Elementor\Widget_Base
{

	/**
	 * Get widget name
	 *
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wb-media-carousel';
	}

	/**
	 * Get widget title
	 *
	 * Retrieve the widget title.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html( 'Media Carousel', 'media-carousel-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-media-carousel';
	}

	/**
	 * Retrieve the widget category.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_categories() {
		return [ 'web-builder-element' ];
	}

	public function get_style_depends()
    {
        return [
            'font-awesome-5-all',
            'font-awesome-4-shim',
        ];
    }

    public function get_script_depends()
    {
        return [
            'font-awesome-4-shim'
        ];
    }

	/**
	 * Retrieve the widget category.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	protected function _register_controls() {

	

		$this->start_controls_section(
			'item_configuration',
			[
				'label' => esc_html( 'Item Configurtion', 'media-carousel-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => esc_html__( 'Effect : ', 'media-carousel-for-elementor' ),
				'placeholder' => esc_html__( 'Choose Effect from Here', 'media-carousel-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
					'carousel'  => esc_html__( 'Carousel', 'media-carousel-for-elementor' ),
					// 'fade'  => esc_html__( 'Fade', 'media-carousel-for-elementor' ),
					// 'cube'  => esc_html__( 'Cube', 'media-carousel-for-elementor' ),
					// 'coverflow'  => esc_html__( 'Coverflow', 'media-carousel-for-elementor' ),
					// 'flip'  => esc_html__( 'Flip', 'media-carousel-for-elementor' ),
				],
				'description' => __('There is <strong><a href="'.WB_MC_PRO_LINK.'" target="_blank" >Another Effect</a></strong> on the <a href="'.WB_MC_PRO_LINK.'" target="_blank" >Pro</a> Version. We have developed more Effects continiously. <a style="font-size: 12px; padding: 0 10px" href="'.WB_MC_PRO_LINK.'" target="_blank" >Buy Pro</a>'),
			]
		);

		$this->add_control(
			'more_feature_one',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.WB_MC_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slides_items_section',
			[
				'label' => esc_html( 'Slides Item', 'media-carousel-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'type',
			[
				'type' => Controls_Manager::CHOOSE,
				'label' => __( 'Type', 'elementor-pro' ),
				'default' => 'image',
				'options' => [
					'image' => [
						'title' => __( 'Image', 'elementor-pro' ),
						'icon' => 'eicon-image-bold',
					],
					'video' => [
						'title' => __( 'Video', 'elementor-pro' ),
						'icon' => 'eicon-video-camera',
					],
				],
				'toggle' => false,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'image_link_to_type',
			[
				'label' => __( 'Image Click Action', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default'	=>	'none',
				'options' => [
					'none' => __( 'None', 'elementor-pro' ),
				],
				'condition' => [
					'type' => 'image',
				],
				'description' => __('You can also use Popup or Custom URL with the <a style="font-size: 12px; padding: 0 10px" href="'.WB_MC_PRO_LINK.'" target="_blank" >Pro Version</a>'),
			]
		);

		$repeater->add_control(
			'video',
			[
				'label' => __( 'Video Link', 'elementor-pro' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'Enter your video link', 'elementor-pro' ),
				'description' => __( 'YouTube or Vimeo link', 'elementor-pro' ),
				'options' => false,
				'condition' => [
					'type' => 'video',
				],
			]
		);

		$repeater->add_control(
			'video_link_to_type',
			[
				'label' => __( 'Video Click Action', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default'	=>	'custom',
				'options' => [
					'custom' => __( 'Go to URL', 'elementor-pro' ),
				],
				'condition' => [
					'type' => 'video',
				],
				'description' => __('You can also Open Video on Popup with the <a style="font-size: 12px; padding: 0 10px" href="'.WB_MC_PRO_LINK.'" target="_blank" >Pro Version</a>'),
			]
		);

		$this->add_control(
			'slides_items',
			[
				'label' => __( 'Items', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'type' => 'image',
					],
					[
						'type' => 'image',
					],
					[
						'type' => 'image',
					],
					[
						'type' => 'image',
					],
				],
				// 'title_field' => '{{{ breakpoint_size }}}',
				'prevent_empty'=>true,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'full',
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label' => __( 'Image Fit', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover' => __( 'Cover', 'elementor-pro' ),
					'contain' => __( 'Contain', 'elementor-pro' ),
					'auto' => __( 'Auto', 'elementor-pro' ),
				],
				'selectors' => [
					'{{WRAPPER}} .wbel_media-carousel_wrapper .swiper-container .wbmc-elementor-carousel-image' => 'background-size: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_height',
			[
				'label' => __( 'Item Height', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .wbel_media-carousel_wrapper .swiper-container' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'more_feature_two',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.WB_MC_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'slider_configuration',
			[
				'label' => esc_html( 'Slider Configurtion', 'media-carousel-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/*$this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction : ', 'media-carousel-for-elementor' ),
				'placeholder' => esc_html__( 'Choose Direction from Here', 'media-carousel-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal'  => esc_html__( 'Horizontal', 'media-carousel-for-elementor' ),
					'vertical'  => esc_html__( 'Vertical', 'media-carousel-for-elementor' ),
				],
			]
		);*/

		$this->add_control(
			'slidesPerView',
			[
				'label' => __( 'Slides to Show', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 3,
			]
		);

		$this->add_control(
			'slidesPerGroup',
			[
				'label' => __( 'Slides to Scroll', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 1,
			]
		);

		$this->add_control(
			'more_feature_three',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.WB_MC_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		// Arrow Style
		$this->start_controls_section(
			'nav_arrow_style_section',
			[
				'label' => esc_html( 'Navigation Arrow Style', 'media-carousel-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'nav_arrow_color',
			[
				'label' => __( 'Color', 'media-carousel-for-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wbel-mc-arrow' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'more_feature_four',
			[
				'label' => __( '<strong>Need More Options:</strong>', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'label_block' => false,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.WB_MC_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

		// Arrow Style
		$this->start_controls_section(
			'nav_arrow_pro_style_section',
			[
				'label' => esc_html( 'More Style', 'media-carousel-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'more_feature_five',
			[
				'label' => __( '<strong><a href="'.WB_MC_PRO_LINK.'" target="_blank" >Upgrade to PRO</a></strong> for more Options.', 'news-ticker-for-elementor' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'after',
				'label_block' => true,
				'button_type' => 'danger',
				'text' => __( '<a style="color: #fff; font-size: 12px; padding: 0 10px; height: 100%; display: block; line-height: 28px;" href="'.WB_MC_PRO_LINK.'" target="_blank" >Buy Pro</a>', 'plugin-domain' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		$element_id = 'wb_media_carousel'.$this->get_id();

		$effect = isset($settings['effect']) && $settings['effect'] !== '' ? $settings['effect'] : 'carousel';
		$pagination = 'none';
		$autoplay = 'no';
		// $pauseOnFocus = $settings['pauseOnFocus'];
		$pauseOnFocus = 'true';
		// $pauseOnHover = $settings['pauseOnHover'];
		$slidesPerView = isset($settings['slidesPerView']) && $settings['slidesPerView'] ? $settings['slidesPerView'] : 3;
		$slidesPerGroup = isset($settings['slidesPerGroup']) && $settings['slidesPerGroup'] ? $settings['slidesPerGroup'] : 1;
		$autoplay_speed = isset($settings['autoplay_speed']) && $settings['autoplay_speed'] ? $settings['autoplay_speed'] : 3000;
		$loop = isset($settings['loop']) && $settings['loop'] ? $settings['loop'] : true;
		$slide_speed = isset($settings['slide_speed']) && $settings['slide_speed'] ? $settings['slide_speed'] : 300;
		$item_spacing = isset($settings['item_spacing']) && $settings['item_spacing'] ? $settings['item_spacing'] : 15;
		$size = 0;
		if( isset($item_spacing['size']) ){
			$size = $item_spacing['size'];
		}
	        echo '<div
	        		class="wbel_media-carousel_wrapper wbel_media-carousel_'.$effect.' "
	        		data-effect="'.$effect.'"
	        		id="wbel_media-carousel_'.esc_attr($element_id).'"
	        		data-pagination="'.$pagination.'"
	        		data-slidesperview="'.$slidesPerView.'"
	        		data-slidespergroup="'.$slidesPerGroup.'"
	        		data-autoplay="'.$autoplay.'"
	        		data-autoplay-speed="'.$autoplay_speed.'"
	        		data-slide-speed="'.$slide_speed.'"
	        		data-loop="'.$loop.'"
	        		data-item_spacing="'.$size.'"
	        	>';
				
				require( WB_MC_PATH . 'effects/carousel/template.php' );

				?>
					<div class="wbel-mc-arrow wb-mc-arrow-prev">
						<i class="fa fa-angle-left"></i>
					</div>
					<div class="wbel-mc-arrow wb-mc-arrow-next">
						<i class="fa fa-angle-right"></i>
					</div>
				<?php
			
			echo "</div>";
	}

	protected function get_slide_image_url( $slide, array $settings ) {
		$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'image_size', $settings );

		if ( ! $image_url ) {
			$image_url = $slide['image']['url'];
		}

		return $image_url;
	}


}
