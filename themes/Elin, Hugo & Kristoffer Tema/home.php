<?php get_header(); ?>
<div class="centered-content">
  <h1 style="color: #333;"><?php single_post_title(); ?></h1> 
  <section class="section-products-blogg">
    <!-- <section class="section-products"> -->

      <?php if ( have_posts() ) : while ( have_posts() ) :  the_post(); ?>

      <!-- <section class="centered-content-section">
        <h2><?php //the_title(); ?></h2>
        <a href="<?php //the_permalink(); ?>"><?php //echo the_post_thumbnail( 'medium' ); ?></a>
        <?php //the_date(); ?>
        <?php //the_excerpt(); ?>
      </section>         -->

        <a href="<?php the_permalink(); ?>">
          <div class="blogg-card">
            <?php the_post_thumbnail('thumbnail', array('class' => 'blogg-image')); ?>
            <div class="blogg-card-content">
              <h2><?php the_title(); ?></h2>
              <p><?php the_date(); ?></p>
              <?php the_excerpt(); ?>
            </div>
          </div>
        </a>

        <?php endwhile; ?>
      <?php endif; ?>

  </section>
</div>

 <?php get_footer(); ?>