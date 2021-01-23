<!DOCTYPE html>
<html lang='en'>

<head>
  <?php include('includes/head.php') ?>
  <meta name="description" content="Collection of letters and postcards by ANZAC Douglas Baker">
  <title>ANZAC Douglas Raymond Baker - Letters and Postcards</title>
</head>

<body>

  <header>
    <?php include('includes/header.php'); ?>
  </header>

  <nav>
    <?php include('includes/menu.php'); ?>
  </nav>






  <main>
    <div class="letters-container">
      <p>Here you will find a collection of letters written by Doug Baker over the course of his deployment during the years 1914 - 1918. Click a letter or postcard (tap if using a smart phone) to reveal the words as written by Doug. </p>

      <?php

      $file =  fopen("/home/eh1/e54061/public_html/wp/letters-home.txt", "r");

      if (($headings = fgetcsv($file, 0, "\t")) !== false) {
        while ($cells = fgetcsv($file, 0, "\t")) {
          for ($x = 1; $x < count($cells); $x++) {
            $texts[$cells[0]][$headings[$x]] = $cells[$x];
          }
        }
      }

      foreach ($texts as $key => $value) {

        if ($value['Type'] == 'Postcard') {
          echo '
          <div class="card" onclick="javascript:toggleFlip(this);">
          <div class="frontPostCard"></div>
          <div class="backPostCard">
          ';
        } elseif ($value['Type'] == 'Letter') {
          echo '
          <div class="card" onclick="javascript:toggleFlip(this);">
          <div class="frontLetter"></div>
          <div class="backLetter">
          ';
        }
        echo '<p>' . $key . '<br>';
        foreach ($value as $k => $v) {
          if ($k == 'Type' || $v == '') {
            continue;
          }
          echo str_replace("&emsp;", " ", nl2br($v) . '<br>');
        }

        echo '</p></div></div>';
      }

      fclose($file);

      ?>

    </div>

  </main>










  <footer>
    <?php include('includes/footer.php'); ?>
  </footer>

</body>

</html>