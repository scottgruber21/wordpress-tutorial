<?php
/*
Plugin Name: Our test plugin
Description: A truly amazing plugin
Version: 1.0
Author: Scott
*/

class WordCountAndTimePlugin
{
    function __construct()
    {
        add_action('admin_menu', [
            $this,
            'adminPage'
        ]);
        add_action('admin_init', [$this, 'settings']);
    }

    function settings()
    {
        add_settings_section('wcp_first_section', null, null, 'word-count-settings-page');

        //Location
        add_settings_field('wcp_location', 'Display Location', [$this, 'locationHTML'], 'word-count-settings-page', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_location', ['sanitize_callback ' => 'sanitize_text_field', 'default' => '0']);

        //Headline Text
        add_settings_field('wcp_headline', 'Headline Text', [$this, 'headlineHTML'], 'word-count-settings-page', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_headline', ['sanitize_callback ' => 'sanitize_text_field', 'default' => 'Post Statistics']);

        //
        add_settings_field('wcp_wordcount', 'Headline Text', [$this, 'headlineHTML'], 'word-count-settings-page', 'wcp_first_section');
        register_setting('wordcountplugin', 'wcp_headline', ['sanitize_callback ' => 'sanitize_text_field', 'default' => 'Post Statistics']);
    }

    function headlineHTML()
    {
?>

        <input type="text" name="wcp_headline" value="<?= esc_attr(get_option('wcp_headline')) ?>">

    <?php
    }

    function locationHTML()
    {
    ?>
        <select name="wcp_location">
            <option value="0" <?php selected(get_option('wcp_location'), '0') ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option('wcp_location', '1')) ?>>End of post</option>
        </select>
    <?php
    }

    function adminPage()
    {
        add_options_page('Word Count Settings', 'Word Count', 'manage_options', 'word-count-settings-page', [
            $this,
            'ourHTML'
        ]);
    }

    function ourHTML()
    { ?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="POST">
                <?php
                settings_fields('wordcountplugin');
                do_settings_sections('word-count-settings-page');
                submit_button();
                ?>
            </form>
        </div>
<?php
    }
}

$wordCountAndTimePlugin = new WordCountAndTimePlugin();

?>

<!--https://youtu.be/hbJiwm5YL5Q?list=PLpcSpRrAaOaqMA4RdhSnnNcaqOVpX7qi5&t=4051-->