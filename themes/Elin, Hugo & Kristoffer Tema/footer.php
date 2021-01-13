
    <footer class="footer" style="background-color: <?php the_field('bakgrundsfarg', 'option');?>">
      <div class="customer-service-container">
        <h3>KUNDTJÄNST</h3>
        <ul>
           <?php
              wp_nav_menu( array(
                'theme_location' => 'footer-menu',
                'menu_id' => 'footer-menu',
              ) );
            ?>
        </ul>
        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-instagram-50.png" alt=""></a>
        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-facebook-50.png" alt=""></a>
      </div>
      <div class="member-container">
        <h3>GÅ MED I VÅR KUNDKLUBB</h3>
        <p>Ta del av fina erbjudanden och var först med det senaste</p>
        <a href=""><button class="button">Ja tack!</button></a>
      </div>
    </footer>

  </div>
  <?php wp_footer(); ?>
</body>

</html>