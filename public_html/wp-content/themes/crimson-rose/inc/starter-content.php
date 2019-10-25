<?php
/**
 * Starter Content
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Set starter content for fresh installs.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_starter_content() {
	$contact = '
<div class="wp-block-text-columns alignundefined columns-2">
	<div class="wp-block-column">
		<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
		<p>
			[Insert contact form 7 shortcode here]
		</p>
	</div>
	<div class="wp-block-column">
		<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/contact.jpeg" alt="" />
		</figure>
	</div>
</div>
';

	$our_story = '
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna. Praesent sit amet ligula id orci venenatis auctor. Phasellus porttitor, metus non tincidunt dapibus, orci pede pretium neque, sit amet adipiscing ipsum lectus et libero. Aenean bibendum. Curabitur mattis quam id urna. Vivamus dui. Donec nonummy lacinia lorem. Cras risus arcu, sodales ac, ultrices ac, mollis quis, justo. Sed a libero. Quisque risus erat, posuere at, tristique non, lacinia quis, eros.

<img class="alignnone" src="' . get_template_directory_uri() . '/img/starter-content/our-story-2.jpg" />

Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna. Praesent sit amet ligula id orci venenatis auctor. Phasellus porttitor, metus non tincidunt dapibus, orci pede pretium neque, sit amet adipiscing ipsum lectus et libero. Aenean bibendum. Curabitur mattis quam id urna. Vivamus dui. Donec nonummy lacinia lorem. Cras risus arcu, sodales ac, ultrices ac, mollis quis, justo. Sed a libero. Quisque risus erat, posuere at, tristique non, lacinia quis, eros.
';

	$faq = '
<h2>General Questions</h2>
<h3 class="wpm-accordion">Lorem ipsum dolor sit adipiscing elit?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Aliquam elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero in sapien elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Et adipiscing orci velit quis magna?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h2>Sales Questions</h2>
<h3 class="wpm-accordion">Lorem ipsum dolor sit adipiscing elit?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Aliquam elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero in sapien elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Et adipiscing orci velit quis magna?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h2>Product Questions</h2>
<h3 class="wpm-accordion">Lorem ipsum dolor sit adipiscing elit?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Aliquam elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero in sapien elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Et adipiscing orci velit quis magna?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h2>Other Questions</h2>
<h3 class="wpm-accordion">Lorem ipsum dolor sit adipiscing elit?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Aliquam elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Quisque convallis libero in sapien elit ante, malesuada id?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
<h3 class="wpm-accordion">Et adipiscing orci velit quis magna?</h3>
Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.
';

	$about = '
<!-- wp:heading -->
<h1>What We Sell</h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>We\'ve Got You Covered</h2>
<!-- /wp:heading -->

<!-- wp:text-columns -->
<div class="wp-block-text-columns alignundefined columns-2">
    <div class="wp-block-column">
        <p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
    </div>
    <div class="wp-block-column">
        <p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
    </div>
</div>
<!-- /wp:text-columns -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/showcase-1.jpeg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:separator -->
<hr class="wp-block-separator" />
<!-- /wp:separator -->

<!-- wp:heading {"className":"wpm-accordion"} -->
<h3 class="wpm-accordion">Visit Our Workshop and Learn<br/></h3>
<!-- /wp:heading -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/showcase-2.jpeg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio.
</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"wpm-accordion"} -->
<h3 class="wpm-accordion">Custom Orders Available Online<br/></h3>
<!-- /wp:heading -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/showcase-3.jpeg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio.
</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"wpm-accordion"} -->
<h3 class="wpm-accordion">Custom Baskets For Your Event<br/></h3>
<!-- /wp:heading -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/showcase-4.jpeg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio.
</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"wpm-accordion"} -->
<h3 id="" class="wpm-accordion">Custom Greetings and Delivery<br/></h3>
<!-- /wp:heading -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/showcase-5.jpeg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio.
</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"wpm-accordion"} -->
<h3 class="wpm-accordion">Large Selection To Choose From<br/></h3>
<!-- /wp:heading -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/showcase-6.jpeg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio.</p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator" />
<!-- /wp:separator -->

<!-- wp:heading -->
<h2>Show Off Those Products</h2>
<!-- /wp:heading -->

<!-- wp:text-columns -->
<div class="wp-block-text-columns alignundefined columns-2">
    <div class="wp-block-column">
        <p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
    </div>
    <div class="wp-block-column">
        <p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
    </div>
</div>
<!-- /wp:text-columns -->

<!-- wp:image -->
<figure class="wp-block-image"><img src="' . get_template_directory_uri() . '/img/starter-content/showcase-3.jpeg" alt="" /></figure>
<!-- /wp:image -->

<!-- wp:heading -->
<h2>Best In The Market</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>Visit Our Shop</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Donec mollis. Quisque convallis libero in sapien pharetra tincidunt. Aliquam elit ante, malesuada id, tempor eu, gravida id, odio. Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna.</p>
<!-- /wp:paragraph -->

<!-- wp:separator -->
<hr class="wp-block-separator" />
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p style="text-align:center">So what are you waiting for?! Go to our shop today. You won\'t regret it.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p style="text-align:center"><a href="">SHOP</a></p>
<!-- /wp:paragraph -->
';

	// Define and register starter content to showcase the theme on new sites.
	$starter_content['widgets']['sidebar-1'] = array(
		'crimson-rose-image-banner' => array(
			'crimson-rose-image-banner',
			array(),
		),
		'search',
		'text_about',
		'categories'                => array(
			'title'    => esc_html_x( 'Categories', 'Theme starter content', 'crimson-rose' ),
			'dropdown' => '1',
		),
	);

	$starter_content['widgets']['footer-1'] = array(
		'search'                    => array(
			'title' => esc_html_x( 'Search', 'Theme starter content', 'crimson-rose' ),
		),
		'crimson-rose-image-banner' => array(
			'crimson-rose-image-banner',
			array(
				'text_position' => 'below',
				'description'   => '',

			),
		),
	);

	$starter_content['widgets']['footer-2']['text_business_info'] = array(
		'title'  => esc_html_x( 'Find Us', 'Theme starter content', 'crimson-rose' ),
		'text'   => '<center>' . join(
			'', array(
				'<strong>' . esc_html_x( 'Address', 'Theme starter content', 'crimson-rose' ) . "</strong>\n",
				esc_html_x( '123 Main Street', 'Theme starter content', 'crimson-rose' ) . "\n" . esc_html_x( 'New York, NY 10001', 'Theme starter content', 'crimson-rose' ) . "\n\n",
				'<strong>' . esc_html_x( 'Hours', 'Theme starter content', 'crimson-rose' ) . "</strong>\n",
				esc_html_x( 'Mon&mdash;Fri: 9:00AM&ndash;5:00PM', 'Theme starter content', 'crimson-rose' ) . "\n" . esc_html_x( 'Sat &amp; Sun: 11:00AM&ndash;3:00PM', 'Theme starter content', 'crimson-rose' ),
			)
		) . '</center>',
		'filter' => true,
		'visual' => true,
	);

	$starter_content['widgets']['footer-3'] = array(
		'categories' => array(
			'title'    => esc_html_x( 'Categories', 'Theme starter content', 'crimson-rose' ),
			'dropdown' => '1',
		),
	);

	$starter_content['widgets']['footer-3']['crimson-rose-social-menu'] = array(
		'crimson-rose-social-menu',
		array(
			'title' => esc_html_x( 'Connect', 'Theme starter content', 'crimson-rose' ),
		),
	);

	$starter_content['widgets']['footer-bottom']['custom_html'] = array(
		'custom_html',
		array(
			'title'   => '',
			'content' => '<p>' . "\n\t" . esc_html_x( 'Site crafted with', 'Theme starter content', 'crimson-rose' ) . ' <i class="genericons-neue genericons-neue-heart"></i> ' . esc_html_x( 'by', 'Theme starter content', 'crimson-rose' ) . ' <a href="https://webplantmedia.com/">' . esc_html_x( 'Web Plant Media', 'Theme starter content', 'crimson-rose' ) . '</a>' . "\n" . '</p>',
		),
	);

	$starter_content['widgets']['widgetized-page']['crimson-rose-content-widget-collage'] = array(
		'crimson-rose-content-widget-collage',
		array(),
	);

	$starter_content['widgets']['widgetized-page']['crimson-rose-content-widget-callout'] = array(
		'crimson-rose-content-widget-callout',
		array(),
	);

	$starter_content['widgets']['widgetized-page']['crimson-rose-content-widget-woocommerce-products'] = array(
		'crimson-rose-content-widget-woocommerce-products',
		array(),
	);

	$starter_content['widgets']['widgetized-page']['crimson-rose-content-widget-static-content'] = array(
		'crimson-rose-content-widget-static-content',
		array(),
	);

	$starter_content['widgets']['widgetized-page']['crimson-rose-content-widget-blog-posts'] = array(
		'crimson-rose-content-widget-blog-posts',
		array(),
	);

	$starter_content['widgets']['widgetized-page']['crimson-rose-content-widget-jetpack-testimonials'] = array(
		'crimson-rose-content-widget-jetpack-testimonials',
		array(),
	);

	$starter_content['posts'] = array(
		'home'      => array(
			'template' => 'templates/widgetized-page.php',
		),
		'about'     => array(
			'post_type'    => 'page',
			'post_title'   => esc_html_x( 'About', 'Theme starter content', 'crimson-rose' ),
			'post_content' => $about,
		),
		'blog'      => array(),
		'contact'   => array(
			'template'     => 'templates/full-width-page.php',
			'post_type'    => 'page',
			'post_title'   => esc_html_x( 'Contact', 'Theme starter content', 'crimson-rose' ),
			'post_content' => $contact,
		),
		'faq'       => array(
			'post_type'    => 'page',
			'post_title'   => esc_html_x( 'FAQ', 'Theme starter content', 'crimson-rose' ),
			'post_content' => $faq,
		),
		'our-story' => array(
			'thumbnail'    => '{{image-demo-1}}',
			'post_type'    => 'page',
			'post_title'   => esc_html_x( 'Our Story', 'Theme starter content', 'crimson-rose' ),
			'post_content' => $our_story,
		),
	);

	$starter_content['attachments'] = array(
		'image-demo-1' => array(
			'post_title' => esc_html_x( 'Demo Image 1', 'Theme starter content', 'crimson-rose' ),
			'file'       => 'img/starter-content/our-story-1.jpg',
		),
	);

	$starter_content['options'] = array(
		'show_on_front'  => 'page',
		'page_on_front'  => '{{home}}',
		'page_for_posts' => '{{blog}}',
	);

	$starter_content['nav_menus']['menu-1'] = array(
		'name'  => esc_html_x( 'Primary', 'Theme starter content', 'crimson-rose' ),
		'items' => array(
			'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
			'page_about',
			'page_faq'       => array(
				'type'      => 'post_type',
				'object'    => 'page',
				'object_id' => '{{faq}}',
			),
			'page_our_story' => array(
				'type'      => 'post_type',
				'object'    => 'page',
				'object_id' => '{{our-story}}',
			),
			'page_contact',
			'page_blog',
		),
	);

	$starter_content['nav_menus']['menu-2'] = array(
		'name'  => esc_html_x( 'Top Left Menu', 'Theme starter content', 'crimson-rose' ),
		'items' => array(
			'page_blog',
			'page_about',
			'page_contact',
			'page_faq' => array(
				'type'      => 'post_type',
				'object'    => 'page',
				'object_id' => '{{faq}}',
			),
		),
	);

	$starter_content['nav_menus']['menu-3'] = array(
		'name'  => esc_html_x( 'Top Right Menu', 'Theme starter content', 'crimson-rose' ),
		'items' => array(
			'page_contact',
		),
	);

	$starter_content['nav_menus']['social'] = array(
		'name'  => esc_html_x( 'Social Links Menu', 'Theme starter content', 'crimson-rose' ),
		'items' => array(
			'link_pinterest',
			'link_facebook',
			'link_twitter',
		),
	);

	/**
	 * Filters starter content.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'crimson_rose_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'crimson_rose_starter_content' );
