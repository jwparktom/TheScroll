<?php
/**
 * DA Scroll functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage DAScroll
 * @since 1.0
 */


function dascroll_setup(){
	load_theme_textdomain('dascroll');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	// add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	add_image_size('scroll-featured-image', 2000, 1200, true);

	add_image_size('scroll-thumbnail-avatar', 100, 100, true);

	// Default content width
	$GLOBALS['content_width'] = 525;

	// register_nav_menus(
	// 	array(
	// 		'top' => __('Top Menu', 'dascroll'),
	// 		'social' => __('Social Links Menu', 'dascroll'),
	// 	)
	// );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array('comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style')
	);

	/*
	 * Support for Post Formats
	 *
	 * See: https://wordpress.org/support/article/post-formats/
	 */
	add_theme_support(
		'post-formats',
		array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio')
	);

	// Default block styles
	add_theme_support('wp-block-styles');

	// Support for responsive embeds
	add_theme_support('responsive-embeds');

	// Support for excerpt
	add_post_type_support('page', 'excerpt');
}

add_action('after_setup_theme', 'dascroll_setup');


/**
 * Add preconnect for Google Fonts.
 *
 * @since DA Scroll 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function dascroll_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'dascroll-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'dascroll_resource_hints', 10, 2 );


function dascroll_custom_menus(){
	register_nav_menus(array(
		'main-menu' => 'Top Main Menu',
		'scroll-menu' => 'Top Scroll Menu',
		'more-menu' => 'Top More Menu',
		'side-post-menu' => 'Side Post Menu',
		'footer-menu' => 'Footer Menu'
		// 'tertiary' => 'Tertiary menu',
	));
}

add_action('init', 'dascroll_custom_menus');



global $post;



// add_theme_support( 'title-tag' );
// add_theme_support( 'custom-logo', array(
//     'height' => 480,
//     'width'  => 720,
// ) );

/*
*
*	CSS import
*
*/
$cssVersion = '1.0';
$cssFiles = array(
	// to be deprecated
	'normalize' => 'style/_src/normalize.min.css',
	// 'universal' => 'style/_src/universal.min.css',
	// end deprecated
	'dascroll' => 'style/dist/dascroll.min.css',
	// 'bulma' => 'style/dist/bulma.min.css',
);

foreach ($cssFiles as $name => $path){
	wp_enqueue_style($name, get_template_directory_uri().'/assets/'.$path, false, $cssVersion, 'all');
}


/*
*
* Page functions
*
*/


/**
 * Like get_template_part() put lets you pass args to the template file
 * Args are available in the tempalte as $template_args array
 * @param string filepart
 * @param mixed wp_args style argument list
 *
 * e.g. hm_get_template_part('path/to/file', ['key1' => 'val1', 'key2' => 'val2'])
 * then, access as $template_args['key1'] in path/to/file
 */
function hm_get_template_part( $file, $template_args = array(), $cache_args = array() ) {
    $template_args = wp_parse_args( $template_args );
    $cache_args = wp_parse_args( $cache_args );
    if ( $cache_args ) {
        foreach ( $template_args as $key => $value ) {
            if ( is_scalar( $value ) || is_array( $value ) ) {
                $cache_args[$key] = $value;
            } else if ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
                $cache_args[$key] = call_user_method( 'get_id', $value );
            }
        }
        if ( ( $cache = wp_cache_get( $file, serialize( $cache_args ) ) ) !== false ) {
            if ( ! empty( $template_args['return'] ) )
                return $cache;
            echo $cache;
            return;
        }
    }
    $file_handle = $file;
    do_action( 'start_operation', 'hm_template_part::' . $file_handle );
    if ( file_exists( get_stylesheet_directory() . '/' . $file . '.php' ) )
        $file = get_stylesheet_directory() . '/' . $file . '.php';
    elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) )
        $file = get_template_directory() . '/' . $file . '.php';
    ob_start();
    $return = require( $file );
    $data = ob_get_clean();
    do_action( 'end_operation', 'hm_template_part::' . $file_handle );
    if ( $cache_args ) {
        wp_cache_set( $file, $data, serialize( $cache_args ), 3600 );
    }
    if ( ! empty( $template_args['return'] ) )
        if ( $return === false )
            return false;
        else
            return $data;
    echo $data;
}

// function posts_load_more_scripts(){
// 	global $wp_query;
//
// 	// In most cases it is already included on the page and this line can be removed
// 	// wp_enqueue_script('jquery');
//
// 	// register our main script but do not enqueue it yet
// 	wp_register_script('posts_load_more', get_template_directory_uri().'/assets/js/posts-loadmore.js', array('jquery'));
//
// 	// now the most interesting part
// 	// we have to pass parameters to js script but we can get the parameters values only in PHP
// 	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
// 	wp_localize_script('posts_load_more', 'postLoadmoreParams', array(
// 		'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX
// 		// 'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
// 		'offset' => 11, // start at first offset (initial 11 posts are fetched)
// 	));
//
//  	wp_enqueue_script('posts_load_more');
// }
//
// add_action('wp_enqueue_scripts', 'posts_load_more_scripts');

function load_universal_scripts(){
	global $wp_query;
	wp_register_script('universal_scripts', get_template_directory_uri().'/assets/js/universal.js', array('jquery'));
	// wp_localize_script('universal_scripts', 'postLoadmoreParams', array(
	// 	'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX
	// 	// 'posts' => json_encode($wp_query->query_vars), // everything about your loop is here
	// 	'offset' => 11, // start at first offset (initial 11 posts are fetched)
	// ) );
	wp_enqueue_script('universal_scripts');
}

add_action('wp_enqueue_scripts', 'load_universal_scripts');

function post_load_more_ajax_handler(){
	// if (!isset($_POST['numberposts'], $_POST['category'], $_POST['offset'])) die();
  $args = array(
		'numberposts' => $_POST['numberposts'] ?: 8,
		'category' => $_POST['category'],
		'offset' => $_POST['offset'],
  );
  $posts = get_posts($args);
  $ar_posts = ['posts' => []];

	if ($posts):
		foreach ($posts as $_post):
			$thumbnail_url = get_the_post_thumbnail_url($_post);
			$has_image = $thumbnail_url ? ' has-image' : '';
			$no_image = $thumbnail_url ? '' : ' no-image';
			$thumbnail_url_style = $thumbnail_url ? ' style="background-image:url('.$thumbnail_url.')"' : '';
			$post_wrapped =
			'<article class="article'.$has_image.'">'.
			  '<div class="article__head">'.
			    '<div class="article__date">'.get_the_date('', $_post).'</div>'.
			  '</div>'.
			  '<div class="article__body">'.
			    '<div class="article__wrapper">'.
						'<a class="article__image cover'.$no_image.'" href="'.get_the_permalink($_post).'"'.$thumbnail_url_style.'></a>'.
			      '<div class="article__content">'.
			        '<div class="article__title"><a href="'.get_the_permalink($_post).'">'.get_the_title($_post).'</a></div>'.
							'<div class="article__excerpt">'.wp_trim_words(get_the_excerpt($_post), $has_image ? 30 : 40).'</div>'.
			      '</div>'.
			    '</div>'.
			  '</div>'.
			'</article>';
			$ar_posts['posts'][] = $post_wrapped;
		endforeach;
	endif;

  wp_send_json($ar_posts);
  die();
}

// $.ajax action: post_loadmore
add_action('wp_ajax_post_loadmore', 'post_load_more_ajax_handler');
add_action('wp_ajax_nopriv_post_loadmore', 'post_load_more_ajax_handler');

/*
*
* Add menu items to the admin dashboard
* https://developer.wordpress.org/reference/functions/add_menu_page/
*
*/
function register_custom_menu_pages(){
	// KEY ORDER MATTERS!
	$menus = [
		[
			'page_title' => 'Manage the Latest Edition',
			'menu_title' => 'Latest Edition',
			'capability' => 'add_users',
			'menu_slug' => 'latest_edition',
			'function' => '_latest_edition_page',
			'icon_url' => null,
			'position' => 50,
		],
	];
	foreach ($menus as $menu){
		add_menu_page(...array_values($menu));
	}
}
add_action('admin_menu', 'register_custom_menu_pages');

function _latest_edition_page(){
   echo "Manage the Latest Edition";
}

/*
*
*	Custom archive retrieve
*
*/
function wp_custom_archive($args = '') {
    global $wpdb, $wp_locale;

    $defaults = array(
      'limit' => '',
      'format' => 'html',
			'before' => '',
      'after' => '',
			'show_post_count' => false,
      'echo' => 1,
    );

    $r = wp_parse_args($args, $defaults);
    extract($r, EXTR_SKIP);

    if ($limit != '') $limit = ' LIMIT '.absint($limit);

    // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
    $archive_date_format_over_ride = 0;

    // options for daily archive (only if you over-ride the general date format)
    $archive_day_date_format = 'Y/m/d';

    // options for weekly archive (only if you over-ride the general date format)
    $archive_week_start_date_format = 'Y/m/d';
    $archive_week_end_date_format   = 'Y/m/d';

    if (!$archive_date_format_over_ride){
      $archive_day_date_format = get_option('date_format');
      $archive_week_start_date_format = get_option('date_format');
      $archive_week_end_date_format = get_option('date_format');
    }

    //filters
    $where = apply_filters('customarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
    $join = apply_filters('customarchives_join', "", $r);

    $output = '<ul>';

    $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
    $key = md5($query);
    $cache = wp_cache_get('wp_custom_archive' , 'general');

		// caching
    if (!isset($cache[$key])){
			$arcresults = $wpdb->get_results($query);
			$cache[$key] = $arcresults;
      wp_cache_set('wp_custom_archive', $cache, 'general');
    } else {
      $arcresults = $cache[$key];
    }

		// archive exists
    if ($arcresults){
      $afterafter = $after;
			$years = [];

      foreach ((array)$arcresults as $arcresult){
				$year_num = $arcresult->year;
				$month_num = $arcresult->month;

				// $year_url = get_year_link($arcresult->year);
        $month_url = get_month_link($year_num, $month_num);

        /* translators: 1: month name, 2: 4-digit year */
				$year_text = sprintf('%d', $year_num);
				$month_text = sprintf(__('%s'), $wp_locale->get_month($month_num)); // get local month name
				$month_text = $wp_locale->get_month_abbrev($month_text); // abbreviate name
				// $month_text = sprintf('%d', $month_num); // just number

				// check if year is initiated - if not, initiate it
				if (!isset($years[$year_num])) $years[$year_num] = '<li class="archive-year-group"><ul><li class="year-num">'.$year_text.'</li>';

        if ($show_post_count) $after = '&nbsp;('.$arcresult->posts.')' . $afterafter;

        // $year_output = get_archives_link($year_url, $year_text, $format, $before, $after);
				$years[$year_num] .= get_archives_link($month_url, $month_text, $format, $before, $after);
      }

			foreach ($years as $year_num => $year_output){
				$year_output .= '</ul></li>';
				$output .= $year_output;
			}
    }

    $output .= '</ul>';

    if ($echo) echo $output;
    else return $output;
}

?>
