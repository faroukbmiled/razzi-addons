class RaziiSwiperCarouselOption {
	getOptions(selector, settings, breakpoints, check = true, checkBreak = true){
		const	options = {
					loop            : 'yes' === settings.infinite,
					autoplay        : 'yes' === settings.autoplay,
					speed           : settings.autoplay_speed,
					watchOverflow   : true,
					spaceBetween:  'yes' === settings.spacebetween ? 30 : 0,
					pagination: {
					   el: selector.find('.swiper-pagination'),
					   type: 'bullets',
					   clickable: true
					},
					on              : {
						init: function() {
							selector.css( 'opacity', 1 );
						}
					},
					breakpoints     : {}
				};

		if (check){
			options.navigation = {
				nextEl: selector.find('.rz-swiper-button-next'),
				prevEl: selector.find('.rz-swiper-button-prev'),
			}
		}

		if (checkBreak){
			options.breakpoints[breakpoints.xs] = { slidesPerView: settings.slidesToShow_mobile, slidesPerGroup: settings.slidesToScroll_mobile  };
			options.breakpoints[breakpoints.md] = { slidesPerView: settings.slidesToShow_tablet, slidesPerGroup: settings.slidesToScroll_tablet  };
			options.breakpoints[breakpoints.lg] = { slidesPerView: settings.slidesToShow, slidesPerGroup: settings.slidesToScroll };
		}

		return options;
	}
}

class RazziTestimonialsCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-testimonials-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {
		let el = new RaziiSwiperCarouselOption();

		const ops = el.getOptions(this.elements.$container, this.getElementSettings(), elementorFrontend.config.breakpoints);

		return ops;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container.find('.razzi-testimonials-carousel__wrapper'), this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
	}
}

class RazziCountDownWidgetHandler extends elementorModules.frontend.handlers.Base {

	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-countdown'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getCountDownInit() {
		this.elements.$container.rz_countdown();
	}

	onInit() {
		super.onInit();
		this.getCountDownInit();
	}
}

class RazziBannerWidgetHandler extends elementorModules.frontend.handlers.Base {

	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-banner'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getCountDownInit() {
		this.elements.$container.find('.razzi-countdown').rz_countdown();
	}

	onInit() {
		super.onInit();
		this.getCountDownInit();
	}
}

class RazziFaqsWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-faq'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getFaqsInit() {
		const els = this.elements.$container.find('.box-content'),
			  settings = this.getElementSettings();

		if( settings.status == 'yes' ) {
			els.not(':first-child').find('.faq-desc').slideUp();
		} else {
			els.find('.faq-desc').slideUp();
		}

		els.on('click', function () {
			var   item = jQuery(this),
				  siblings = item.siblings(item);

			if (els.hasClass('.active')) {
				return;
			}

			siblings.removeClass('active');
			item.addClass('active');
			siblings.find('.faq-desc').slideUp();
			item.find('.faq-desc').slideDown();
		});
	}

	onInit() {
		super.onInit();
		this.getFaqsInit();
	}
}

class RazziMapWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-map'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	get_coordinates(){
		var	data = [],
			index = 0,
			self = this,
			el = self.elements.$container,
			elsMap = el.data('map'),
			local = elsMap.local,
			mapboxClient = mapboxSdk( { accessToken: elsMap.token } ),
			wrapper = el.find('.razzi-map__content').attr('id');

		mapboxgl.accessToken = elsMap.token;

		jQuery.each( local, function( i, val ) {
			mapboxClient.geocoding.forwardGeocode( {
				query       : val,
				autocomplete: false,
				limit       : 1
			} )
				.send()
				.then( function ( response ) {
					if ( response && response.body && response.body.features && response.body.features.length ) {
						var feature = response.body.features[0],
							tab = el.find('.razzi-map__table .box-item');

						tab.eq(i).attr("data-latitude",feature.center[0]);
						tab.eq(i).attr("data-longitude",feature.center[1]);

						var item = {
								"type"    : "Feature",
								'properties': {
									'description': tab.eq(i).html(),
									'icon': 'theatre'
								},
								"geometry": {
									"type"       : "Point",
									"coordinates": [feature.center[0],feature.center[1]]
								}
						};

						if( index == 0 ) {
							var center = [feature.center[0],feature.center[1]];
							self.get_map(wrapper,elsMap,tab, elsMap.token, data, center);
						}

						data.push(item);
						index++;
					}
				} );
		} );

		return data;
	}

	get_map(wrapper,elsMap, tab, accessToken, data, center){
			var map = new mapboxgl.Map( {
				container: wrapper,
				style    : 'mapbox://styles/mapbox/'+ elsMap.mode ,
				center   : center,
				zoom     : elsMap.zom
			} );

			var geocoder = new MapboxGeocoder( {
				accessToken: mapboxgl.accessToken
			} );

			map.addControl( geocoder );

			map.on( 'load', function () {
				map.loadImage( elsMap.marker, function ( error, image ) {
					if ( error ) throw error;
					map.addImage( 'marker', image );
					map.addLayer( {
						"id"    : "points",
						"type"  : "symbol",
						"source": {
							"type": "geojson",
							"data": {
								"type"    : "FeatureCollection",
								"features": data
							}
						},
						"layout": {
							"icon-image": "marker",
							"icon-size" : 1
						}
					} );
				} );

				map.addSource( 'single-point', {
					"type": "geojson",
					"data": {
						"type"    : "FeatureCollection",
						"features": []
					}
				} );

				map.addLayer( {
					"id"    : "point",
					"source": "single-point",
					"type"  : "circle",
					"paint" : {
						"circle-radius": 10,
						"circle-color" : "#007cbf"
					}
				} );

				map.setPaintProperty( 'water', 'fill-color', elsMap.color_1 );
				map.setPaintProperty( 'building', 'fill-color', elsMap.color_2 );

				geocoder.on( 'result', function ( ev ) {
					map.getSource( 'single-point' ).setData( ev.result.geometry );
				} );

				map.on('click', 'points', function (e) {
					var coordinates = e.features[0].geometry.coordinates.slice();
					var description = e.features[0].properties.description;

					while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
						coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
					}

					new mapboxgl.Popup()
						.setLngLat(coordinates)
						.setHTML(description)
						.addTo(map);
				});

				map.on('mouseenter', 'points', function () {
					map.getCanvas().style.cursor = 'pointer';
				});

				map.on('mouseleave', 'points', function () {
					 map.getCanvas().style.cursor = '';
				});
			} );

			tab.on('click', function () {
				var  lat = jQuery(this).data('latitude'),
					 long = jQuery(this).data('longitude');

				map.flyTo({
					center: [lat,long ],
					zoom: elsMap.zom,
					essential: true, // this animation is considered essential with respect to prefers-reduced-motion,
					speed: 3,
					curve: 1,
				});
			});
	}

	onInit() {
		super.onInit();
		this.get_coordinates();
	}
}

class RazziBannerCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-banner-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {
		let el = new RaziiSwiperCarouselOption();

		const ops = el.getOptions(this.elements.$container, this.getElementSettings(), elementorFrontend.config.breakpoints);

		return ops;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container, this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
	}
}

class RazziTestimonialsCarousel2WidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-testimonials-carousel-2'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {
		const 	self 		= this,
			 	settings 	= self.getElementSettings();

		var slidesPerView = settings.slidesPerViewAuto == 'yes' ? 'auto' : settings.slidesToShow,
		centeredSlides = settings.centeredSlides == 'yes' ? true : false;
		if(centeredSlides== true){
			slidesPerView = "auto";
		}

		var options = {
			loop: centeredSlides == true ? true : 'yes' === settings.infinite,
            autoplay: settings.autoplay == 'yes' ? true : false,
            speed: settings.autoplay_speed ? settings.autoplay_speed : 500,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
			scrollbar: {
                el: '.swiper-scrollbar',
                hide: false,
                draggable: true
            },
			spaceBetween: 30,
            on: {
                init: function () {
                    this.$el.css('opacity', 1);
                }
            },
            breakpoints: {
                300: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : 1,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : 1,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: settings.slidesToShow_tablet ? settings.slidesToShow_tablet : 2,
                    slidesPerGroup: settings.slidesToScroll_tablet ? settings.slidesToScroll_tablet : 2,
					spaceBetween: 30
                },
                1366: {
                    slidesPerView: slidesPerView > 3 ? 3 : slidesPerView,
                    slidesPerGroup: settings.slidesToScroll > 3 ? 3 : settings.slidesToScroll
                },
                1500: {
                    slidesPerView: slidesPerView,
					centeredSlides: centeredSlides,
                    slidesPerGroup: settings.slidesToScroll
				}
            }
        };

		return options;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container, this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.getSwiperInit();
	}
}

class RazziBrandsCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-brands-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {

		let el = new RaziiSwiperCarouselOption();

		const ops = el.getOptions(this.elements.$container, this.getElementSettings(), elementorFrontend.config.breakpoints);

		return ops;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container.find('.list-brands__wrapper'), this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.getSwiperInit();
	}
}

class RazziSlidesWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-slides-elementor'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {

		const 	self 		= this;
		const 	container 	= self.elements.$container;
		const 	settings 	= self.getElementSettings();
		const 	breakpoints = elementorFrontend.config.breakpoints;

		var slidesPerView = settings.centeredSlides == 'yes' ? 'auto' : 1,
			centeredSlides = settings.centeredSlides == 'yes' ? true : false;

		const 	options = {
					loop            : centeredSlides == true ? true : 'yes' === settings.infinite,
					autoplay        : 'yes' === settings.autoplay,
					speed           : settings.autoplay_speed,
					watchOverflow   : true,
                	lazy            : 'yes' === settings.lazyload,
                	effect          : centeredSlides == true ? 'slide' : settings.effect,
				 	navigation: {
				 		nextEl: container.find('.rz-swiper-button-next'),
						prevEl: container.find('.rz-swiper-button-prev'),
	                },
					pagination: {
					   el: container.find('.swiper-pagination'),
					   type: 'bullets',
					   clickable: true
					},
			 		fadeEffect: {
	                    crossFade: true
	                },
					on              : {
						init: function() {
							container.css( 'opacity', 1 );
							var index = this.activeIndex,
								currentSlide =   jQuery(this.slides[index]),
							  	currentSlideType = currentSlide.find('.razzi-slide-banner__video');

							if( index == 0 && currentSlideType.length == 1 ) {
								if( currentSlideType.attr('data-type') == 'youtube' ) {
									jQuery('#razzi-slide-banner__video--0')[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
								} else if (currentSlideType.attr('data-type') == 'self_hosted') {
									document.getElementById("razzi-slide-banner__video--0").play();
								}
							}
						},
						slideChange: function() {
							var video = document.getElementsByClassName("razzi-slide-banner__video"),
								video_id = [];

							for (var i = 0; i < video.length; i++) {
								video_id[i] = video[i].id;

								if( jQuery('#'+video_id[i]).attr('data-type') == 'youtube' ) {
									jQuery('#'+video_id[i])[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
								} else if (jQuery('#'+video_id[i]).attr('data-type') == 'self_hosted') {
									document.getElementById(video_id[i]).pause();
								}

							}

							var index         = this.activeIndex,
								currentSlide     = jQuery(this.slides[index]),
								currentSlideType = currentSlide.find('.razzi-slide-banner__video');

							if( currentSlideType.length == 1 ) {
								if( currentSlideType.attr('data-type') == 'youtube' ) {
									jQuery('#razzi-slide-banner__video--'+index)[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*');
								} else if (currentSlideType.attr('data-type') == 'self_hosted') {
									document.getElementById("razzi-slide-banner__video--"+index).play();
								}
							}
						}
					},
					breakpoints: {
						300: {
							slidesPerView: 1,
						},
						768: {
							slidesPerView: 1,
						},
						1366: {
							slidesPerView: slidesPerView > 3 ? 3 : slidesPerView,
						},
						1500: {
							slidesPerView: slidesPerView,
							centeredSlides: centeredSlides,
							spaceBetween: centeredSlides == true ? 30 : 0,
						}
					}
				};

		if ( 'yes' === settings.autoplay ) {
			options.autoplay = {
				delay: settings.delay
			};
		}

		return options;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container.find('.razzi-slides-elementor__wrapper'), this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.getSwiperInit();
	}
}

class RazziIsolateSlidesWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-isolate-slides'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {

		const 	self 		= this;
		const 	container 	= self.elements.$container;
		const 	settings 	= self.getElementSettings();
		const 	breakpoints = elementorFrontend.config.breakpoints;

		const 	options = {
					loop            : 'yes' === settings.infinite,
					autoplay        : 'yes' === settings.autoplay,
					speed           : settings.autoplay_speed,
					watchOverflow   : true,
                	lazy            : 'yes' === settings.lazyload,
                	effect          : settings.effect,
				 	navigation: {
				 		nextEl: container.find('.rz-swiper-button-next'),
						prevEl: container.find('.rz-swiper-button-prev'),
	                },
					pagination: {
					   el: container.find('.swiper-pagination'),
					   type: 'bullets',
					   clickable: true
					},
			 		fadeEffect: {
	                    crossFade: true
	                },
					on              : {
						init: function() {
							container.css( 'opacity', 1 );
						}
					}
				};

		if ( 'yes' === settings.autoplay ) {
			options.autoplay = {
				delay: settings.delay
			};
		}

		return options;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container.find('.razzi-isolate-slides__content-wrapper'), this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.getSwiperInit();
	}
}

class RazziPostCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-posts-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {

		let el = new RaziiSwiperCarouselOption();

		const ops = el.getOptions(this.elements.$container, this.getElementSettings(), elementorFrontend.config.breakpoints);

		ops.spaceBetween = 30;

		return ops;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container.find('.list-posts'), this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
	}
}

class RazziPostCarousel2WidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-posts-carousel-2'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {
		let el = new RaziiSwiperCarouselOption();

		const ops = el.getOptions(this.elements.$container, this.getElementSettings(), elementorFrontend.config.breakpoints);

		ops.spaceBetween = 30;

		return ops;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container.find('.list-posts'), this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.getSwiperInit();
	}
}

class RazziBannerVideoWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-banner-video'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getPopupOption() {
		const 	options = {
					type: 'iframe',
	            	mainClass: 'mfp-fade',
		            removalDelay: 300,
		            preloader: false,
		            fixedContentPos: false,
		            iframe: {
						markup: '<div class="mfp-iframe-scaler">' +
								'<div class="mfp-close"></div>' +
								'<iframe class="mfp-iframe" frameborder="0" allow="autoplay"></iframe>' +
								'</div>',
		                patterns: {
		                    youtube: {
		                        index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).

		                        id: 'v=', // String that splits URL in a two parts, second part should be %id%
		                        src: 'https://www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe.
		                    },
		                    vimeo: {
		                        index: 'vimeo.com/',
		                        id: '/',
		                        src: '//player.vimeo.com/video/%id%?autoplay=1'
		                    }
		                },

		                srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
		            }
				};

		return options;
	}

	getPopupInit() {
		this.elements.$container.find('.razzi-banner-video__play').magnificPopup( this.getPopupOption() )
	}

	onInit() {
		super.onInit();
		this.getPopupInit();
	}
}

class RazziLookbookBannerWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-lookbook-banner'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	lookBookHandle(){
		const 	container = this.elements.$container;
		const 	item = container.find('.razzi-lookbook-item');

        container.on('click', '.razzi-lookbook-item', function (e) {
            var el = jQuery(this),
                siblings = el.siblings();

            el.toggleClass('active');
            siblings.removeClass('active');
        });

        jQuery(document.body).on('click', function (evt) {

            if (jQuery(evt.target).closest(item).length > 0) {
                return;
            }

            item.removeClass('active');
        });
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.lookBookHandle();
	}
}

class RazziLookbookSliderWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-lookbook-slider-elementor'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {

		const 	container 	= this.elements.$container;
		const 	settings 	= this.getElementSettings();
		const 	breakpoints = elementorFrontend.config.breakpoints;

		const 	options = {
					loop            : 'yes' === settings.infinite,
					autoplay        : 'yes' === settings.autoplay,
					speed           : settings.autoplay_speed,
					watchOverflow   : true,
                	lazy            : 'yes' === settings.lazyload,
                	effect          : settings.effect,
				 	navigation: {
	                    nextEl: container.find('.rz-swiper-button-next'),
						prevEl: container.find('.rz-swiper-button-prev'),
	                },
					pagination: {
					   el: container.find('.swiper-pagination'),
					   type: 'bullets',
					   clickable: true
					},
			 		fadeEffect: {
	                    crossFade: true
	                },
					on              : {
						init: function() {
							container.css( 'opacity', 1 );

							if(container.find('.item-slider').length > 1){
								container.find('.slick-slide-block__img .rz-swiper-button').css({'display':'block', 'cursor':'pointer'});
							}
						}
					}
				};

		if ( 'yes' === settings.autoplay ) {
			options.autoplay = {
				delay: settings.delay
			};
		}

		return options;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container, this.getSwiperOption() );
	}

	lookBookHandle(){
		const 	container = this.elements.$container;
		const 	item = container.find('.razzi-lookbook-item');

        container.on('click', '.razzi-lookbook-item', function (e) {
            var el = jQuery(this),
                siblings = el.siblings();

            el.toggleClass('active');
            siblings.removeClass('active');
        });

        jQuery(document.body).on('click', function (evt) {

            if (jQuery(evt.target).closest(item).length > 0) {
                return;
            }

            item.removeClass('active');
        });
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
		this.lookBookHandle();
	}
}

class RazziBeforeAfterImagesWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-before-after-images'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {
		const 	settings = this.getElementSettings();

		let el = new RaziiSwiperCarouselOption();

		const ops = el.getOptions(this.elements.$container, settings, elementorFrontend.config.breakpoints, true, false);

		ops.touchRatio = 0;

		if ( 'yes' === settings.autoplay ) {
			ops.autoplay = {
				delay: settings.delay
			};
		}

		ops.effect = 'fade';

		return ops;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container, this.getSwiperOption() );
	}

	changeImagesHandle() {
		const container = this.elements.$container;

        container.imagesLoaded( function () {
            container.find( '.box-thumbnail' ).imageslide();
        } );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.getSwiperInit();
		this.changeImagesHandle();
	}
}

class RazziTestimonialsGridFlexibleWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-testimonials-grid'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	ItemsFlexibleHandle() {
		const 	container = this.elements.$container;
		const 	settings = this.getElementSettings();

        container.imagesLoaded(function () {
            container.find('.testimonials-wrapper').masonryGrid({
                'columns': settings.columns,
            });
        });
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.ItemsFlexibleHandle();
	}
}

class RazziIconBoxCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-icons-box-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {

		const 	self 		= this;
		const 	container 	= self.elements.$container;
		const 	settings 	= self.getElementSettings();

		const 	options = {
					loop            : 'yes' === settings.infinite,
					autoplay        : 'yes' === settings.autoplay,
					speed           : settings.autoplay_speed,
					watchOverflow   : true,
					navigation: {
						nextEl: container.find('.rz-swiper-button-next'),
						prevEl: container.find('.rz-swiper-button-prev'),
	                },
					pagination: {
					   el: container.find('.swiper-pagination'),
					   type: 'bullets',
					   clickable: true
					},
					on              : {
						init: function() {
							container.find('.razzi-icons-box-carousel__wrapper').css( 'opacity', 1 );
						}
					},
					breakpoints     : {
	                    0: {
	                        slidesPerView : settings.slidesToShow_mobile  ? settings.slidesToShow_mobile : 2,
	                        slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : 2
	                    },

	                    380: {
	                        slidesPerView : settings.slidesToShow_mobile  ? settings.slidesToShow_mobile : 3,
	                        slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : 3
	                    },

	                    546 : {
	                        slidesPerView : settings.slidesToShow_tablet  ? settings.slidesToShow_tablet : 4,
	                        slidesPerGroup: settings.slidesToScroll_tablet ? settings.slidesToScroll_tablet : 4
	                    },
	                    768 : {
	                        slidesPerView : settings.slidesToShow_tablet  ? settings.slidesToShow_tablet : 5,
	                        slidesPerGroup: settings.slidesToScroll_tablet ? settings.slidesToScroll_tablet : 5
	                    },
	                    1025: {
	                        slidesPerView : settings.slidesToShow,
	                        slidesPerGroup: settings.slidesToScroll
	                    },
	                }
				};

		return options;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container.find('.razzi-icons-box-carousel__wrapper'), this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}
		this.getSwiperInit();
	}
}

class RazziImagesCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-images-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperInit() {
		const settings = this.getElementSettings();
        var slidesPerView = settings.slidesPerViewAuto == 'yes' ? 'auto' : settings.slidesToShow;

		var options = {
            watchOverflow: true,
            loop: settings.infinite == 'yes' ? true : false,
            autoplay: settings.autoplay == 'yes' ? true : false,
            speed: settings.autoplay_speed,
            navigation: {
                nextEl: this.elements.$container.find('.rz-swiper-button-next'),
                prevEl: this.elements.$container.find('.rz-swiper-button-prev'),
            },
            pagination: {
                el: this.elements.$container.find('.swiper-pagination'),
                clickable: true
            },
			scrollbar: {
                el: this.elements.$container.find('.swiper-scrollbar'),
                hide: false,
                draggable: true
            },
            on: {
                init: function () {
                    this.$el.css('opacity', 1);
                }
            },
            breakpoints: {
                300: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                },
                480: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                },
                768: {
                    slidesPerView: settings.slidesToShow_tablet ? settings.slidesToShow_tablet : 3,
                    slidesPerGroup: settings.slidesToScroll_tablet ? settings.slidesToScroll_tablet : 3,
                },
                1024: {
                    slidesPerView: slidesPerView > 4 ? 4 : slidesPerView,
                    slidesPerGroup: settings.slidesToScroll > 4 ? 4 : settings.slidesToScroll,
                },
                1366: {
                    slidesPerView: slidesPerView > 5 ? 5 : slidesPerView,
                    slidesPerGroup: settings.slidesToScroll > 5 ? 5 : settings.slidesToScroll
                },
                1500: {
                    slidesPerView: slidesPerView,
                    slidesPerGroup: settings.slidesToScroll
                }
            }
        };

        new Swiper(this.elements.$container.find('.swiper-container'), options);
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
	}
}
class RazziImagesCarousel2WidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-images-carousel-2'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperInit() {
		const settings = this.getElementSettings();

		var options = {
            watchOverflow: true,
            loop: settings.infinite == 'yes' ? true : false,
            autoplay: settings.autoplay == 'yes' ? true : false,
            speed: settings.autoplay_speed,
            navigation: {
                nextEl: this.elements.$container.find('.razzi-swiper-button-next'),
                prevEl: this.elements.$container.find('.razzi-swiper-button-prev'),
            },
            pagination: {
                el: this.elements.$container.find('.swiper-pagination'),
                clickable: true
            },
            on: {
                init: function () {
                    this.$el.css('opacity', 1);
                }
            },
            breakpoints: {
                300: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                },
                480: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                },
                768: {
                    slidesPerView: settings.slidesToShow_tablet ? settings.slidesToShow_tablet : 3,
                    slidesPerGroup: settings.slidesToScroll_tablet ? settings.slidesToScroll_tablet : 3,
                },
                1024: {
                    slidesPerView: settings.slidesToShow > 4 ? 4 : settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll > 4 ? 4 : settings.slidesToScroll,
                },
                1366: {
                    slidesPerView: settings.slidesToShow > 5 ? 5 : settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll > 5 ? 5 : settings.slidesToScroll
                },
                1500: {
                    slidesPerView: settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll
                }
            }
        };

        new Swiper(this.elements.$container.find('.swiper-container'), options);
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
	}
}

class RazziAdvancedTabsWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-advanced-tabs'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getTabs($selector, settings) {
        var $list = $selector.find('.swiper-wrapper');

        $list.find('.razzi-advanced-tabs__item').addClass('swiper-slide');
        $list.after('<div class="swiper-pagination"></div>');
        $list.before('<span class="razzi-svg-icon rz-swiper-button-prev rz-swiper-button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></span>');
        $list.before('<span class="razzi-svg-icon rz-swiper-button-next rz-swiper-button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></span>');

        var options = {
            watchOverflow: true,
            loop: settings.infinite == 'yes' ? true : false,
            autoplay: settings.autoplay == 'yes' ? true : false,
            speed: 500,
            pagination: {
                el: $selector.find('.swiper-pagination'),
                clickable: true
            },
            navigation: {
                nextEl: $selector.find('.rz-swiper-button-next'),
                prevEl: $selector.find('.rz-swiper-button-prev'),
            },
            spaceBetween: 30,
            on: {
                init: function () {
                    this.$el.css('opacity', 1);
                }
            },
            breakpoints: {
                300: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                    spaceBetween: 15,
                },
                480: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: settings.slidesToShow_tablet ? settings.slidesToShow_tablet : 3,
                    slidesPerGroup: settings.slidesToScroll_tablet ? settings.slidesToScroll_tablet : 3,
                },
                1024: {
                    slidesPerView: settings.slidesToShow > 5 ? 5 : settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll > 5 ? 5 : settings.slidesToScroll,
                    spaceBetween: 30
                },
                1366: {
                    slidesPerView: settings.slidesToShow > 6 ? 6 : settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll > 6 ? 6 : settings.slidesToScroll
                },
                1500: {
                    slidesPerView: settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll
                }
            }
        };

        new Swiper($selector.find('.swiper-container'), options);
    };

    navTabs($tabs, $el, $currentTab) {
        $tabs.find('.razzi-advanced-tabs__nav a').removeClass('active');
        $el.addClass('active');
        $tabs.find('.razzi-advanced-tabs__panel').removeClass('active');
        $currentTab.addClass('active');
    }

    getTabsAJAXHandler($el, $tabs) {
        var self = this,
            tab = $el.data('tabs'),
            $currentTab = $tabs.find('.' + tab);

        if ($currentTab.hasClass('tab-loaded')) {
            self.navTabs($tabs, $el, $currentTab);
            return;
        }

		const settings = self.getElementSettings();

		self.getTabs($currentTab, settings);

		self.navTabs($tabs, $el, $currentTab);

		$currentTab.addClass('tab-loaded');
    };

    onInit() {
        var self = this;
        const settings = this.getElementSettings();

        super.onInit();

        var $selector = this.elements.$container,
            $panels = $selector.find('.tab-loaded');


        self.getTabs($panels, settings);
        $selector.find('.razzi-advanced-tabs__nav').on('click', 'a', function (e) {
            e.preventDefault();
            self.getTabsAJAXHandler(jQuery(this), $selector);
        });

    }
}

class RazziImagesBoxCarousel2WidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-images-box-carousel-2'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperInit() {
		const settings = this.getElementSettings();

		var options = {
            watchOverflow: true,
            loop: settings.infinite == 'yes' ? true : false,
            autoplay: settings.autoplay == 'yes' ? true : false,
            speed: settings.autoplay_speed,
            navigation: {
                nextEl: this.elements.$container.find('.rz-swiper-button-next'),
                prevEl: this.elements.$container.find('.rz-swiper-button-prev'),
            },
            pagination: {
                el: this.elements.$container.find('.swiper-pagination'),
                clickable: true
            },
            on: {
                init: function () {
                    this.$el.css('opacity', 1);
                }
            },
            breakpoints: {
                300: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                },
                480: {
                    slidesPerView: settings.slidesToShow_mobile ? settings.slidesToShow_mobile : razziData.mobile_portrait,
                    slidesPerGroup: settings.slidesToScroll_mobile ? settings.slidesToScroll_mobile : razziData.mobile_portrait,
                },
                768: {
                    slidesPerView: settings.slidesToShow_tablet ? settings.slidesToShow_tablet : 3,
                    slidesPerGroup: settings.slidesToScroll_tablet ? settings.slidesToScroll_tablet : 3,
                },
                1024: {
                    slidesPerView: settings.slidesToShow > 3 ? 3 : settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll > 3 ? 3 : settings.slidesToScroll,
                },
                1366: {
                    slidesPerView: settings.slidesToShow > 3 ? 3 : settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll > 3 ? 3 : settings.slidesToScroll
                },
                1500: {
                    slidesPerView: settings.slidesToShow,
                    slidesPerGroup: settings.slidesToScroll
                }
            }
        };

        new Swiper(this.elements.$container.find('.swiper-container'), options);
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
	}
}

class RazziTeamsCarouselWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-team-member-carousel'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	getSwiperOption() {
		let el = new RaziiSwiperCarouselOption();

		const ops = el.getOptions(this.elements.$container, this.getElementSettings(), elementorFrontend.config.breakpoints);

		return ops;
	}

	getSwiperInit() {
		new Swiper( this.elements.$container, this.getSwiperOption() );
	}

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.getSwiperInit();
	}
}

class RazziHeadingWidgetHandler extends elementorModules.frontend.handlers.Base {
	getDefaultSettings() {
		return {
			selectors: {
				container: '.razzi-heading-wrapper'
			},
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings( 'selectors' );

		return {
			$container: this.$element.find( selectors.container )
		};
	}

	headingScroll(){
		var heading = [];
		jQuery( '.razzi-heading-auto-scrolling' ).parent().each(function(){
			heading.push( jQuery( this ).clone().html())
		})

		jQuery( '.razzi-heading-auto-scrolling' ).parent().each(function(i){
            var $this = jQuery( this );
            $this.removeClass( 'razzi-scrolling-yes' );
            var amount = Math.ceil( jQuery( window ).width()/jQuery( this ).find( '.razzi-heading-title' ).outerWidth( true ) ) + 1;
            $this.empty().addClass( 'razzi-scrolling-yes' );
            $this.html( heading[i].repeat( amount ) );
        })
    }

	onInit() {
		super.onInit();

		if ( ! this.elements.$container.length ) {
			return;
		}

		this.headingScroll();
	}
}

jQuery( window ).on( 'elementor/frontend/init', () => {
	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-testimonials-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziTestimonialsCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-countdown.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziCountDownWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-banner.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziBannerWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-faq.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziFaqsWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-map.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziMapWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-banner-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziBannerCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-testimonials-carousel-2.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziTestimonialsCarousel2WidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-brands-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziBrandsCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-slides.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziSlidesWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-isolate-slides.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziIsolateSlidesWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-posts-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziPostCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-posts-carousel-2.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziPostCarousel2WidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-banner-video.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziBannerVideoWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-lookbook-banner.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziLookbookBannerWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-lookbook-slider.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziLookbookSliderWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-before-after-images.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziBeforeAfterImagesWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-testimonials-grid.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziTestimonialsGridFlexibleWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-icons-box-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziIconBoxCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-images-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziImagesCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-images-carousel-2.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziImagesCarousel2WidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-advanced-tabs.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziAdvancedTabsWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-images-box-carousel-2.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziImagesBoxCarousel2WidgetHandler, { $element } );
	} );


	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-team-member-carousel.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziTeamsCarouselWidgetHandler, { $element } );
	} );

	elementorFrontend.hooks.addAction( 'frontend/element_ready/razzi-heading.default', ( $element ) => {
		elementorFrontend.elementsHandler.addHandler( RazziHeadingWidgetHandler, { $element } );
	} );

} );