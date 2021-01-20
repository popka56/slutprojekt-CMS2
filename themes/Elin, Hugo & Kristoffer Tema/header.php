<!DOCTYPE html>
<html lang="en">
<?php require('secret.php');
$apiKeyMap = getapiKeyMap();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@300&family=Raleway:wght@300&family=Roboto:wght@300&display=swap" rel="stylesheet">
  <title><?php wp_title(); ?></title>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKeyMap ?>&callback=initMap">
  </script>
  <?php wp_head(); ?>
  <script>
    let metadata;
    let map;

    fetch('http://localhost:8081/slutprojekt/wp-admin/admin-ajax.php?action=butiker')
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        // console.log(data)
        metadata = JSON.parse(JSON.stringify(data))

        let map = new google.maps.Map(document.getElementById("map"), {
          center: {
            lat: 57.78145,
            lng: 14.15618
          },
          zoom: 6,
        });

        for (i = 0; i < metadata.length; i++) {

          let marker = new google.maps.Marker({
            position: {
              lat: parseFloat(metadata[i]['latitud'][0]),
              lng: parseFloat(metadata[i]['longitud'][0])
            },
            map: map,
          });
        }
      });
  </script>
</head>

<body <?php body_class(); ?>>
  <header>
    <div class="main-menu">
      <div class="main-menu-icons-container">
        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-customer-50.png" alt="Log in icon"></a>
        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-search-50.png" alt="Search icon"></a>
        <?php //get_search_form(); ?>

          <?php 
            $url= WC()->cart->get_cart_url();
            $antal = WC()->cart->cart_contents_count;
          ?>

        <a href="<?php echo $url?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-shopping-cart-50.png" alt="Shopping cart icon">
        <?= $antal ?>
        </a>
      </div>
      <h1><a href="<?php echo get_home_url(); ?>">The Shoe</a></h1>
      <nav>
        <ul>
          <!-- <a href="javascript:viod(0);" onclick="dropdownMenu()">
            <li>Dam</li>
          </a>
          <a href="javascript:viod(0);" onclick="dropdownMenu()">
            <li>Herr</li>
          </a>
          <a href="javascript:viod(0);" onclick="dropdownMenu()">
            <li>Barn</li>
          </a> -->

          <?php
            wp_nav_menu( array(
              'theme_location' => 'main-menu',
              'menu_id' => 'main-menu',
            ) );
          ?>

        </ul>
      </nav>
    </div>
    <!-- <div id="dropdown-menu">
      <ul>
        <a href="">
          <li>Sneakers</li>
        </a>
        <a href="">
          <li>Kängor/Boots</li>
        </a>
        <a href="">
          <li>Festskor</li>
        </a>
        <a href="">
          <li>Stövlar</li>
        </a>
        <a href="">
          <li>Tofflor</li>
        </a>
      </ul>
    </div> -->
    <div class="main-menu-mobile">
      <h1>The Shoe</h1>
      <div id="mobile-menu-links">
        <!-- <a href="">Dam</a>
        <a href="">Herr</a>
        <a href="">Barn</a>
        <a href="">Logga in</a>
        <a href="">Varukorg</a>
        <a href="">Sök</a> -->

        <?php
          wp_nav_menu( array(
            'theme_location' => 'mobile-menu',
            'menu_id' => 'mobile-menu',
          ) );
        ?>

      </div>
      <a href="javascript:viod(0);" onclick="mobileMenuShow()">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-menu-rounded-50.png" class="hamburger-icon" alt="Hamburger menu icon">
      </a>
    </div>

    <?php if (have_rows('campaign_slide')) : ?>
      <div class="slide-container">

        <?php while (have_rows('campaign_slide')) : the_row();
          $image = get_sub_field('image');
        ?>

          <div class="slide fade" style="
          height: 465px;
          width: 100%;
          display: flex;
          flex-direction: row;
          justify-content: space-around;
          align-items: center;
          margin: 40px 0;
          background-image: url('<?php echo $image ?>');
          background-size: cover;
          background-position: center;
          color: #fff;
          ">

            <?php
            $heading = get_sub_field('campaign_heading');
            $content = get_sub_field('campaign_content');
            $discount = get_sub_field('discount');

            if ($heading && $content) { ?>
              <div class="hero-campaign">
                <h1><?php echo $heading ?></h1>
                <p><?php echo $content ?></p>
                <!-- <a href=""><button class="button">Till kampanjen</button></a> -->
              </div>
            <?php }

            if ($discount) { ?>
              <div class="hero-discount">
                <p><?php echo $discount ?></p>
              </div>
            <?php } ?>
          </div>
        <?php endwhile; ?>

        <a href="#" class="prev" title="Previous">&#10094</a>
        <a href="#" class="next" title="Next">&#10095</a>
      </div>
    <?php endif; ?>
  </header>