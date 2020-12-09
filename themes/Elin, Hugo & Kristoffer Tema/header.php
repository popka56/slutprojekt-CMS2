<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Catamaran:wght@300&family=Raleway:wght@300&family=Roboto:wght@300&display=swap"
    rel="stylesheet">
  <title><?php wp_title(); ?></title>
  <?php wp_head(); ?>
  <style>
    .slide {
      height: 465px;
      width: 100%;
      display: flex;
      flex-direction: row;
      justify-content: space-around;
      align-items: center;
      margin: 40px 0;
      background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/noah-buscher.jpg');
      background-size: cover;
      background-position: center;
      color: #fff;
    }
  </style>
</head>

<body <?php body_class(); ?>>
  <header>
    <div class="main-menu">
      <div class="main-menu-icons-container">
        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-customer-50.png" alt="Log in icon"></a>
        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-search-50.png" alt="Search icon"></a>
        <a href=""><img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-shopping-cart-50.png" alt="Shopping cart icon"></a>
      </div>
      <h1>The Shoe</h1>
      <nav>
        <ul>
          <a href="javascript:viod(0);" onclick="dropdownMenu()">
            <li>Dam</li>
          </a>
          <a href="javascript:viod(0);" onclick="dropdownMenu()">
            <li>Herr</li>
          </a>
          <a href="javascript:viod(0);" onclick="dropdownMenu()">
            <li>Barn</li>
          </a>
        </ul>
      </nav>
    </div>
    <div id="dropdown-menu">
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
    </div>
    <div class="main-menu-mobile">
      <h1>The Shoe</h1>
      <div id="mobile-menu-links">
        <a href="">Dam</a>
        <a href="">Herr</a>
        <a href="">Barn</a>
        <a href="">Logga in</a>
        <a href="">Varukorg</a>
        <a href="">Sök</a>
      </div>
      <a href="javascript:viod(0);" onclick="mobileMenuShow()">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/icons8-menu-rounded-50.png" class="hamburger-icon" alt="Hamburger menu icon">
      </a>
    </div>

    <div class="slide-container">
      <div class="slide fade">
        <!-- <img src="<?php //echo get_template_directory_uri(); ?>/assets/img/noah-buscher.jpg" alt="Slideshow image"> -->
        <div class="hero-campaign">
          <h1>Säsongens kängor</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
            magna aliqua.</p>
          <a href=""><button class="button">Till kampanjen</button></a>
        </div>
        <div class="hero-discount">
          <p>FÅ 20% RABATT MED KODEN WINTER2020</p>
        </div>
      </div>

      <a href="#" class="prev" title="Previous">&#10094</a>
      <a href="#" class="next" title="Next">&#10095</a>
    </div>
  </header>