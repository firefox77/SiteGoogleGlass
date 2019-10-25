/**
 * Calculations for alignwide and alignfull classes for Gutenberg
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

( function( $ ) {
	"use strict";

	var widthCalc = function() {
		var $this,
			$site,
			$content,
			siteWidth,
			contentWidth,
			margin;

		$this = $( this );
		$site = $( 'body' );

		$content = $( '.site-main .entry-content' );
		if ( $site.length && $content.length ) {
			// get width.
			siteWidth    = $site.outerWidth( false );
			contentWidth = $content.outerWidth( false );

			if ( siteWidth <= 700 ) {
				$this.css( {'margin-left': '', 'margin-right': ''} );
			} else {
				// used for centering.
				margin = ( ( siteWidth - contentWidth ) / 2 );

				if ( $this.hasClass( 'alignwide' ) ) {
					margin -= 20;
					margin  = Math.max( margin, 0 );
					margin  = Math.min( margin, 200 );
				}

				if ( $this.hasClass( 'wp-block-gallery' ) ) {
					margin += 8; /* 8px offset for gallery margin. */
				}

				margin *= -1;

				// apply margin offset.
				$this.css( {'margin-left': margin + 'px', 'margin-right': margin + 'px'} );
			}
		}
	};

	var widthSideCalc = function() {
		var $this,
			$window,
			$content,
			windowWidth,
			x,
			margin;

		$this = $( this );

		$window  = $( window );
		$content = $( '.site-main .entry-content' );
		if ( $content.length && $window.length ) {
			// get width.
			windowWidth = $window.width();

			x      = $content.offset();
			margin = x.left;

			if ( $this.hasClass( 'alignwide' ) ) {
				margin = Math.max( ( margin - 20 ), 20 );
			}

			if ( $this.hasClass( 'wp-block-gallery' ) ) {
				margin += 8; /* 8px offset for gallery margin. */
			}

			margin *= -1;

			if ( windowWidth <= 780 ) {
				$this.css( {'margin-left':'','margin-right':''} );
			} else if ( windowWidth <= 1024 ) {
				$this.css( {'margin-left': margin + 'px','margin-right': margin + 'px'} );
			} else {
				$this.css( {'margin-left': margin + 'px','margin-right':''} );
			}
		}
	}

	var widthAlign = function() {
		$( '.no-sidebar .entry-content > .alignfull, .no-sidebar .entry-content > .alignwide' ).each( widthCalc );

		$( '.display-sidebar .entry-content > .alignfull, .display-sidebar .entry-content > .alignwide' ).each( widthSideCalc );
	};

	widthAlign();

	$( window ).resize( widthAlign );

} )( jQuery );
