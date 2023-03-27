(function ($) {
	"use strict";

	function popup_runner () {
		var $counter = 0,
			$animation = 'animate__fadeInLeft',
        	$closing_animation = 'animate__fadeOutLeft';

		$.ajax({
			type: 'POST',
			dataType: "json",
			data: {
				action: 'live_sales_notification'
			},
			url: razziSBP.ajax_url,
			success: function ( response ) {
				if( ! response.data ) {
					return;
				}

				var $html = shuffle(response.data);

				setTimeout(function () {
					$( 'body' ).append( $html[$counter] );
					$( '.live-sales-notification' ).addClass( $animation );

					setTimeout(function() {
						$( '.live-sales-notification' ).removeClass( $animation );
						$( '.live-sales-notification' ).addClass( $closing_animation );

						setTimeout(function() {
							$( '.live-sales-notification' ).remove();
						}, 1000);
					}, razziSBP.time_keep);

					var interval = parseInt(razziSBP.time_between) + parseInt(razziSBP.time_keep);

					setInterval(function () {
						if ( $counter >= razziSBP.numberShow ) {
							return;
						}

						if( $counter == 0 ) {
							$counter = 1;
						}

						$( 'body' ).append( $html[$counter] );
						$( '.live-sales-notification' ).addClass( $animation );

						setTimeout(function () {
							$( '.live-sales-notification' ).removeClass( $animation );
							$( '.live-sales-notification' ).addClass( $closing_animation );

							setTimeout(function() {
								$( '.live-sales-notification' ).remove();
							}, 1000);

							$counter += 1;
						}, razziSBP.time_keep);
					}, interval);

				}, razziSBP.time_start);
			}
		});
	}

	function close_button() {
		$(document).on( 'click', '.live-sales-notification__close', function (e) {
			e.preventDefault();

			$(this).closest( '.live-sales-notification' ).remove();
		});
	}

	/**
	 *
	 * Shuffle used to shuffle value,
	 *  so even if there is server caching of content user will get random output
	 */
	function shuffle(array) {
		var currentIndex = array.length, temporaryValue, randomIndex;

		// While there remain elements to shuffle...
		while (0 !== currentIndex) {

			// Pick a remaining element...
			randomIndex = Math.floor(Math.random() * currentIndex);
			currentIndex -= 1;

			// And swap it with the current element.
			temporaryValue = array[currentIndex];
			array[currentIndex] = array[randomIndex];
			array[randomIndex] = temporaryValue;
		}

		return array;
	}

	/**
	 * Document ready
	 */
	$(function () {
		if ( typeof razziSBP === 'undefined' ) {
			return false;
		}

        popup_runner();
		close_button();
    });

})(jQuery);