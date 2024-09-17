<?php
    pageBanner(array(
      'title' => 'Campuses',
      'subtitle' => 'Fictional University campus locations'
    ));
?>

<div class="container container--narrow page-section">

  <?php 
    while(have_posts()) {
        the_post(); 
        $mapLocation = get_field('map_location');
        ?>
  <div>
    <h3 style="font-family:Roboto;"><a href="<?php the_permalink() ?>"><?php the_title();?> </a></h3>
    <?php
                echo $mapLocation; ?>
  </div>
  <?php } 
    ?>
</div>