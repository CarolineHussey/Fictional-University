<?php 
/*
Plugin Name: Test Plugin
Description: Test feature development
Verstion: 1.0
Author: Ponyo
Author URI: https://www.google.com/ 
Text Domain: wcpdomain
Domain Path: /languages

*/

class TestPlugin {
    function __construct() {
        add_action('admin_menu', array($this, 'adminPage'));
        add_action('admin_init', array($this, 'settings'));
        add_filter('the_content', array($this, 'ifWrap'));
        add_action('init', array($this, 'languages'));
    }

    function languages() {
        load_plugin_textdomain('wcpdomain', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    /*
    Filter logic
    */

    function ifWrap($content) {
        if ((is_main_query() AND is_single() ) AND 
        (get_option('word_count_field', '1') 
        OR get_option('char_count_field', '1') 
        OR get_option('readtime_field', '1') )) 
        {
            return $this->formatContent($content);
        }

        return $content;

    }

    function formatContent($content) {
        $html = '<h3>' . esc_html(get_option('headline_field', 'Post Statistics')) . '</h3><p>';

        //wordcount
        $wordCount = str_word_count(strip_tags($content));
        $time = round($wordCount / 225);

        if (get_option('word_count_field', '1')) {
            $html .= esc_html(__('This post has', 'wcpdomain')) . ' ' . $wordCount . ' ' . esc_html(__('words', 'wcpdomain')) . '.<br>';
        }

        //character count

        if (get_option('char_count_field', '1')) {
            $html .= 'This post has ' . strlen(strip_tags($content)) . ' characters.<br>';
        }

        if (get_option('readtime_field', '1')) {
            $html .= $time > 2 ? 'This post will take approximately ' . $time .  ' minutes to read.<br>' : 'This post will take approximately ' . $time .  ' minute to read.<br>';
        }

        //location

        if (get_option('field_name_display_location', '0') == '0') {
            return $html . $content;
        }
        return $content . $html;
    }
    /*
    Settings actions
    */

    function settings() {
        add_settings_section( 'plugin_location_section', null, null, 'test-plugin-settings-slug' );

        add_settings_field( 'field_name_display_location', 'Display Location', array($this, 'pageSectionHTML'), 'test-plugin-settings-slug', 'plugin_location_section');
        register_setting('field_group_name', 'field_name_display_location', array('sanitize_callback' => array($this, 'sanitizeLocation'), 'default' => '0'));

        add_settings_field( 'headline_field', 'Headline', array($this, 'headlineHTML'), 'test-plugin-settings-slug', 'plugin_location_section');
        register_setting('field_group_name', 'headline_field', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));

        add_settings_field( 'word_count_field', 'Word Count', array($this, 'optionsHTML'), 'test-plugin-settings-slug', 'plugin_location_section', array('field_name' => 'word_count_field'));
        register_setting('field_group_name', 'word_count_field', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        add_settings_field( 'char_count_field', 'Character Count', array($this, 'optionsHTML'), 'test-plugin-settings-slug', 'plugin_location_section', array('field_name' => 'char_count_field'));
        register_setting('field_group_name', 'char_count_field', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));

        add_settings_field( 'readtime_field', 'Read Time', array($this, 'optionsHTML'), 'test-plugin-settings-slug', 'plugin_location_section', array('field_name' => 'readtime_field'));
        register_setting('field_group_name', 'readtime_field', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    }

    function sanitizeLocation($input) {
        if ($input != '0' AND $input != '1') {
            add_settings_error('field_name_display_location', 'error_slug', 'Error Message: The input value must be either: \'Beginning of Post\' or \'End of Post\'');
            return get_option('field_name_display_location');
        }
        return $input;
    }

    function pageSectionHTML() { ?>
<select name="field_name_display_location">
  <option value="0" <?php selected(get_option('field_name_display_location'), '0') ?>>Beginning of Post</option>
  <option value="1" <?php selected(get_option('field_name_display_location'), '1') ?>>End of Post</option>
</select>
<?php }

    function headlineHTML() { ?>
<input type="text" name="headline_field" value="<?php echo esc_attr((get_option('headline_field'))); ?>"></input>
<?php }

function optionsHTML($args) { ?>
<input type="checkbox" name=<?php echo $args['field_name'] ?> value="1"
  <?php checked(get_option($args['field_name']), '1'); ?>> </input>
<?php }

/*
Admin page setup
*/

    function adminPage() {
        add_options_page( 'Test Plugin Settings', esc_html(__('Test Plugin', 'wcpdomain')), 'manage_options', 'test-plugin-settings-slug', array($this, 'HTMLContent') );
    }
    
    function HTMLContent() { ?>
<div class="wrap"></div>
<h2>Test Plugin Settings</h2>
<form action="options.php" method="POST">
  <?php
        settings_fields( 'field_group_name' );
        do_settings_sections('test-plugin-settings-slug');
        submit_button( );
        ?>
</form>


<?php }
}

$testPlugin = new TestPlugin();

?>