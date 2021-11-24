<?php
require get_theme_file_path('/includes/search-route.php');
require get_theme_file_path('/includes/like-route.php');

function university_custom_rest()
{
    register_rest_field('post', 'authorName', [
        'get_callback' => function () {
            return get_the_author();
        }
    ]);

    register_rest_field('note', 'userNoteCount', [
        'get_callback' => function () {
            return count_user_posts(get_current_user_ID(), 'note');
        }
    ]);
}

add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args = [])
{
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!$args['photo']) {
        if (get_field('page_banner_background_image') and !is_archive()) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?= $args['photo'] ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?= $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?= $args['subtitle']; ?></p>
            </div>
        </div>
    </div>
<?php

}

function university_files()
{

    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);

    wp_enqueue_script('google-map', '//maps.googleapis.com/maps/api/js?key= AIzaSyBq3EkuVjanCwcGrCKAEJ8MtyIrZkoaZBs', NULL, '1.0', true);

    wp_enqueue_script('main-university-javascript', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));

    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

    // wp_enqueue_style('font_awesome', '//use.fontawesome.com/releases/v5.15.4/css/all.css');

    wp_enqueue_style('google-font', 'fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');

    wp_localize_script('main-university-js', 'universityData', [
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ]);
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocationOne', 'Footer Location One');
    register_nav_menu('footerLocationTwo', 'Footer Location Two');
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{


    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }



    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', [
            [
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            ]
        ]);
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api)
{
    $api['key'] = 'AIzaSyBq3EkuVjanCwcGrCKAEJ8MtyIrZkoaZBs';
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');


//Redirect subscribers to homepage
function redirectSubsToFrontend()
{
    $ourCurrentUser = wp_get_current_user();

    if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
    }
}

add_action('admin_init', 'redirectSubsToFrontend');

function noSubsAdminBar()
{
    $ourCurrentUser = wp_get_current_user();

    if (count($ourCurrentUser->roles) == 1 and $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

add_action('wp_loaded', 'noSubsAdminBar');

//Customize login screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl()
{
    return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS()
{
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));

    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

    wp_enqueue_style('font_awesome', 'use.fontawesome.com/releases/v5.15.4/css/all.css');

    wp_enqueue_style('google-font', 'fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle()
{
    return get_bloginfo('name');
}

//force note posts to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr)
{
    if ($data['post_type'] == 'note') {
        if (count_user_posts(get_current_user_ID(), 'note') > 4 and !$postarr['ID']) {
            die("You have reached your note limit");
        }

        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }

    if ($data['post_type'] == 'note' and $data['post_status'] != 'trash') {
        $data['post_status'] = 'private';
    }
    return $data;
}
