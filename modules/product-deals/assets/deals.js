(function ($) {
    'use strict';

	var $found_data = false;

	$(document).on( 'found_variation', function(e, $variation) {
		var $html = $(e['target']).closest( 'body.single-product' ).find( '.product-gallery-summary .razzi-product-deal' );

		var $variation_id = $variation.variation_id,
			$expire = $variation.expire ? $variation.expire : 0,
			$quantity = $variation._deal_quantity ? $variation._deal_quantity : 0,
			$counts = $variation._deal_sales_counts ? $variation._deal_sales_counts : 0;

		if( $variation_id >  0 ) {
			$html.addClass( 'hidden' );
			if ( $expire && $html.hasClass( 'hidden' ) ) {
				var $countDown = $html.find( '.deal-expire-countdown' ).clone().empty(),
					$width = ( $counts == 0 && $quantity == 0 ) ?  0 : ( $counts / $quantity * 100 ) + '%';

				$html.attr( 'data-variation', $variation_id );
				$countDown.attr( 'data-expire', $expire );

				$html.find( '.deal-expire-countdown' ).replaceWith( $countDown );
				$(document.body).trigger('razzi_countdown', [$html.find( '.deal-expire-countdown' )]);

				$html.find( '.progress-value' ).css( 'width',  $width );
				$html.find( '.sold' ).html( $counts );
				$html.find( '.limit' ).html( $quantity );

				$html.removeClass( 'hidden' );
				$found_data = true;
			}
		} else {
			$html.addClass( 'hidden' );
			$found_data = false;
		}
	});

	$(document).on( 'hide_variation', function(e) {
		$found_data = false;
	});

	$(document).on( 'show_variation', function( e, $variation) {
		if( $variation > 0 ) {
			$found_data = true;
		}
	});

	$(document).on( 'reset_data', function(e) {
		var $html = $(e['target']).closest( 'body.single-product' ).find( '.product-gallery-summary .razzi-product-deal' );

		if( ! $html.hasClass( 'hidden') && ! $found_data) {
			$html.addClass( 'hidden' );
			$found_data = true;
		}
	});

})(jQuery);