<?php get_header(); ?>

  <div class="main-container">
    <div class="separator">Bästsäljare</div>
    <section class="section-products">

    <?php 
    // Bestsellers
      $args_bestsellers = array(
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num', 
        'tax_query'      => array( 
            array(
              'taxonomy' => 'product_cat',
              'field'    => 'slug',
              'terms'    => array( 'catalogues' ),
              'operator' => 'NOT IN'
            )
          ),
        );

      $bestsellers = new WP_Query( $args_bestsellers );

      if( $bestsellers->have_posts() ):
        while( $bestsellers->have_posts() ): $bestsellers->the_post(); 
        $bestseller = new WC_Product(get_the_ID()); ?>

          <div class="product-card">
            <a href="">
            <img src="<?php the_post_thumbnail_url(); ?>" alt="Product">
            </a>
            <p><?php the_title(); ?></p>
            <p><?php echo $bestseller->get_price_html(); ?></p>
          </div>

    <?php endwhile;
        endif; 
      wp_reset_query(); ?>
    </section>

    <div class="separator-line"></div>

    <section class="section-campaign">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/siana-goodwin.jpg" alt="Campaign photo socks">
      <a href="">
        <div class="section-campaign-content">
          <h2>Skönt för kalla fötter</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
      </a>
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/jakob-owens.jpg" alt="Campaign photo slippers">
    </section>

    <div class="separator">Rea</div>

    <section class="section-products">
      <?php
        // Show products on sale
        $args_sale = array(
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'meta_key'       => '_sale_price', 
            'orderby'        => 'meta_value_num', 
            'tax_query'      => array( 
              array(
                  'taxonomy' => 'product_cat',
                  'field'    => 'slug',
                  'terms'    => array( 'catalogues' ),
                  'operator' => 'NOT IN'
                )
              ),
            );
        
        $products_on_sale = new WP_Query( $args_sale );

        if( $products_on_sale->have_posts() ):
          while( $products_on_sale->have_posts() ): $products_on_sale->the_post(); 
            $product_on_sale = new WC_Product(get_the_ID()); ?>
          
              <div class="product-card">
                <p class="sale">25%</p>
                <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url(); ?>" alt="Product">
                </a>
                <p><?php the_title(); ?></p>
                <p class="sale"><?php echo $product_on_sale->get_price_html(); ?></p>
              </div>

          <?php endwhile;
          endif; 
        wp_reset_query(); ?>
    </section>

    <a href=""><button class="button-sale">Se all rea</button></a>
    <div class="separator">Blogginlägg</div>


    <section class="section-products-blogg">
      <?php
        // Show the latest blog posts
        $latest_blog_posts = new WP_Query('posts_per_page=3');

        if( $latest_blog_posts->have_posts() ):

        while( $latest_blog_posts->have_posts() ): $latest_blog_posts->the_post(); ?>

              <a href="<?php the_permalink(); ?>">
                <div class="blogg-card">
                  <?php the_post_thumbnail('thumbnail', array('class' => 'blogg-image')); ?>
                  <div class="blogg-card-content">
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_excerpt(); ?></p>
                  </div>
                </div>
              </a>

        <?php endwhile;
        endif; 
        wp_reset_query(); ?>
    </section>

<?php get_footer(); ?>