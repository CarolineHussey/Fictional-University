<?php
    get_header(); 
    pageBanner(array(
      'title' => 'Previous Events',
      'subtitle' => 'Past Events at Fictional University'
    ));

?>

<div class="container container--narrow page-section">
  <?php 

$pastEvents = new WP_Query(
    array(
        'paged' => get_query_var('paged', 1),
        'posts_per_page' => 10,
      'post_type' => 'event',
      'meta_key' => 'event_date',
      'orderby' =>'meta_value',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'event_date',
          'compare' => '<',
          'value' => date('Ymd'),
          'type' => 'numeric'
          
        )
      )
    )
  );

  while($pastEvents->have_posts(  )) {
    $pastEvents->the_post(  );
    get_template_part('template-parts/content-event');
  }
    echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
    ) );
  ?>
  <hr class="section-break">
  <p>Want to find out about our current events? Find out more <a href="<?php echo site_url( '/event') ?>">here</a>.</p>
</div>

<?php

get_footer();

?>