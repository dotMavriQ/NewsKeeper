<?php
/*
Plugin Name: NewsKeeper
Plugin URI: https://dotmavriq.life
Description: Displays recent posts with options to filter by category and tag.
Version: 1.0
Author: dotMavriQ
Author URI: https://github.com/dotMavriQ
*/

if (!class_exists('WP_Widget')) {
    include_once (ABSPATH . 'wp-includes/class-wp-widget.php');
}

class NewsKeeper_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'newskeeper_widget', // Base ID
            'NewsKeeper Recent Posts', // Name
            array('description' => __('Displays recent posts filtered by category and tag.', 'text_domain'), ) // Args
        );
    }

    public function form($instance)
    {
        // Here you would add fields for admin to specify settings
        echo '<p>Configure the categories and tags to display in the widget settings.</p>';
    }

    public function update($new_instance, $old_instance)
    {
        // Here you would process and save widget options
        return $new_instance;
    }

    public function widget($args, $instance)
    {
        // Here you would output the content of the widget
        echo 'Widget content output goes here';
    }
}

function newskeeper_widget_registration()
{
    register_widget('NewsKeeper_Widget');
}
add_action('widgets_init', 'newskeeper_widget_registration');

function newskeeper_shortcode($atts)
{
    ob_start();
    newskeeper_display_posts();
    return ob_get_clean();
}
add_shortcode('NewsKeeper', 'newskeeper_shortcode');

function newskeeper_display_posts()
{
    $categories = get_categories();
    $tags = get_tags();

    // Output dropdown menus for filtering
    echo '<div id="newskeeper-filters">';
    echo '<h3>Filter by:</h3>';

    // Category dropdown
    echo '<select id="category-filter">';
    echo '<option value="">Select Category</option>';
    foreach ($categories as $category) {
        echo '<option value="cat-' . $category->term_id . '">' . $category->name . '</option>';
    }
    echo '</select>';

    // Tag dropdown
    echo '<select id="tag-filter">';
    echo '<option value="">Select Tag</option>';
    foreach ($tags as $tag) {
        echo '<option value="tag-' . $tag->term_id . '">' . $tag->name . '</option>';
    }
    echo '</select>';
    echo '</div>';

    // Output posts in a gallery format
    echo '<div id="newskeeper-posts" class="gallery">';
    $query = new WP_Query(array('posts_per_page' => -1));
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div class="post" data-categories="' . implode(' ', wp_get_post_categories(get_the_ID(), array('fields' => 'ids'))) . '" data-tags="' . implode(' ', wp_get_post_tags(get_the_ID(), array('fields' => 'ids'))) . '">';
            echo '<h4>' . get_the_title() . '</h4>';
            echo '<p>' . get_the_excerpt() . '</p>';
            echo '</div>';
        }
    }
    wp_reset_postdata();
    echo '</div>';
}

function newskeeper_enqueue_scripts()
{
    wp_enqueue_script(
        'newskeeper-script',
        plugins_url('/js/script.js', __FILE__),
        array('jquery', 'wp-api'), // Include jQuery and WP API
        '1.0',
        [
            'strategy' => 'defer',
        ]
    );

    // Localize the script with necessary data
    wp_localize_script(
        'newskeeper-script',
        'wpApiSettings',
        array(
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        )
    );

    wp_enqueue_style(
        'newskeeper-style',
        plugins_url('/css/style.css', __FILE__),
        array(),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'newskeeper_enqueue_scripts');

function newskeeper_register_rest_route()
{
    register_rest_route(
        'newskeeper/v1',
        '/filter_posts',
        array(
            'methods' => 'POST',
            'callback' => 'newskeeper_filter_posts',
            'permission_callback' => '__return_true' // For public access
        )
    );
}

add_action('rest_api_init', 'newskeeper_register_rest_route');

function newskeeper_filter_posts($request)
{
    $categoryId = $request->get_param('category_id');
    $tagId = $request->get_param('tag_id');

    $args = array(
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );

    if (!empty($categoryId)) {
        $args['cat'] = $categoryId;
    }

    if (!empty($tagId)) {
        $args['tag_id'] = $tagId;
    }

    $query = new WP_Query($args);
    $output = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="post">';
            $output .= '<h4>' . get_the_title() . '</h4>';
            $output .= '<p>' . get_the_excerpt() . '</p>';
            $output .= '</div>';
        }
    } else {
        $output = '<p>No posts found.</p>';
    }

    wp_reset_postdata();
    return $output;
}

