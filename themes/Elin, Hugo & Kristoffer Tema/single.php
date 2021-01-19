<?php get_header(); ?>

<div class="centered-content">
  <section class="centered-content-section">
    <h1><?php $cat = single_cat_title(); echo $cat[0]->cat_name; ?></h1>
      <?php if ( have_posts() ) : while ( have_posts() ) :  the_post(); ?>
      <?php echo the_post_thumbnail( 'large' ); ?>
        <h2><?php the_title(); ?></h2>
        <?php the_date(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </section>
</div>

 <?php get_footer(); ?>