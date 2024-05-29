<?php 
/*
Plugin Name: Word Filter
Description: Searches blog post for specified word patterns and replaces them with 'friendlier' text
Verstion: 1.0
Author: Ponyo
Author URI: https://www.google.com/ 

*/

if (! defined('ABSPATH')) exit;

class WordFilter {
    function __construct() {
        add_action('admin_menu', array($this, 'ourMenu'));
        add_action( 'admin_init', array($this, 'ourSettings'));
        add_filter('the_content', array($this, 'filterLogic'));
    }

    //add admin pages
    function ourMenu() {
        $mainPageHook = add_menu_page( 'Words to Filter', 'Word Filter', 'manage_options', 'menu-slug-word-filter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+', 100);
        /*alternative icon method load from directory (svg is 20 x 20)
        add_menu_page( 'Words to Filter', 'Word Filter', 'manage_options', 'menu-slug-word-filter', array($this, 'wordFilterPage'), plugin_dir_url(__FILE__) . 'custom.svg', 100);
        */
        add_submenu_page( 'menu-slug-word-filter', 'Words to Filter', 'Words List', 'manage_options', 'menu-slug-word-filter', array($this, 'wordFilterPage'), 101);
        add_submenu_page( 'menu-slug-word-filter', 'Word Filter Options', 'Options', 'manage_options', 'slug-word-filter-options', array($this, 'wordFilterOptionsPage'), 102);
        add_action( "load-{$mainPageHook}", array($this, 'mainPageAssets') );
    }

    //link stylesheet

    function mainPageAssets() {
        wp_enqueue_style( 'filterAdminCSS',  plugin_dir_url(__FILE__) . 'styles.css');
    }

    // Form handling

    function handleForm() {
        if (wp_verify_nonce( $_POST['ourNonce'], 'saveFilterWords' ) AND current_user_can( 'manage_options' )) {
            update_option( 'plugin-words-to-filter', sanitize_text_field( $_POST['plugin-words-to-filter'] )); ?>
            <div class="updated">
                <p>Your filtered words were saved.</p>
            </div>
        <?php } else { ?>
            <div class="error">
                <p>You do not have permission to perform that action</p> 
            </div>

        <?php }
    }

    //format page

    function wordFilterPage() { ?>
        <div class="wrap">
            <h1>Word Filter</h1>
            <?php if (isset($_POST['onSubmit']) == "true") $this->handleForm() ?>
            <form method="POST">
                <input type="hidden" name="onSubmit" value="true">
                <?php wp_nonce_field( 'saveFilterWords', 'ourNonce' )?>
                <label for="plugin-words-to-filter"><p>Enter a <strong>comma-separated</strong> list of words to filter from your site's blog content.</p></label>
                <div class="word-filter__flex-container">
                    <textarea name="plugin-words-to-filter" id="plugin-words-to-filter" placeholder="enter, all, words, that, you, want, to, filter, separated, by, commas, like, this"><?php echo esc_textarea(get_option('plugin-words-to-filter')); ?></textarea>
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </form>
        </div>

    <?php }

    //filter Logic
    function filterLogic($content) {
        $wordList = array_map('trim', explode(',', get_option( 'plugin-words-to-filter' )));
        //$trimmed = array_map('trim', $wordList);
        return str_ireplace($wordList, esc_html(get_option( 'replacementText', '****')), $content);
    }

    //settings section (subpage)

    function ourSettings() {
        add_settings_section('replacement-text-section', null, null, 'slug-word-filter-options');
        register_setting( 'replacementFields', 'replacementText' );
        add_settings_field('replacement-text', 'Filtered Text', array($this, 'formatHTML'), 'slug-word-filter-options', 'replacement-text-section');
    }

    function formatHTML() { ?>
        <input type="text" name="replacementText" value="<?php echo esc_attr(get_option('replacementText', '****'))?>">
        <p class="description">Leave blank to simply remove the word.</p>
    <?php }
    //format subpage

    function wordFilterOptionsPage() { ?>
        <div class="wrap">
            <h1>Word Filter Options</h1>
            <form action="options.php" method="POST">
                <?php 
                settings_errors( );
                settings_fields('replacementFields');
                do_settings_sections('slug-word-filter-options');
                submit_button();
                ?>
            </form>
        </div>
    <?php }
}

$wordFilter = new WordFilter();

?>