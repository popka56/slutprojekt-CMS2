<?php get_header(); ?>

<div class="centered-content">

  <?php if ( have_posts() ) : while ( have_posts() ) :  the_post(); ?>
      <h2><?php the_title(); ?></h2>
      <p><?php the_content(); ?></p>
    <?php endwhile; ?>
  <?php endif; ?>

</div>

 <?php get_footer(); ?>