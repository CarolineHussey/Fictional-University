<div class="post-item">
  <li class="professor-card__list-item">
    <a class="professor-card" href="<?php esc_url(the_permalink()); ?>">
      <img class="professor-card__image" src="<?php the_post_thumbnail_url('professor-landscape'); ?>" />
      <span><?php the_title(); ?></span>
    </a>
  </li>
</div>