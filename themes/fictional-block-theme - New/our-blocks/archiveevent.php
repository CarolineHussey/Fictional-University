<?php
    pageBanner(array(
        'title' => 'Upcoming Events',
        'subtitle' => 'Upcoming Events at Fictional University'
    ));
?>

<div class="container container--narrow page-section">
  <?php 
  while(have_posts(  )) {
    the_post();
    get_template_part('template-parts/content-event');
   }
    echo paginate_links( );
  ?>
  <hr class="section-break">
  <p>Looking for past events? Check out our archive <a href="<?php echo site_url( '/past-events') ?>">here</a>.</p>

</div>