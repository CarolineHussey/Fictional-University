<?php

    get_header();

    while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>

<div class="container container--narrow page-section">
  <div class="metabox metabox--position-up metabox--with-home-link">
    <p>
      <a class="metabox__blog-home-link" href="<?php echo esc_url(site_url( '/program' )); ?>"><i class="fa fa-home"
          aria-hidden="true"></i> All Programs </a> <span class="metabox__main"><?php the_title() ?></span>
    </p>
  </div>

  <div class="generic-content">
    <p><?php the_field('main_body_content'); ?></p>
  </div>

  <?php
        $relatedProfessors = new WP_Query(
        array(
            'posts_per_page' => -1, 
            'post_type' => 'professor',
            'orderby' =>'title',
            'order' => 'ASC',
            'meta_query' => array(
            array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID(  ) . '"', 
                )
            )
        )
        );

        if ($relatedProfessors->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium"> ' . get_the_title() . ' Professors</h2>';
        echo '<ul class="professor-cards">';
        while($relatedProfessors->have_posts()) {
            $relatedProfessors->the_post(); ?>
  <li class="professor-card__list-item">
    <a class="professor-card" href="<?php esc_url(the_permalink()); ?>">
      <img class="professor-card__image" src="<?php the_post_thumbnail_url('professor-landscape'); ?>" />
      <span><?php the_title(); ?></span>
    </a>
  </li>
  <?php
        }
        echo '</ul>';
        }

        wp_reset_postdata(  );

        $homepageEvents = new WP_Query(
        array(
            'posts_per_page' => 2, // use -1 to return all 
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
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID(  ) . '"', 

                )
            )
        )
        );
        
        if ($homepageEvents->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';
        while($homepageEvents->have_posts()) {
            $homepageEvents->the_post();
            get_template_part('template-parts/content-event');
            }
        }
        wp_reset_postdata(  ); 
        $relatedCampuses = get_field('related_campus');
        if ($relatedCampuses) {
            echo '<hr class="section-break"/>';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' is available at these campuses: </h2>';
            echo '<ul class="min-list link-list">';
            foreach ($relatedCampuses as $campus) {
                ?> <li><a href="<?php echo get_the_permalink( $campus ); ?>"><?php echo get_the_title($campus); ?></a>
  </li> <?php

            }
            echo '</ul>';
        }
        wp_reset_postdata(  ); 
        ?>
</div>
<?php }

    get_footer();

?>