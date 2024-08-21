<?php 

require get_theme_file_path('inc/search-route.php');
require get_theme_file_path('inc/like-route.php');

function university_custom_rest() {
    register_rest_field('post', 'authorName', array(
        'get_callback' => function() {return get_the_author();}
    ));

    register_rest_field('note', 'postCount', array(
        'get_callback' => function() {return count_user_posts( get_current_user_id(), 'note');}
    ));
}

add_action('rest_api_init', 'university_custom_rest', );

function pageBanner($args = NULL) { ?>

<?php 
        if (!isset($args['title'])) {
            $args['title'] = get_the_title();
        }

        if (!isset($args['subtitle'])) {
            $args['subtitle'] = get_field('subtitle');
        }

        if (!isset($args['photo'])) {
            if (get_field('background_image')) {
                $args['photo'] = get_field('background_image')['sizes']['page-banner'];
            } else {
                $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
            }
        }
        ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
    <div class="page-banner__intro">
      <p><?php echo $args['subtitle']; ?></p>
    </div>
  </div>
</div>

<?php }
    function university_files() {
        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('university_styles_main', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_styles_additional', get_theme_file_uri('/build/index.css'));
        wp_enqueue_script('university_js_main', get_theme_file_uri('/build/index.js'), array('jquery'), '0.1', true);

        wp_localize_script('university_js_main', 'universityData', array(
            'root_url' => get_site_url(),
            'nonce' => wp_create_nonce('wp_rest')));
    }

    add_action('wp_enqueue_scripts', 'university_files');

    function university_features() {

        //add a menu item to the Wordpress admin screen to manage menus (location = value for wp_nav_menu - 'theme_location'; description = text for 'display location' on menu admin screen)
        register_nav_menu( 'footerMenuCenter', 'Footer Menu Center');
        register_nav_menu( 'footerMenuRight', 'Footer Menu Right');

        //add a title to the browser tab (In {page/post name} - {site name} format)
        add_theme_support('title-tag');

        //enable featured image
        add_theme_support('post-thumbnails');
        
        //sspecify size of images
        add_image_size('professor-landscape', 400, 260, true);
        add_image_size('professor-portrait', 460, 650, true);
        add_image_size('page-banner', 1500, 350, true);
        add_theme_support('editor-styles');
        add_editor_style(array(
            'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i',
            'build/style-index.css', 
            'build/index.css'));
    }

    function university_adjust_queries($query) {
        if (!is_admin() AND is_post_type_archive( 'program' ) AND $query->is_main_query(  )) {
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');
            $query->set('posts_per_page', -1);
        }

        if (!is_admin() AND is_post_type_archive( 'event' ) AND $query->is_main_query(  )) {
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                    array(
                      'key' => 'event_date',
                      'compare' => '>=',
                      'value' => date('Ymd'),
                      'type' => 'numeric'
                    )
                  )
                    );
        }
    }

    add_action('after_setup_theme', 'university_features');
    add_action('pre_get_posts', 'university_adjust_queries');

    //Manage subscriber-only users
    
    function redirectSubscribersToFrontend() {
        $currentUser = wp_get_current_user();

        if (count($currentUser->roles) === 1 AND $currentUser->roles[0] === 'subscriber') {
            wp_redirect(site_url('/'));
            exit;
        }
    }

    function hideAdminBarFromSubscribers() {
        $currentUser = wp_get_current_user();

        if (count($currentUser->roles) === 1 AND $currentUser->roles[0] === 'subscriber') {
            show_admin_bar(false);
        }    
    }

    add_action('admin_init', 'redirectSubscribersToFrontend');
    add_action('wp_loaded', 'hideAdminBarFromSubscribers');

    //Customise Login Screen
    function ourHeaderURL() {
        return esc_url(site_url('/'));
    }

    add_filter('login_headerurl', 'ourHeaderURL');

    add_filter('login_headertitle', 'ourLoginTitle');

    function ourLoginTitle() {
        return get_bloginfo('name');
    }

    function ourLoginCSS() {
        wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('university_styles_main', get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('university_styles_additional', get_theme_file_uri('/build/index.css'));
    }

    add_action('login_enqueue_scripts', 'ourLoginCSS');

    function setStatusToPrivate($data, $postarr) {
        if($data['post_type'] === "note") {

            if(count_user_posts( get_current_user_id(), 'note') > 6 AND !$postarr['ID']) {
                die("Limit Reached");
            }

            $data['post_content'] = sanitize_textarea_field($data['post_content']);
            $data['post_title'] = sanitize_text_field($data['post_title']);
        }

        if($data['post_type'] === "note" AND $data['post_status'] != "trash") {
            $data['post_status'] = "private";
        }
        return $data;
    }

    //Force notes to have a status of private
    add_filter('wp_insert_post_data', 'setStatusToPrivate', 10, 2);


//block theme placeholder block (editor will have a placeholder for the block rather than a wysiwyg rendered block)
class PlaceholderBlock {
    function __construct($name) {
      $this->name = $name;
      add_action('init', [$this, 'onInit']);
    }
  
    function ourRenderCallback($attributes, $content) {
      ob_start();
      require get_theme_file_path("/our-blocks/{$this->name}.php");
      return ob_get_clean();
    }
  
    function onInit() {
      wp_register_script($this->name, get_stylesheet_directory_uri() . "/our-blocks/{$this->name}.js", array('wp-blocks', 'wp-editor'));
      
      register_block_type("ourblocktheme/{$this->name}", array(
        'editor_script' => $this->name,
        'render_callback' => [$this, 'ourRenderCallback']
      ));
    }
  }

  function theme_blocks() {
    register_block_type_from_metadata( __DIR__ . '/build/footer' );
    register_block_type_from_metadata( __DIR__ . '/build/header' );
    register_block_type_from_metadata( __DIR__ . '/build/eventsandblogs' );
    register_block_type_from_metadata( __DIR__ . '/build/singlepost' );
    register_block_type_from_metadata( __DIR__ . '/build/page' );

    register_block_type_from_metadata(__DIR__ . '/build/blogindex');
    register_block_type_from_metadata(__DIR__ . '/build/programarchive');
    register_block_type_from_metadata(__DIR__ . '/build/singleprogram');
    register_block_type_from_metadata(__DIR__ . '/build/singleprofessor');
    register_block_type_from_metadata(__DIR__ . '/build/notes');
    register_block_type_from_metadata(__DIR__ . '/build/archivecampus');
    register_block_type_from_metadata(__DIR__ . '/build/archiveevent');
    register_block_type_from_metadata(__DIR__ . '/build/archive');
    register_block_type_from_metadata(__DIR__ . '/build/pastevents');
    register_block_type_from_metadata(__DIR__ . '/build/singlecampus');
    register_block_type_from_metadata(__DIR__ . '/build/singleevent');
    register_block_type_from_metadata(__DIR__ . '/build/search');
    register_block_type_from_metadata(__DIR__ . '/build/searchresults');
  }

  add_action("init", "theme_blocks");
  
  //new PlaceholderBlock("eventsandblogs");
  //new PlaceholderBlock("header");
  //new PlaceholderBlock("footer");
  
  //new PlaceholderBlock("singlepost");
  //new PlaceholderBlock("page");
  //new PlaceholderBlock("blogindex");
  //new PlaceholderBlock("programarchive");
  //new PlaceholderBlock("singleprogram");
  //new PlaceholderBlock("singleprofessor");
  //new PlaceholderBlock("notes");
  //new PlaceholderBlock("archiveevent");
  //new PlaceholderBlock("singleevent");
  //new PlaceholderBlock("archivecampus");
  //new PlaceholderBlock("singlecampus");
  //new PlaceholderBlock("search");
  //new PlaceholderBlock("searchresults");

    //block theme JSX Block (wysiwyg block is rendered in the editor as well as in the front end)
    class JSXBlock {
        function __construct($name, $renderCallback = null, $data = null) {
            $this->name = $name;
            $this->data = $data;
            $this->renderCallback = $renderCallback;
            add_action('init', [$this, 'onInit']);
        }

        function ourRenderCallback($attributes, $content) {
            ob_start();
            require get_theme_file_path("/our-blocks/{$this->name}.php");
            return ob_get_clean();
        }

        function onInit() {
            wp_register_script($this->name, get_stylesheet_directory_uri() . "/build/{$this->name}.js", array('wp-blocks', 'wp-editor',));
            if($this->data) {
                //localize_script(hook, variable name to save/access the data, output data)
                wp_localize_script($this->name, $this->name, $this->data );
            }
            $ourArgs = array(
                'editor_script' => $this->name
            );

            if ($this->renderCallback) {
                $ourArgs['render_callback'] = [$this, 'ourRenderCallback'];
            }
            register_block_type("ourblocktheme/{$this->name}", $ourArgs);

        }
    }

    new JSXBlock('banner', true, ['fallbackimage' => get_theme_file_uri('/images/library-hero.jpg')]);
    new JSXBlock('genericheading');
    new JSXBlock('genericbutton');
    new JSXBlock('slideshow', true);
    new JSXBlock('slide', true, ['themeimagepath' => get_theme_file_uri('/images/')]);

    //only allow certain block types in certain editor environments

    function allowedBlocks($allowed_block_types, $editor_context) {
        //if the user is on a post or page editor screen
        if(!empty($editor_context->post)) {
            //all block types are allowed (no restrictions)
            return $allowed_block_types;
        }
        //if user is on an FSE screen
        return array('ourblocktheme/header', "ourblocktheme/footer", "core/paragraph", "core/heading");
    }

    add_filter('allowed_block_types_all', 'allowedBlocks', 10, 2);

?>