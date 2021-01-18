<?php get_header(); ?>

<script src='../wp-content/themes/Elin, Hugo & Kristoffer Tema/contact.js'></script>

<div class="centered-content">

  <?php if ( have_posts() ) : while ( have_posts() ) :  the_post(); ?>
      <h2><?php the_title(); ?></h2>
      <p><?php the_content(); ?></p>
    <?php endwhile; ?>
  <?php endif; ?>

  <div style="display: flex; flex-direction: column; max-width: 369px;">
    <h2 style="text-align: center;">Kontakta oss!</h2>
      <label for="title">Ärende*</label>
      <select name="title" id="title" required>
        <option value="title1">Kontakt</option>
        <option value="title2">Reklamation</option>
        <option value="title3">Faktura</option>
      </select>
      <label for="name">Namn*</label>
      <input type="text" id="name" required>
      <label for="email">E-Mail*</label>
      <input type="text" id="email" required>
      <label for="message">Meddelande*</label>
      <textarea id="message" rows="10" cols="50"></textarea required>
      <label for="myfile">Skicka med en fil (.pdf)</label>
      <input type="file" id="myfile" name="myfile">
      <br>
      <input type="submit" value="Submit" onclick="submit_form()">
      <span style="text-align: center;" id="response"></span>
  </div>

</div>

 <?php get_footer(); ?>