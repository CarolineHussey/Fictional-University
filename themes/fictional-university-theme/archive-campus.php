<?php
    get_header(); 
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
    <iframe src="<?php echo the_field('map_location') ?>" width="600" height="450" style="border:0;" allowfullscreen=""
      loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <?php } 
    ?>
</div>

<?php
get_footer(); 
?>