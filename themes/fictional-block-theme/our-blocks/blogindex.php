<?php     pageBanner(array(
      'title' => 'University News',
      'subtitle' => 'The latest from around The University'
    ));
?>

<div class="container container--narrow page-section">
  <?php 
  while(have_posts(  )) {
    the_post(  ); ?>
  <div class="post-item">
    <h2 class="headline headline--medium headline--post-title"><a
        href="<?php esc_url(the_permalink( )); ?>"><?php the_title(); ?></a></h2>

    <div class="metabox">
      <!-- check documentation for string codes to input into the_time() to output the date/tiem in the required format. 
      add a seperator between each code render the date with a seperator-->
      <p>Posted by <?php the_author_posts_link( ); ?> on <?php the_time('n.j.y'); ?> in
        <?php echo get_the_category_list(', '); ?></p>
    </div>

    <div class="generic-content">
      <?php the_excerpt(  ); ?>
      <p><a href=" <?php esc_url(the_permalink(  )) ?>" class="btn  btn--blue">Read More</a></p>
    </div>
  </div>
  <?php }
    echo paginate_links( );
  ?>
</div>