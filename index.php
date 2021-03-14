<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- Link to Main Stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles/styles.css">

    <!-- Title -->
    <title>Cellular Automata Catan</title>


    <style>

        .imag-dead:before {
            border-right-color: #bdbfba;
        }
        .imag-dead {
            background-color: #bdbfba;
        }
        .imag-dead:after {
            border-left-color: #bdbfba;
        }

        .imag-alive:before {
            border-right-color: #6a6e63;
        }
        .imag-alive {
            background-color: #6a6e63;
        }
        .imag-alive:after {
            border-left-color: #6a6e63;
        }

        .real-dead:before {
            border-right-color: #8be2ef;
        }
        .real-dead {
            background-color: #8be2ef;
        }
        .real-dead:after {
            border-left-color: #8be2ef;
        }

        .real-alive:before {
            border-right-color: #70e30a;
        }
        .real-alive {
            background-color: #70e30a;
        }
        .real-alive:after {
            border-left-color: #70e30a;
        }


    </style>




</head>
<body>

<!-- Hex Layout is Stolen from the legend that is MattH22: https://codepen.io/MattH22/pen/pqFLJ -->


<?php


// Function for general Elementary Cellular Automation.
function cellularQuery($ruleset, $left, $mid, $right) {
    if ($left == 1 && $mid == 1 && $right == 1) {
        return $ruleset[0];
    }
    else if ($left == 1 && $mid == 1 && $right == 0) {
        return $ruleset[1];
    }
    else if ($left == 1 && $mid == 0 && $right == 1) {
        return $ruleset[2];
    }
    else if ($left == 1 && $mid == 0 && $right == 0) {
        return $ruleset[3];
    }
    else if ($left == 0 && $mid == 1 && $right == 1) {
        return $ruleset[4];
    }
    else if ($left == 0 && $mid == 1 && $right == 0) {
        return $ruleset[5];
    }
    else if ($left == 0 && $mid == 0 && $right == 1) {
        return $ruleset[6];
    }
    else {
        return $ruleset[7];
    }
}


// The number representing the initial active cells is defined; converted to a binary string using the "decbin" function.
// Then, format correctly; concatenate with leading leading zeros if necessary.
$initial = decbin(152);
$concatZ = "";
if (strlen($initial) != 8) {
    for ($i = 1; $i <= 8 - strlen($initial); $i++) {
        $concatZ = $concatZ . "0";
    }
    $initial = $concatZ . $initial;
}


// Define the number representing the ECA ruleset.
// Add formatting.
$rule = decbin(241);
$concatZ = "";
if (strlen($rule) != 8) {
    for ($i = 1; $i <= 8 - strlen($rule); $i++) {
        $concatZ = $concatZ . "0";
    }
    $rule = $concatZ . $rule;
}


// Echo the binary value; verification purposes.
echo $initial;


// Initialise the 2-D array of hex cells.
$cells = array (
    array(substr($initial, 0, 1), substr($initial, 1, 1), substr($initial, 2, 1), substr($initial, 3, 1), substr($initial, 4, 1), substr($initial, 5, 1), substr($initial, 6, 1), substr($initial, 7, 1)),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
    array(0, 0, 0, 0, 0, 0, 0, 0),
);


// Initialise the ruleset array.
$ruleset = array(substr($rule, 0, 1), substr($rule, 1, 1), substr($rule, 2, 1), substr($rule, 3, 1), substr($rule, 4, 1), substr($rule, 5, 1), substr($rule, 6, 1), substr($rule, 7, 1));


// Print start of above array for verification.
echo "   ";
echo $cells[0][0];
echo $cells[0][1];
echo $cells[0][2];
echo $cells[0][3];


// Apply Elementary Cellular Automata rules within a 2-dimensional array.
$cellLeft = 0;
$cellMiddle = 0;
$cellRight = 0;
$subject = 0;

for ($rows = 1; $rows < 8; $rows++) {

    for ($cols = 0; $cols < 8; $cols = $cols + 2) {
        if ($cols == 0) {
            $cellLeft = $cells[$rows - 1][7];
        }
        else {
            $cellLeft = $cells[$rows - 1][$cols - 1];
        }
        $cellMiddle = $cells[$rows - 1][$cols];
        $cellRight = $cells[$rows - 1][$cols + 1];

        $subject = cellularQuery($ruleset, $cellLeft, $cellMiddle, $cellRight);
        $cells[$rows][$cols] = $subject;
    }

    for ($cols = 1; $cols < 8; $cols = $cols + 2) {
        if ($cols == 7) {
            $cellRight = $cells[$rows][0];
        }
        else {
            $cellRight = $cells[$rows][$cols + 1];
        }
        $cellMiddle = $cells[$rows - 1][$cols];
        $cellLeft = $cells[$rows][$cols - 1];

        $subject = cellularQuery($ruleset, $cellLeft, $cellMiddle, $cellRight);
        $cells[$rows][$cols] = $subject;
    }
}


// Visualise the results with HTML, CSS and PHP; front-end part.
echo '<div id="hexe">';

for ($rows = 0; $rows < 8; $rows++) {
    for ($cols = 0; $cols < 8; $cols = $cols + 2) {

        if (
            ($rows == 0 && $cols == 0) ||
            ($rows == 0 && $cols == 2) ||
            ($rows == 0 && $cols == 4) ||
            ($rows == 0 && $cols == 6) ||
            ($rows == 1 && $cols == 0) ||
            ($rows == 1 && $cols == 6) ||
            ($rows == 7 && $cols == 0) ||
            ($rows == 7 && $cols == 6)
        ) {
            if ($cells[$rows][$cols] == 1) {
                echo '        <div class="hex hex-row imag-alive"></div>';
            }
            else {
                echo '        <div class="hex hex-row imag-dead"></div>';
            }
        }
        else {
            if ($cells[$rows][$cols] == 1) {
                echo '    <div class="hex hex-row real-alive"></div>';
            }
            else {
                echo '    <div class="hex hex-row real-dead"></div>';
            }
        }



    }
    echo '    <br />';
    echo '    <div class="even">';
    for ($cols = 1; $cols < 8; $cols = $cols + 2) {

        if (
                ($rows == 0 && $cols == 1) ||
                ($rows == 0 && $cols == 5) ||
                ($rows == 0 && $cols == 7) ||
                ($rows == 1 && $cols == 7) ||
                ($rows == 2 && $cols == 7) ||
                ($rows == 3 && $cols == 7) ||
                ($rows == 4 && $cols == 7) ||
                ($rows == 5 && $cols == 7) ||
                ($rows == 6 && $cols == 7) ||
                ($rows == 7 && $cols == 1) ||
                ($rows == 7 && $cols == 5) ||
                ($rows == 7 && $cols == 7)
        ) {
            if ($cells[$rows][$cols] == 1) {
                echo '        <div class="hex hex-row imag-alive"></div>';
            }
            else {
                echo '        <div class="hex hex-row imag-dead"></div>';
            }
        }

        else {
            if ($cells[$rows][$cols] == 1) {
                echo '        <div class="hex hex-row real-alive"></div>';
            }
            else {
                echo '        <div class="hex hex-row real-dead"></div>';
            }
        }


    }
    echo '    </div>';
}

echo '</div>';




?>



<!--<div id="hexe">-->
<!--    <div class="hex hex-row real-alive"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div><br />-->
<!--    <div class="even">-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--    </div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="even">-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--    </div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="even">-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--    </div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="even">-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--    </div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="even">-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--        <div class="hex hex-row"></div>-->
<!--    </div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="even">-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--    </div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="even">-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--    </div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="hex hex-row"></div>-->
<!--    <div class="even">-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--        <div class="hex"></div>-->
<!--    </div>-->
<!--</div>-->





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>
