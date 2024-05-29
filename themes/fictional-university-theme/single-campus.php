<?php

    get_header();

    while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>
    
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url( '/campus' ); ?>">
                <i class="fa fa-home" aria-hidden="true"></i> All Campuses </a> 
                <span class="metabox__main"><?php the_title() ?></span>
            </p>
    </div>
        
    <div class="generic-content"><?php the_content( ); ?></div>

    <?php 
        $mapLocation = get_field('map_location');
        ?>
            <div>
                <?php
                echo $mapLocation; ?> 
            </div>
    <?php 

        $relatedEvents = new WP_Query(
        array(
            'posts_per_page' => -1, // use -1 to return all 
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' =>'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => date('Ymd'),
                'type' => 'numeric' 
            ),
            array(
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID(  ) . '"', 

                )
            )
        )
        );

        if ($relatedEvents->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming Events At '. get_the_title() .' Campus</h2>';
            echo '<ul class="min-list link-list">';
            while($relatedEvents->have_posts()) {
                $relatedEvents->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php
            }
            echo '</ul>';
            }
            wp_reset_postdata(  ); 

        $relatedPrograms = new WP_Query(
        array(
            'posts_per_page' => -1, 
            'post_type' => 'program',
            'orderby' =>'title',
            'order' => 'ASC',
            'meta_query' => array(
            array(
                'key' => 'related_campus',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID(  ) . '"', 
                )
            )
        )
        );

        if ($relatedPrograms->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Programs Available At This Campus</h2>';
        echo '<ul class="min-list link-list">';
        while($relatedPrograms->have_posts()) {
            $relatedPrograms->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php
        }
        echo '</ul>';
        }

        wp_reset_postdata(  );
        
        ?>

    </div>
    <?php }

    get_footer();

?>