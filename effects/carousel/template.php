<?php

?>
<div class="swiper-container">
	<div class="swiper-wrapper">
		<?php
			if( isset($settings['slides_items']) && !empty($settings['slides_items']) ){
				$index=0;
				foreach ($settings['slides_items'] as $items => $item) {
					$index++;
					$element_key = 'wbmc-'.$items.'-'.$index;
					$this->add_render_attribute( $element_key . '-image', [
						'class' => 'wbmc-elementor-carousel-image wbmc-swiper-slider-inner',
						'style' => 'background-image: url(' . $this->get_slide_image_url( $item, $settings ) . ')',
					] );
					$type = $item['type'];
					$image = $item['image'];
					// $image_size_key = $this->get_repeater_setting_key( 'image', 'slides_items', $items );
					if( !array_key_exists('image_link_to', $item) ){
						$item['image_link_to'] = '';
					}
					if( !array_key_exists('image_link_to_type', $item) ){
						$item['image_link_to_type'] = '';
					}
					if( $type == 'video' ){
						$video_link_to_type = $item['video_link_to_type'];
					}else{
						$image_link_to_type = $item['image_link_to_type'];
						$image_link_to = $item['image_link_to'];
					}
				?>
					<div class="swiper-slide">
						<?php
							if ( 'video' === $item['type'] && $item['video']['url'] ) {
								$embed_url_params = [
									'autoplay' => 1,
									'rel' => 0,
									'controls' => 0,
								];

								if( $item['video_link_to_type'] == 'file' ){
									$this->add_render_attribute( $element_key . '_video_link', 'href', $item['image']['url'] );
									$this->add_render_attribute( $element_key . '_video_link', 'class', 'wbmc-video-popup wbmc-popup wbmc-video' );
									$this->add_lightbox_data_attributes( $element_key . '_video_link', $item['image']['id'], 'yes', $this->get_id() );
									$this->add_render_attribute( $element_key . '_video_link', '		data-elementor-lightbox-video', \Elementor\Embed::get_embed_url( $item['video']['url'], $embed_url_params ) );
								}else{
									$this->add_render_attribute( $element_key . '_video_link', 'href', $item['video']['url'] );
									$this->add_render_attribute( $element_key . '_video_link', 'class', 'wb-mc-external-video wbmc-video' );
									$this->add_render_attribute( $element_key . '_video_link', 'target', '_blank' );
								}
								echo '<a ' . $this->get_render_attribute_string( $element_key . '_video_link' ) . '>';
							}

							if ( 'image' === $item['type'] ) {
								if( $item['image_link_to_type'] == 'file' ){
									$this->add_render_attribute( $element_key . 'image_popup', 'href', $item['image']['url'] );
									$this->add_render_attribute( $element_key . 'image_popup', 'class', 'wbmc-img-popup wbmc-popup' );

									$this->add_lightbox_data_attributes( $element_key . 'image_popup', $item['image']['id'], 'yes', $this->get_id() );
									echo '<a ' . $this->get_render_attribute_string( $element_key . 'image_popup' ) . '>';
								}elseif ($item['image_link_to_type'] == 'custom') {
									$this->add_render_attribute( $element_key . 'image_popup', 'href', $item['image_link_to'] );
									$this->add_render_attribute( $element_key . 'image_popup', 'class', 'wbmc-img-external wbmc-popup' );
									$this->add_render_attribute( $element_key . 'image_popup', 'target', '_blank' );

									echo '<a ' . $this->get_render_attribute_string( $element_key . 'image_popup' ) . '>';
								}
							}

						?>
						<div <?php echo $this->get_render_attribute_string( $element_key . '-image' ); ?> >
							<?php if ( 'video' === $item['type'] && $item['video']['url'] ) { ?>
								<div class="elementor-custom-embed-play">
									<i class="eicon-play" aria-hidden="true"></i>
									<span class="elementor-screen-only"><?php _e( 'Play', 'elementor-pro' ); ?></span>
								</div>
							<?php } ?>
						</div>
						<?php if ( 'video' === $item['type'] && $item['video']['url'] ) { echo '</a>'; } ?>
						<?php if ( 'image' === $item['type'] && $item['image_link_to_type'] != 'none' ) { echo '</a>'; } ?>
					</div>
				<?php
				}
			}
		?>

	</div>
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
</div>