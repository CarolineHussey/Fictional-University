<?php

    get_header();

    while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>
        <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
            <a class="metabox__blog-home-link" href="<?php echo site_url( '/event' ); ?>"><i class="fa fa-home" aria-hidden="true"></i> Events Home </a> <span class="metabox__main"><?php the_title() ?></span>
            </p>
        </div>

        <div class="generic-content"><?php the_content( ); ?></div>

        <?php 

        $relatedCampuses = get_field('related_campus');
        if ($relatedCampuses) {
        echo '<hr class="section-break"/>';
        echo '<h3 class="headline headline--small">The ' . get_the_title() . ' event will take place at our ';
        foreach ($relatedCampuses as $campus) {
            ?> <a href="<?php echo get_the_permalink( $campus ); ?>"><?php echo get_the_title($campus); ?></a> <?php
            echo 'campus.</h3>';

        }
        }

            $relatedPrograms = get_field('related_programs');

            if ($relatedPrograms) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Related Programs</h2>';
                echo '<ul class="link-list min-list">';

                foreach ($relatedPrograms as $program) { ?>
                    <li><a href="<?php echo get_the_permalink( $program )?>"><?php echo get_the_title( $program ); ?></a></li>
                <?php }
                echo '</ul>';
            }
        ?>
    </div>
    <?php }

    get_footer();

?>