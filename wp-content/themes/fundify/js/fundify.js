/**
 * Functionality specific to Fundify
 *
 * Provides helper functions to enhance the theme experience.
 */

var delay = (function(){
	var timer = 0;

	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();

var Fundify = {}

Fundify.App = (function($) {
	function fixedHeader() {
		fixHeader();

		$(window).scroll(function () {
			var y = $(window).scrollTop();    

			if ( y >= 400 ) {
				$( '#header' ).addClass( 'mini' );
			} else {
				$( '#header' ).removeClass( 'mini' );
			}
		});

		$(window).resize(function() {
			fixHeader();
		});

		function fixHeader() {
			var x = $(window).width();

			if ( ! $( 'body' ).hasClass( 'fixed-header' ) ) {
				$( 'body' ).css( 'padding-top', 0 );
			} else {
				$( 'body' ).css( 'padding-top', $( '#header' ).outerHeight() );
			}
		}
	}

	return {
		init : function() {
			fixedHeader();

			this.menuToggle();

			$( '#menu .login a, #menu .register a' ).click(function(e) {
				e.preventDefault();
				
				Fundify.App.fancyBox( $(this), {
					items: {
						'src'  : '#' + $(this).parent().attr( 'id' ) + '-wrap'
					}
				});
			});

			$( '.fancybox' ).click( function(e) {
				e.preventDefault();

				Fundify.App.fancyBox( $(this ), {
					items : {
						'src'  : '#' + $(this).attr( 'href' )
					}
				} );
			} );
		},

		/**
		 * Check if we are on a mobile device (or any size smaller than 980).
		 * Called once initially, and each time the page is resized.
		 */
		isMobile : function( width ) {
			var isMobile = false;

			var width = 1180;
			
			if ( $(window).width() <= width )
				isMobile = true;

			return isMobile;
		},

		fancyBox : function( _this, args ) {
			$.magnificPopup.open( $.extend( args, {
				'type' : 'inline'
			}) );
		},

		menuToggle : function() {
			$( '.menu-toggle' ).click(function(e) {
				e.preventDefault();

				$( '#menu' ).slideToggle();
			});
		}
	}
}(jQuery));

Fundify.Campaign = (function($) {
	function campaignGrid() {
		if ( ! $().masonry )
			return;

		var container = $( '#projects section' );

		if ( container.masonry() )
			container.masonry( 'reload' );
		
		container.imagesLoaded( function() {
			container.masonry({
				itemSelector : '.hentry'
			});
		});
	}

	function campaignTabs() {
		var tabs     = $( '.campaign-tabs' ),
		    overview = $( '.campaign-view-descrption' ),
		    tablinks = $( '.sort-tabs.campaign a' );
		
		tabs.children( 'div' ).hide();
		overview.hide();

		tabs.find( ':first-child' ).show();

		tablinks.click(function(e) {
			if ( $(this).hasClass( 'tabber' ) ) {
				var link = $(this).attr( 'href' );
					
				tabs.children( 'div' ).hide();
				overview.show();
				tabs.find( link ).show();
				
				$( 'body' ).animate({
					scrollTop: $(link).offset().top - 200
				});
			}
		});
	}

	function campaignPledgeLevels() {
		$( '.single-reward-levels li' ).click( function(e) {
			e.preventDefault();

			if ( $( this ).hasClass( 'inactive' ) )
				return false;

			var price = $( this ).data( 'price' );

			Fundify.App.fancyBox( $(this), {
				items : {
					src  : '#contribute-modal-wrap'
				},
				beforeShow : function() {
					$( '#contribute-modal-wrap .edd_price_options' )
						.find( 'li[data-price="' + price + '"]' )
						.trigger( 'click' );
				}
			});
		} );
	}

	function campaignWidget() {
		$( 'body.campaign-widget a' ).attr( 'target', '_blank' );
	}

	return {
		init : function() {
			campaignGrid();
			campaignTabs();
			campaignPledgeLevels();
			campaignWidget();
		},

		resizeGrid : function() {
			campaignGrid();
		}
	}
} )(jQuery);

Fundify.Checkout = (function($) {
	var customPriceField  = $( '#contribute-modal-wrap #fundify_custom_price' ),
	    priceOptions      = $( '#contribute-modal-wrap .edd_price_options li' ),
	    submitButton      = $( '#contribute-modal-wrap .edd-add-to-cart' ),
	    currentPrice,
	    startPledgeLevel;

	var formatCurrencySettings = {
		'decimalSymbol'    : fundifySettings.currency.decimal,
		'digitGroupSymbol' : fundifySettings.currency.thousands,
		'symbol'           : ''
	}

	function priceOptionsHandler() {
		customPriceField.keyup(function() {
			submitButton.attr( 'disabled', true );

			var price = $( this ).asNumber( formatCurrencySettings );

			delay( function() {
				Fundify.Checkout.setPrice( price );

				console.log( currentPrice );
				console.log( startPledgeLevel );

				if ( currentPrice < startPledgeLevel )
					Fundify.Checkout.setPrice( startPledgeLevel );
			}, 1000);
		});

		priceOptions.click(function(e) {
			var pledgeLevel = $(this),
			    price = pledgeLevel.data( 'price' );

			if ( pledgeLevel.hasClass( 'inactive' ) )
				return;

			Fundify.Checkout.setPrice( price );
		});
	}

	return {
		init : function() {
			$( '.contribute, .contribute a' ).click(function(e) {
				e.preventDefault();

				Fundify.App.fancyBox( $(this), {
					items : {
						'src' : '#contribute-modal-wrap'
					}
				});
			});

			Fundify.Checkout.setBasePrice();
			priceOptionsHandler();
		},

		setPrice : function( price ) {
			customPriceField
				.val( price )
				.formatCurrency( formatCurrencySettings );

			currentPrice = price;

			priceOptions.each( function( index ) {
				var pledgeLevel = parseFloat( $(this).data( 'price' ) );

				if ( ( currentPrice >= pledgeLevel ) && ! $( this ).hasClass( 'inactive' ) )
					$( this ).find( 'input[type="radio"]' ).attr( 'checked', true );
			});

			submitButton.attr( 'disabled', false );
		},

		setBasePrice : function() {
			priceOptions.each( function( index ) {
				if ( ! $( this ).hasClass( 'inactive' ) && null == startPledgeLevel ) {
					startPledgeLevel = parseFloat( $(this).data( 'price' ) );

					Fundify.Checkout.setPrice( startPledgeLevel );
				}
			});
		}
	}
}(jQuery));

jQuery(document).ready(function($) {
	Fundify.App.init();
	Fundify.Campaign.init();
	Fundify.Checkout.init();

	$( window ).on( 'resize', function() {
		Fundify.Campaign.resizeGrid();
	});
	
	/**
	 * Repositions the window on jump-to-anchor to account for
	 * navbar height.
	 */
	var fundifyAdjustAnchor = function() {
		if ( window.location.hash )
			window.scrollBy( 0, -150 );
	};

	$( window ).on( 'hashchange', fundifyAdjustAnchor );
});