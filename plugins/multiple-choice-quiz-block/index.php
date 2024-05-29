<?php 
/*
Plugin Name: Multiple Choice Quiz
Description: A multiple choice quiz that can be added via Gutenberg block
Verstion: 1.0
Author: Ponyo
Author URI: https://www.google.com/ 

*/

if (! defined('ABSPATH')) exit;

class MultipleChoiceQuiz {
    function __construct() {
        add_action('init', array($this, 'adminAssets'));
    }

    function adminAssets() {
        wp_register_style('quizEditorCSS', plugin_dir_url( __FILE__ ) . 'build/index.css');
        wp_register_script('ourNewBlockType', plugin_dir_url( __FILE__ ) . 'build/index.js', array('wp-blocks', 'wp-editor', 'wp-element'));
        register_block_type('ourplugin/multiple-choice-quiz', array(
            'editor_script' => 'ourNewBlockType',
            'editor_style' => 'quizEditorCSS',
            'render_callback' => array($this, 'HTMLFrontEnd')));
    }

    function HTMLFrontEnd($attributes) {
        wp_enqueue_script('frontEndJSHandle', plugin_dir_url(__FILE__) . "build/frontend.js", array('wp-element'));
        wp_enqueue_style( 'frontEndCSSHandle', plugin_dir_url(__FILE__) . "build/frontend.css");
        ob_start(); ?>
        <div class="quiz-update-me"><pre style="display: none"><?php echo wp_json_encode($attributes)?></pre></div>
        <?php return ob_get_clean();


        //return '<h3>Our question is: ' . $attributes['question'] . ' and the answer is: ' . $attributes['answers'][3] .':)</h3>';
    }
}

$multipleChoiceQuiz = new MultipleChoiceQuiz();

?>