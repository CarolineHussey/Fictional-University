<?php
    get_header(); 
    pageBanner(array(
      'title' => 'Programs',
      'subtitle' => 'Programs on offer at Fictional University'
    ));
?>

<div class="container container--narrow page-section">

  <ul class="link-list min-list">
    <?php 
  while(have_posts(  )) {
    the_post(  ); ?>
    <li><a href="<?php esc_url(the_permalink()); ?>"><?php the_title() ?></a></li>
    <?php }
    echo paginate_links( );
  ?>
  </ul>

</div>

<?php

get_footer(); 

?>