<?php get_header(); ?>

  <div class="main-container">
    <div class="separator">Bästsäljare</div>
    <section class="section-products">
      <div class="product-card">
        <a href=""><img src="/assets/img/ian-bevis.jpg" alt="Product"></a>
        <p>Vans - Street shoe</p>
        <p>599kr</p>
      </div>

      <div class="product-card">
        <a href=""><img src="/assets/img/ian-bevis.jpg" alt="Product"></a>
        <p>Vans - Street shoe</p>
        <p>599kr</p>
      </div>

      <div class="product-card">
        <a href=""><img src="/assets/img/ian-bevis.jpg" alt="Product"></a>
        <p>Vans - Street shoe</p>
        <p>599kr</p>
      </div>

      <div class="product-card">
        <a href=""><img src="/assets/img/ian-bevis.jpg" alt="Product"></a>
        <p>Vans - Street shoe</p>
        <p>599kr</p>
      </div>
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
      <div class="product-card">
        <p class="sale">25%</p>
        <a href=""><img src="/assets/img/ian-bevis.jpg" alt="Product">
        </a>
        <p>Vans - Street shoe</p>
        <p>599kr<span class="sale">449kr</span></p>
      </div>

      <div class="product-card">
        <p class="sale">25%</p>
        <img src="/assets/img/sneaker-2768733_640.png" alt="Product">
        <p>Vans - Street shoe</p>
        <p>599kr<span class="sale">449kr</span></p>
      </div>

      <div class="product-card">
        <p class="sale">25%</p>
        <img src="/assets/img/shoe-629643_640.jpg" alt="Product">
        <p>Vans - Street shoe</p>
        <p>599kr<span class="sale">449kr</span></p>
      </div>

      <div class="product-card">
        <p class="sale">25%</p>
        <img src="/assets/img/running-shoe-371625_640.jpg" alt="Product">
        <p>Vans - Street shoe</p>
        <p>599kr<span class="sale">449kr</span></p>
      </div>
    </section>

    <a href=""><button class="button-sale">Se all rea</button></a>
    <div class="separator">Blogginlägg</div>


    <section class="section-products-blogg">
        <?php
        while(have_posts()){
            the_post(); ?>

              <a href="<?php the_permalink(); ?>">
                <div class="blogg-card">
                  <?php the_post_thumbnail('thumbnail', array('class' => 'blogg-image')); ?>
                  <div class="blogg-card-content">
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_content(); ?></p>
                  </div>
                </div>
              </a>

          <?php } ?>
    </section>

<?php get_footer(); ?>