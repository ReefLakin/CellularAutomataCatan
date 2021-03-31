<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>


    <link rel="stylesheet" href="styles/hex.css">


</head>
<body>

<?php

// Opening UL tag.
echo '<ul class="hex-grid__list">';

// Pasting every hexagon via iteration.
for ($x = 1; $x <= 44; $x++) {
  echo <<< HEX
<li class="hex-grid__item">
    <div class="hex-grid__content">
        $x
    </div>
</li>
HEX;
}

// closing UL tag.
echo '</ul>';








?>

</body>
</html>
