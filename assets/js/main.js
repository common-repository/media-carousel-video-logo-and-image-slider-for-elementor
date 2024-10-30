'use strict';
(function ($) {
	jQuery(window).on('elementor/frontend/init', function(){
		elementorFrontend.hooks.addAction('frontend/element_ready/wb-media-carousel.default', function ($scope, $) {
			var elem = $scope.find('.wbel_media-carousel_wrapper');

			var effect = $scope.find('.wbel_media-carousel_wrapper').data('effect');
			var item_spacing = $scope.find('.wbel_media-carousel_wrapper').data('item_spacing');


			var autoplay = $scope.find('.wbel_media-carousel_wrapper').data('autoplay');
			if( autoplay == 'yes' ){
				autoplay = true;
			}else{
				autoplay = false;
			}

			var loop = $scope.find('.wbel_media-carousel_wrapper').data('loop');
			if( loop == 'yes' ){
				loop = true;
			}else{
				loop = false;
			}

			var autoplaySpeed = 3000;
			if( autoplay == true ){
				autoplaySpeed = $scope.find('.wbel_media-carousel_wrapper').data('autoplay-speed');
			}

			var slideSpeed = $scope.find('.wbel_media-carousel_wrapper').data('slide-speed');
			if( slideSpeed <= 0 ){
				slideSpeed = 1000;
			}

			var slidesPerView = $scope.find('.wbel_media-carousel_wrapper').data('slidesperview');
			if( slidesPerView > 0 ){
				slidesPerView  = $scope.find('.wbel_media-carousel_wrapper').data('slidesperview');
			}else{
				slidesPerView = 3
			}

			var slidesPerGroup = $scope.find('.wbel_media-carousel_wrapper').data('slidespergroup');
			if( slidesPerGroup > 0 ){
				slidesPerGroup  = $scope.find('.wbel_media-carousel_wrapper').data('slidespergroup');
			}else{
				slidesPerGroup = 3
			}

			// var direction = $scope.find('.wbel_media-carousel_wrapper').data('direction');

			var prev_arrow = $scope.find('.wb-mc-arrow-prev');
			var next_arrow = $scope.find('.wb-mc-arrow-next');


			var pagination = $scope.find('.wbel_media-carousel_wrapper').data('pagination');
			
			var swiper = new Swiper('.wbel_media-carousel_wrapper .swiper-container', {
		      slidesPerView: slidesPerView,
		      disableOnInteraction: true,
		      effect : effect,
		      speed : slideSpeed,
		      loop : loop,
		      // direction: direction,
		      spaceBetween: item_spacing,
      		  slidesPerGroup: slidesPerGroup,
		      pagination: {
		        el: '.wb-mc-pagination',
		        // clickable: true,
		        type: pagination,
		      },
		      navigation: {
		        nextEl: '.wb-mc-arrow-next',
		        prevEl: '.wb-mc-arrow-prev',
		      },
		    });

		    if( autoplay ){
				swiper.params.autoplay.delay = autoplaySpeed;		
				swiper.autoplay.start();
			}else{
				swiper.autoplay.stop();
			}
			swiper.on('reachEnd', function(){
				if( !loop ){
				    swiper.autoplay = false;
				}
			});

			// Breakpoints
	        $(window).on('resize', function(){
	            var width = $(window).width();
	            if(width >= 480 && width <= 767) {
	                swiper.params.slidesPerView = 2;
	                swiper.params.spaceBetween = 40;
	            } else if(width < 480) {
	                swiper.params.slidesPerView = 1;
	                swiper.params.spaceBetween = 30;
	            }else{
	            	swiper.params.slidesPerView = 3;
	                swiper.params.spaceBetween = 15;
	            }
	            // swiper.onResize();
	        }).resize(); 
		});
	});
})(jQuery);