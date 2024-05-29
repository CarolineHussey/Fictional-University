<?php

    get_header();

    while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>
<div class="container container--narrow page-section">

  <div class="generic-content">
    <div class="row group">
      <div class="one-third"><?php the_post_thumbnail('professor-portrait'); ?></div>
      <div class="two-thirds">

        <?php 
        $likeCount = new WP_Query(array(
            'post_type' => 'like',
            'meta_query' => array(array(
                'key' => 'like_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
            )
            )
        ));

        $likeStatus = 'no';

        if(is_user_logged_in()) {
            $anyLikes = new WP_Query(array(
                'author' => get_current_user_id(),
                'post_type' => 'like',
                'meta_query' => array(array(
                    'key' => 'like_professor_id',
                    'compare' => '=',
                    'value' => get_the_ID()
                )
                )
            ));
            
            if ($anyLikes->found_posts) {
                $likeStatus = 'yes';
            }
        }

      ?>

        <span class="like-box" data-like="<?php if (isset($likeQuery->posts[0]->ID)) echo $likeQuery->posts[0]->ID; ?>"
          data-professor="<?php the_ID() ?>" data-exists="<?php echo $likeStatus; ?>">
          <i class="fa fa-heart-o" aria-hidden="true"></i>
          <i class="fa fa-heart" aria-hidden="true"></i>
          <span class="like-count"><?php echo $likeCount->found_posts;?></span>
        </span>
        <?php the_content( ); ?>
      </div>
    </div>
  </div>

  <?php 
            $relatedPrograms = get_field('related_programs');

            if ($relatedPrograms) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Subjects Taught</h2>';
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