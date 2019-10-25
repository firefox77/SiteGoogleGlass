/**
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

( function($) {
	var container, button, menu, links, i, lenn, menuParent;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.setAttribute( 'aria-expanded', 'true' );
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	var menuParent = $( container ).find( '.menu-item-has-children > a, .page_item_has_children > a' );

	var menuToggleButton = $( container ).find( '.menu-toggle' );

	$( menuParent ).click(
		function( event ) {
			if ( ! $( menuToggleButton ).is( ':visible' ) ) {
				return;
			}

				$parent = $( this ).parent();
			if ( ! $parent.hasClass( 'focus' ) ) {
				$parent.toggleClass( 'focus' );
				return false;
			}
		}
	);

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container, menu ) {
		var touchStartFn, i,
			parentLinks = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' ),
			menuToggle  = $( container ).find( '.menu-toggle' ),
			links       = container.querySelectorAll( 'ul a' );
			li          = container.querySelectorAll( 'ul li' );

		if ( 'ontouchstart' in window ) {
			clickOutsideMenu = function ( event ) {
				if ( ! $( event.target ).closest( 'li.focus' ).length) {
					$( li ).removeClass( 'focus' );
					$( document ).off( 'touchstart', clickOutsideMenu );
				}
			};

			touchStartFn = function( e ) {
				if ( $( menuToggle ).is( ':visible' ) ) {
					return;
				}

				var menuItem = this.parentNode, i;
				$( document ).off( 'touchstart', clickOutsideMenu );

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
					$( document ).on( 'touchstart', clickOutsideMenu );
				}
			};

			for ( i = 0; i < parentLinks.length; ++i ) {
				parentLinks[i].addEventListener( 'click', touchStartFn, false );
			}
		}
	}( container, menu ) );

	// Prevent action of dropdowns with href="#".
	$( '.menu' ).find( 'a[href="#"]' ).click(
		function( event ) {
			return false;
		}
	);

	function anchorScroll( anchor ) {
		$anchor = $( anchor );
		if ( $anchor.length ) {
			$( 'html,body' ).animate( {scrollTop: $anchor.offset().top},'slow' );
		}
	}

	// animate scroll to anchor, and hide from address bar.
	$( '.content-widget .button, .anchor-scroll, .content-widget .div-link' ).filter( 'a[href^="#"]' ).click(
		function( event ) {
			event.preventDefault();

			anchorScroll( $( this ).attr( 'href' ) );

			return false;
		}
	);
} )( jQuery );
