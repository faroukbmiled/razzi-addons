(function ($) {
    'use strict';

	function navigationProduct () {
		$( '#razzi-product-fbt .products-list li' ).on( 'click', 'a', function (e) {
			e.preventDefault();

			if( $(this).closest( '.products-list__item' ).hasClass( 'product-current') ) {
				return;
			}

			var $idProduct = $(this).attr( 'data-id' );

			$(this).closest( '.products-list__item' ).toggleClass( 'uncheck' );

			if ( $(this).closest( '.products-list__item' ).hasClass( 'uncheck' ) ) {
				$(this).closest( 'li.products-list__item' ).addClass( 'un-active' );
			} else {
				$(this).closest( 'li.products-list__item' ).removeClass( 'un-active' );
			}

			 $( '#razzi-product-fbt ul.products' ).find( '.pbt-product-' + $idProduct + ' .product-id' ).trigger( 'click' );

			return false;
		});
	}

	function selectProduct () {
		$( '#razzi-product-fbt .product-select' ).on( 'click', 'a', function (e) {
			e.preventDefault();

			var $this				 = $(this).closest( '#razzi-product-fbt' ),
				subTotalData      	 = $this.find('#razzi-data_subtotal'),
				subTotal             = parseFloat($this.find('#razzi-data_subtotal').attr('data-price')),
				totalPriceData       = $this.find('#razzi-data_price'),
				totalPrice           = parseFloat($this.find('#razzi-data_price').attr('data-price')),
				$discountAll         = parseFloat($this.find('#razzi-data_discount-all').data('discount')),
				$quantityDiscountAll = parseFloat($this.find('#razzi-data_quantity-discount-all').data('quantity')),
				$subTotal            = $this.find('.razzi-pbt-subtotal .woocommerce-Price-amount'),
				$savePrice           = $this.find('.razzi-pbt-save-price .woocommerce-Price-amount'),
				$percent             = $this.find('.razzi-pbt-save-price .percent'),
				$priceAt             = $this.find('.razzi-pbt-total-price .woocommerce-Price-amount'),
				$button              = $this.find('.razzi-pbt-add-to-cart'),
				currentPrice 		 = $(this).closest( '.product-select' ).find( '.s-price' ).attr( 'data-price' ),
				$productsVariation   = $this.find('li.product[data-type="variable"]'),
				$razzi_variation_id  = $this.find('input[name="razzi_variation_id"]'),
				$product_ids 		 = '',
				$productVariation_ids= '',
				$i 					 = 0,
				$numberProduct 		 = [];

			if( $(this).closest( '.product-select' ).hasClass( 'product-current' ) ) {
				return false;
			}

			$(this).closest( '.product-select' ).toggleClass( 'uncheck' );

			$this.find( '.product-select' ).each(function () {
				if ( ! $(this).hasClass( 'uncheck' ) ) {
					if( $(this).hasClass( 'product-current' ) ) {
						$product_ids = $(this).find('.product-id').attr('data-id');
					} else {
						$product_ids += ',' + $(this).find('.product-id').attr('data-id');
					}

					if( parseFloat( $(this).find('.product-id').attr('data-id') ) !== 0 && parseFloat( $(this).find('.s-price').attr('data-price') ) !== 0 ) {
						$numberProduct[$i] = $(this).find('.product-id').attr('data-id');
					}

					$i++;
				}
			});

			$numberProduct = jQuery.grep( $numberProduct, function(n){ return (n); });

			$productsVariation.find( '.product-select' ).each(function () {
				if ( ! $(this).hasClass( 'uncheck' ) ) {
					$productVariation_ids += $(this).find('.product-id').attr('data-id') + ',';
				}

				if( ! $productVariation_ids ) {
					$productVariation_ids = 0;
				}
			});

			$razzi_variation_id.attr( 'value', $productVariation_ids );
			$button.attr( 'value', $product_ids );

			if ( $(this).closest( '.product-select' ).hasClass( 'uncheck' ) ) {
				$(this).closest( 'li.product' ).addClass( 'un-active' );
				subTotal -= parseFloat(currentPrice);
			} else {
				$(this).closest( 'li.product' ).removeClass( 'un-active' );
				subTotal += parseFloat(currentPrice);
			}

			var savePrice = ( subTotal / 100 ) * $discountAll;

			if( $discountAll || $discountAll !== 0 ) {
				if( $quantityDiscountAll <= $numberProduct.length ) {
					subTotalData.attr( 'data-price', subTotal );
					$subTotal.html(formatNumber(subTotal));
					$savePrice.html(formatNumber(savePrice));
					$percent.text($discountAll);
					$priceAt.html(formatNumber(subTotal - savePrice));
					totalPriceData.attr( 'data-price', subTotal - savePrice );
					$(this).closest( 'ul.products' ).find( '.price-new' ).removeClass( 'hidden' );
					$(this).closest( 'ul.products' ).find( '.price-ori' ).addClass( 'hidden' );
					$(this).closest( 'ul.products' ).find( '.product-variation-price' ).addClass( 'active' );
					$(this).closest( 'ul.products' ).find( '.product-variation-price .price' ).addClass( 'hidden' );
					$(this).closest( 'ul.products' ).find( '.product-variation-price .price-new' ).removeClass( 'hidden' );
				} else {
					subTotalData.attr( 'data-price', subTotal );
					$subTotal.html(formatNumber(subTotal));
					$savePrice.html(formatNumber(0));
					$percent.text(0);
					$priceAt.html(formatNumber(subTotal));
					totalPriceData.attr( 'data-price', subTotal );
					$(this).closest( 'ul.products' ).find( '.price-new' ).addClass( 'hidden' );
					$(this).closest( 'ul.products' ).find( '.price-ori' ).removeClass( 'hidden' );
					$(this).closest( 'ul.products' ).find( '.product-variation-price' ).removeClass( 'active' );
					$(this).closest( 'ul.products' ).find( '.product-variation-price .price' ).removeClass( 'hidden' );
					$(this).closest( 'ul.products' ).find( '.product-variation-price .price-new' ).addClass( 'hidden' );
				}
			} else {
				$priceAt.html(formatNumber(totalPrice));
				totalPriceData.attr( 'data-price', totalPrice );
			}

			check_ready( $this );

			check_button();
		});
	}

	$(document).on( 'found_variation', function(e, t) {
		var $wrap          = $(e['target']).closest('#razzi-product-fbt'),
			$product       = $(e['target']).closest('li.product'),
			$productPrice  = $(e['target']).closest('li.product').find( '.s-price' ),
			$productAttrs  = $(e['target']).closest('li.product').find( '.s-attrs' ),
			$productID     = $(e['target']).closest('li.product').find( '.product-id' ),
			$button        = $wrap.find('.razzi-pbt-add-to-cart'),
			$display_price = t['display_price'],
			$stock		   = t['is_in_stock'],
			attrs          = {};

		if ( $product.length ) {
			if( $button.val() == 0 ) {
				$button.attr( 'value', $productID );
			}

			if( ! $stock ) {
				$display_price = 0;
				$product.addClass( 'out-of-stock' );
			} else {
				$product.removeClass( 'out-of-stock' );
			}

			if ( $product.attr( 'data-type' ) == 'variable' ) {
				$productPrice.attr('data-price', $display_price);
		  	}

			$productID.attr('data-id', t['variation_id']);
			if ( $product.find( '.product-select' ).hasClass('product-current') ) {
				$wrap.find('.razzi_variation_id').attr('value', t['variation_id']);
			}

			if ( t['image']['url'] ) {
				// change image
				$product.find('.thumbnail .thumb-ori').css( 'opacity', '0' );
				$product.find('.thumbnail .thumb-new').html('<img src="' + t['image']['url'] + '" srcset="' + t['image']['url'] + '"/>').css( 'opacity', '1' );
			}

			// change attributes
			if (t['is_purchasable'] && t['is_in_stock']) {
				$product.find('select[name^="attribute_"]').each(function() {
					var attr_name = $(this).attr('name');
					attrs[attr_name] = $(this).val();
				});

				$productAttrs.attr('data-attrs', JSON.stringify(attrs));
			} else {
				$productAttrs.attr('data-attrs', '');
			}
		}

		variationProduct( $product, $productID.attr('data-id'), $stock );
	});

	$(document).on('reset_data', function(e) {
		var $wrap     	      = $(e['target']).closest('#razzi-product-fbt'),
			$product          = $(e['target']).closest('li.product'),
			$productPrice     = $(e['target']).closest('li.product').find( '.s-price' ),
			$productAttrs  	  = $(e['target']).closest('li.product').find( '.s-attrs' ),
			$productPriceData = parseFloat($(e['target']).closest('li.product').find( '.s-price' ).attr('data-price')),
			$productID        = $(e['target']).closest('li.product').find( '.product-id' ),
			subTotal          = parseFloat($wrap.find('#razzi-data_subtotal').attr('data-price')),
			subTotalData      = $wrap.find('#razzi-data_subtotal');

		if ($product.length) {
			$productID.attr( 'data-id', 0 );
			$productAttrs.attr('data-attrs', '');
			$product.removeClass( 'out-of-stock' );

			// reset thumb
			$product.find('.thumbnail .thumb-new').css( 'opacity', '0' );
			$product.find('.thumbnail .thumb-ori').css( 'opacity', '1' );

		  	// reset price
			if ( $product.attr( 'data-type' ) == 'variable' ) {
				$productPrice.attr('data-price', 0);
			}

			if ( $product.find( '.product-select' ).hasClass('product-current') ) {
				$wrap.find('.razzi_variation_id').attr( 'value', 0 );
			}

			subTotalData.attr('data-price', subTotal - $productPriceData );
		}

		variationProduct( $product, $productID.attr('data-id') );
	});

	function variationProduct ( $this, $productID = 0 ) {
		if( $this.attr( 'data-type' ) !== 'variable' ) {
			return;
		}

		if( $this.find( '.product-select' ).hasClass( 'unckeck' ) ) {
			return;
		}

		var $pbtProducts            = $this.closest('#razzi-product-fbt'),
			$products		        = $pbtProducts.find('li.product'),
			$productsVariable       = $pbtProducts.find('li.product[data-type="variable"]'),
			$subTotal               = $pbtProducts.find('.razzi-pbt-subtotal .woocommerce-Price-amount'),
			$priceAt                = $pbtProducts.find('.razzi-pbt-total-price .woocommerce-Price-amount'),
			$discountAll            = parseFloat( $pbtProducts.find('#razzi-data_discount-all').data('discount')),
			$discountHtml           = $pbtProducts.find('.razzi-pbt-save-price .woocommerce-Price-amount'),
			$quantityDiscountAll    = parseFloat($pbtProducts.find('#razzi-data_quantity-discount-all').data('quantity')),
			$razzi_product_id       = parseFloat( $pbtProducts.find('input[name="razzi_product_id"]').val()),
			$razzi_variation_id     = $pbtProducts.find('input[name="razzi_variation_id"]'),
			$razzi_variation_id_val = $razzi_variation_id.val(),
			$razzi_variation_attrs  = $pbtProducts.find('input[name="razzi_variation_attrs"]'),
			$button                 = $pbtProducts.find('.razzi-pbt-add-to-cart'),
			$percent                = $pbtProducts.find('.razzi-pbt-save-price .percent'),
			subTotal                = parseFloat( $pbtProducts.find('#razzi-data_subtotal').attr('data-price') ),
			subTotalData            = $pbtProducts.find('#razzi-data_subtotal'),
			totalPriceData          = $pbtProducts.find('#razzi-data_price'),
			$variation_attrs 		= {},
			$product_ids 		    = '',
			$razzi_variation_ids 	= '',
			$savePrice				= parseFloat( $pbtProducts.find('#razzi-data_save-price').attr('data-price') ),
			$savePriceData			= $pbtProducts.find('#razzi-data_save-price'),
			$total 					= 0,
			$i 						= 0,
			$numberProduct 		    = [];

		$pbtProducts.find( '.product-select' ).each(function () {
			if ( ! $(this).hasClass( 'uncheck' ) ) {
				if( $(this).hasClass( 'product-current' ) ) {
					$product_ids = $(this).find('.product-id').attr('data-id');
				} else {
					$product_ids += ',' + $(this).find('.product-id').attr('data-id');
				}

				if( parseFloat( $(this).find('.product-id').attr('data-id') ) !== 0 && parseFloat( $(this).find('.s-price').attr('data-price') ) !== 0 ) {
					$numberProduct[$i] = $(this).find('.product-id').attr('data-id');
				}

				$i++;
			}
		});

		$numberProduct = jQuery.grep( $numberProduct, function(n){ return (n); });

		$button.attr( 'value', $product_ids );

		if( $razzi_variation_id_val == 0 ) {
			$razzi_variation_id.attr( 'value', $productID );

			$variation_attrs[$productID] = $this.find('.s-attrs').attr('data-attrs');
			$razzi_variation_attrs.attr( 'value', JSON.stringify($variation_attrs) );
		} else {
			$productsVariable.find( '.product-select' ).each( function () {
				if ( ! $(this).hasClass( 'uncheck' ) ) {
					var $pid 	= $(this).find('.product-id').attr('data-id'),
						$pattrs = $(this).find('.s-attrs').attr('data-attrs');

					$razzi_variation_ids += $pid + ',';
					$variation_attrs[$pid] = $pattrs;
				}
			});

			$razzi_variation_id.attr( 'value', $razzi_variation_ids );
			$razzi_variation_attrs.attr( 'value', JSON.stringify($variation_attrs) );
		}

		$products.find( '.product-select' ).each( function () {
			if ( ! $(this).hasClass( 'uncheck' ) ) {
				var $pPrice = $(this).find('.s-price').attr('data-price');

				$total += parseFloat($pPrice);
			}
		});

		subTotal = $total;

		if( $discountAll !== 0 && $quantityDiscountAll <= $numberProduct.length ) {
			$savePrice = ( subTotal / 100 ) * $discountAll;
			$percent.text($discountAll);

			if( ! $this.hasClass( 'product-primary' ) ) {
				$this.closest( 'ul.products' ).find( '.product-primary .price-ori' ).addClass( 'hidden' );
				$this.closest( 'ul.products' ).find( '.product-primary .price-new' ).removeClass( 'hidden' );
			}
		} else {
			$savePrice = 0;
			$percent.text(0);

			if( ! $this.hasClass( 'product-primary' ) ) {
				$this.closest( 'ul.products' ).find( '.product-primary .price-ori' ).removeClass( 'hidden' );
				$this.closest( 'ul.products' ).find( '.product-primary .price-new' ).addClass( 'hidden' );
			}
		}

		if( $razzi_product_id == 0 ) {
			$savePrice = 0;

			if( $razzi_variation_id !== 0 && $quantityDiscountAll <= $numberProduct.length ) {
				$savePrice = ( subTotal / 100 ) * $discountAll;
				$percent.text($discountAll);

				$this.closest( 'ul.products' ).find( '.product-variation-price' ).addClass( 'active' );
				$this.closest( 'ul.products' ).find( '.product-variation-price .price' ).addClass( 'hidden' );
				$this.closest( 'ul.products' ).find( '.product-variation-price .price-new' ).removeClass( 'hidden' );
			} else {
				$percent.text(0);
			}
		}

		$savePriceData.attr( 'data-price', $savePrice );
		$discountHtml.html(formatNumber($savePrice));

		subTotalData.attr( 'data-price', subTotal );
		$subTotal.html(formatNumber(subTotal));
		totalPriceData.attr( 'data-price', subTotal - $savePrice );
		$priceAt.html(formatNumber(subTotal - $savePrice ));
		$pbtProducts.find('#razzi-data_price').attr( 'data-price', subTotal - $savePrice );

		check_button();
	}

	// Add to cart ajax
    function pbtAddToCartAjax () {

		if (! $('body').hasClass('single-product')) {
			return;
		}

		var $pbtProducts = $('#razzi-product-fbt');

        if ( $pbtProducts.length <= 0 ) {
            return;
        }

        $pbtProducts.on('click', '.razzi-pbt-add-to-cart.ajax_add_to_cart', function (e) {
            e.preventDefault();

            var $singleBtn = $(this);

			if ( $singleBtn.data('requestRunning') || $singleBtn.hasClass( 'disabled' ) ) {
				return;
			}

			$singleBtn.data('requestRunning', true);
			$singleBtn.addClass('loading');

			var $cartForm = $singleBtn.closest('.pbt-cart'),
				formData = $cartForm.serializeArray(),
				formAction = $cartForm.attr('action');

			if ($singleBtn.val() != '') {
				formData.push({name: $singleBtn.attr('name'), value: $singleBtn.val()});
			}

			$(document.body).trigger('adding_to_cart', [$singleBtn, formData]);

			$.ajax({
				url: formAction,
				method: 'post',
				data: formData,
				error: function (response) {
					window.location = formAction;
				},
                success: function (response) {
                    if (typeof wc_add_to_cart_params !== 'undefined') {
                        if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                            window.location = wc_add_to_cart_params.cart_url;
                            return;
                        }
                    }

					var $message = '',
						className = 'info';

					if ( $(response).find('.woocommerce-message').length > 0 ) {
						$(document.body).trigger('wc_fragment_refresh');

						if( $('.single-product div.product form.cart:not(.form-pbt)').find('.razzi-free-shipping-bar').length && $(response).find('div.product form.cart:not(.form-pbt) .razzi-free-shipping-bar').length ) {
							$('.single-product div.product form.cart:not(.form-pbt)').find('.razzi-free-shipping-bar').replaceWith($(response).find('div.product form.cart:not(.form-pbt) .razzi-free-shipping-bar'));
						}
					} else {
						if (!$.fn.notify) {
							return;
						}

						var $checkIcon = '<span class="razzi-svg-icon message-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg></span>',
							$closeIcon = '<span class="razzi-svg-icon svg-active"><svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 1L1 14M1 1L14 14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';

						if ($(response).find('.woocommerce-error').length > 0) {
							$message = $(response).find('.woocommerce-error').html();
							className = 'error';
							$checkIcon = '<span class="razzi-svg-icon message-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></span>';
						} else if ($(response).find('.woocommerce-info').length > 0) {
							$message = $(response).find('.woocommerce-info').html();
						}

						$.notify.addStyle('razzi', {
							html: '<div>' + $checkIcon + '<ul class="message-box">' + $message + '</ul>' + $closeIcon + '</div>'
						});

						$.notify('&nbsp', {
							autoHideDelay: 5000,
							className: className,
							style: 'razzi',
							showAnimation: 'fadeIn',
							hideAnimation: 'fadeOut'
						});
					}

					$singleBtn.removeClass('loading');
					$singleBtn.data('requestRunning', false);
                }
			});

        });

    };

	function check_ready( $wrap = $( '#razzi-product-fbt' ) ) {
		var $products    	= $wrap.find( 'ul.products' ),
			$alert          = $wrap.find( '.razzi-pbt-alert' ),
			$selection_name = '',
			$is_selection   = false;

		$products.find( 'li.product' ).each(function() {
			var $this = $(this),
				$type = $this.attr( 'data-type' );

			if ( ! $this.find( '.product-select' ).hasClass( 'uncheck' ) && $type == 'variable' ) {
				$is_selection = true;

				if ( $selection_name === '' ) {
					$selection_name = $this.attr( 'data-name' );
				} else {
					if( $selection_name ) {
						$selection_name += ', ';
					}

					$selection_name += $this.attr( 'data-name' );
				}
			}
		});

		if ( $is_selection ) {
			$alert.html( razziFbt.alert.replace( '[name]', '<strong>' + $selection_name + '</strong>') ).slideDown();
			$(document).trigger( 'razzi_pbt_check_ready', [false, $is_selection, $wrap] );
		} else {
			$alert.html('').slideUp();
			$(document).trigger( 'razzi_pbt_check_ready', [true, $is_selection, $wrap] );
		}

		check_button();
	}

	function formatNumber( $number ) {
		var currency       = razziFbt.currency_symbol,
			thousand       = razziFbt.thousand_sep,
			decimal        = razziFbt.decimal_sep,
			price_decimals = razziFbt.price_decimals,
			currency_pos   = razziFbt.currency_pos,
			n              = $number;

		if ( parseInt(price_decimals) > 0 ) {
			$number = $number.toFixed(price_decimals) + '';
			var x = $number.split('.');
			var x1 = x[0],
				x2 = x.length > 1 ? decimal + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + thousand + '$2');
			}

			n = x1 + x2
		}

		switch (currency_pos) {
			case 'left' :
				return currency + n;
				break;
			case 'right' :
				return n + currency;
				break;
			case 'left_space' :
				return currency + ' ' + n;
				break;
			case 'right_space' :
				return n + ' ' + currency;
				break;
		}
	}

	function productVariationChange() {
        $('.razzi-product-fbt .variations_form').on( 'show_variation', function () {
            var $container          = $(this).closest( '.product-content' ).find( 'div.price' ),
                $price_new          = $(this).find( '.woocommerce-variation-price' ).html();

			if( $price_new ) {
				if( $container.hasClass( 'hidden' ) ) {
					$container.parent().find( '.product-variation-price' ).remove();
				} else {
					$container.addClass( 'hidden' );
				}

				if( $container.parent().find( '.product-variation-price' ).length ) {
					$container.after( $price_new );
				} else {
					$container.after( '<div class="product-variation-price">' + $price_new + '</div>' );
				}

				$container.parent().find( '.product-variation-price' ).addClass( 'active' );
			}
			check_button();
        });

        $('.razzi-product-fbt .variations_form').on( 'hide_variation', function () {
            var $container = $(this).closest( '.product-content' ).find( 'div.price' );

            if( $container.hasClass( 'hidden' ) ) {
				$container.removeClass( 'hidden' );
				$container.parent().find( '.product-variation-price' ).remove();
			}

			check_button();
        });
    }

	function check_button() {
		var $pbtProducts = $('#razzi-product-fbt'),
			$total = parseFloat( $pbtProducts.find( '#razzi-data_price' ).attr( 'data-price' ) ),
			$pID = parseFloat( $pbtProducts.find( '.razzi_product_id' ).val() ),
			$pVID = parseFloat( $pbtProducts.find( '.razzi_variation_id' ).val() ),
			$button = $pbtProducts.find( '.razzi-pbt-add-to-cart' );

		if( parseFloat( $pbtProducts.find( '.product-select.product-current .s-price' ).attr( 'data-price' ) ) == 0 ) {
			$button.addClass( 'disabled' );
		} else {
			if( $total == 0 || ( $pID == 0 && $pVID == 0 ) ) {
				$button.addClass( 'disabled' );
			} else {
				$button.removeClass( 'disabled' );
			}
		}
	}

    /**
     * Document ready
     */
    $(function () {
		if ( typeof razziFbt === 'undefined' ) {
			return false;
		}

		if (! $('body').hasClass('single-product')) {
			return;
		}

		var $pbtProducts = $('#razzi-product-fbt');

		if ( $pbtProducts.length <= 0) {
			return;
		}

		navigationProduct();

		check_button();

        selectProduct();
		pbtAddToCartAjax();
		check_ready();

		productVariationChange();
    });

})(jQuery);