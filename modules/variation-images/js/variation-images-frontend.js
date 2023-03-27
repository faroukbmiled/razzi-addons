(function ($) {
    'use strict';
    var razzi = razzi || {};

    razzi.found_data = false;
    razzi.variation_id = 0;

    razzi.foundVariationImages = function( ) {
        $( '.variations_form:not(.form-cart-pbt)' ).on('found_variation', function(e, $variation){
            if( razzi.variation_id != $variation.variation_id ) {
                razzi.changeVariationImagesAjax($variation.variation_id, $(this).data('product_id'));
                razzi.found_data = true;
                razzi.variation_id = $variation.variation_id;
            }
        });
    }

    razzi.resetVariationImages = function( ) {
        $( '.variations_form:not(.form-cart-pbt)' ).on('reset_data', function(e){
            if( razzi.found_data ) {
                razzi.changeVariationImagesAjax(0, $(this).data('product_id'));
                razzi.found_data = false;
                razzi.variation_id = 0;
            }

        });
    }

    razzi.changeVariationImagesAjax = function(variation_id, product_id) {
        var $productGallery = $('.woocommerce-product-gallery'),
            galleryHeight = $productGallery.height();
            $productGallery.addClass('loading').css( {'overflow': 'hidden' });
            if( ! $productGallery.closest('.single-product').hasClass('quick-view-modal') ) {
                $productGallery.css( {'height': galleryHeight });
            }
        var data = {
            'variation_id': variation_id,
            'product_id': product_id,
            nonce: razziData.nonce,
        },
        ajax_url = razziData.ajax_url.toString().replace('%%endpoint%%', 'razzi_get_variation_images');

        var xhr = $.post(
            ajax_url,
            data,
            function (response) {
                var $gallery = $(response.data);

                $productGallery.html( $gallery.html() );
                if ( typeof wc_single_product_params !== 'undefined' && $.fn.wc_product_gallery) {
                    $productGallery.removeData('flexslider');
                    $productGallery.off('click', '.woocommerce-product-gallery__image a');
                    $productGallery.off('click', '.woocommerce-product-gallery__trigger');
                    $productGallery.wc_product_gallery( wc_single_product_params );
                    $productGallery.trigger('product_thumbnails_slider_horizontal');
                    $productGallery.trigger('product_thumbnails_slider_vertical');
                }
                $productGallery.trigger('razzi_update_product_gallery_on_quickview');
                $productGallery.trigger('product-images-slider');

                $productGallery.imagesLoaded(function () {
                    setTimeout(function() {
                        $productGallery.removeClass('loading').removeAttr( 'style' ).css('opacity', '1');
                    }, 200);
                    $productGallery.trigger( 'razzi_gallery_init_zoom', $productGallery.find('.woocommerce-product-gallery__image').first());
                } );

            }
        );
    }
    /**
     * Document ready
     */
    $(function () {
        if( $('div.product' ).hasClass('product-has-variation-images') ) {
            razzi.foundVariationImages();
            razzi.resetVariationImages();
        }

        $('body').on( 'razzi_product_quick_view_loaded', function() {
            if( $('div.product' ).hasClass('product-has-variation-images') ) {
                razzi.foundVariationImages();
                razzi.resetVariationImages();
            }
        } );
    });

})(jQuery);