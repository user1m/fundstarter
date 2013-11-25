/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 */

( function( $ ) {
	var api = wp.customize;

	function fundify_span(str) {
		var breakTag = '</span><br /><span>'

		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

	function fundify_nl2br(str) {
		var breakTag = '<br />'

		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

	/** Site title and description. */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).html( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).html( to );
		} );
	} );

	/** Hero Title */
	wp.customize( 'fundify_hero_style', function( value ) {
		value.bind( function( to ) {
			
		} );
	} );

	/** Hero Description */
	wp.customize( 'fundify_hero_text', function( value ) {
		value.bind( function( to ) {
			text = fundify_span(to);
			$( '#home-page-featured h1' ).html( '<span>' + text + '</span>' );
		} );
	} );

	/** Accent Color */
	wp.customize( 'fundify_accent_color', function( value ) {
		value.bind( function( to ) {
			$( '.sort-tabs .dropdown .current, .sort-tabs li a:hover, .sort-tabs li a.selected, #footer, #footer h3, #footer a' ).css( 'color', to );
			$( '#home-page-featured h1 span, #projects .bar span' ).css( 'background-color', to );
			$( '.sort-tabs li a:hover, .sort-tabs li a.selected' ).css( 'border-color', to );
		} );
	} );

	/** Contact Text */
	wp.customize( 'fundify_contact_text', function( value ) {
		value.bind( function( to ) {
			text = fundify_span(to);
			$( '#title-image h1' ).html( '<span>' + text + '</span>' );
		} );
	} );

	/** Contact Subtitle */
	wp.customize( 'fundify_contact_subtitle', function( value ) {
		value.bind( function( to ) {
			$( '.contact-subtitle' ).html( fundify_nl2br(to) );
		} );
	} );

	/** Contact Address */
	wp.customize( 'fundify_contact_address', function( value ) {
		value.bind( function( to ) {
			$( '.contact-address' ).html(to);
		} );
	} );

	/** Contact Image */
	wp.customize( 'fundify_contact_image', function( value ) {
		value.bind( function( to ) {
			$( '#title-image .image img' ).attr( 'src', to );
		} );
	} );

	/** Footer Text Color */
	wp.customize( 'fundify_footer_text_color', function( value ) {
		value.bind( function( to ) {
			$( '#footer, #footer h3, #footer a' ).css( 'color', to );
			$( '#footer input[type=text], #footer input[type=email]' ).css( 'background-color', to );
		} );
	} );

	/** Footer Logo */
	wp.customize( 'fundify_footer_logo_image', function( value ) {
		value.bind( function( to ) {
			$( '#footer .last-widget .footer-logo' ).attr( 'src', to );
		} );
	} );

	/** Footer Background */
	wp.customize( 'fundify_footer_background_color', function( value ) {
		value.bind( function( to ) {
			$( '#footer' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'fundify_footer_background_image', function( value ) {
		value.bind( function( to ) {
			$( '#footer' ).css( 'background-image', 'url(' + to + ')' );
		} );
	} );

	bg = $.map(['image', 'color', 'position', 'repeat'], function( prop ) {
		return 'fundify_footer_background_' + prop;
	});

	api.when.apply( api, bg ).done( function( image, color, position_x, repeat ) {
		var body =  $(document.body),
			head =  $( 'head' ),
			style = $( '#fundify-footer-custom-background-css' ),
			update;

		update = function() {
			var css = '';

			if ( image() ) {
				css += 'background-color: ' + color() + '")';
				css += 'background-image: url("' + image() + '");';
				css += 'background-position: top ' + position_x() + ';';
				css += 'background-repeat: ' + repeat() + ';';
			}

			// Refresh the stylesheet by removing and recreating it.
			style.remove();
			style = $('<style type="text/css" id="fundify-footer-custom-background-css">#footer { ' + css + ' }</style>').appendTo( head );
		};

		$.each( arguments, function() {
			this.bind( update );
		});
	});
} )( jQuery );