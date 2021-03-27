<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


    <link rel="stylesheet" href="styles/bootstrap.css">

    <!-- Title -->
    <title>Cellular Automata Catan</title>

    <style>


        /* Removed from .css file due to it causing some problems. */
        body {   }
        #hexe { width: 900px; }
        #hexes {
            -webkit-transform: perspective(600px) rotateX(60deg);
            -moz-transform: perspective(600px) rotateX(60deg);
            -ms-transform: perspective(600px) rotateX(60deg);
            -o-transform: perspective(600px) rotateX(60deg);
            transform: perspective(600px) rotateX(60deg);
        }

        .hex:before {
            float: left;
            content: " ";
            width:0;
            border-right: 30px solid #559CD4;
            border-top: 52px solid transparent;
            border-bottom: 52px solid transparent;
            position: relative;
            left: -30px;
            transition: all 2.0s linear;
        }

        .hex {
            margin-right: -26px;
            margin-bottom: -50px;
            float: left;
            margin-left: 30px;
            width: 60px;
            height: 104px;
            background-color: #559CD4;
            position: relative;
            -webkit-transform: rotateY(-360deg); transform-style: preserve-3d; transition: all 2.0s linear;
        }

        .hex:after {
            float: right;
            content: "";
            position: relative;
            border-left: 30px solid #559CD4;
            border-top: 52px solid transparent;
            border-bottom: 52px solid transparent;
            left: 30px;
            transition: all 2.0s linear;
        }

        .hex-row {
            margin-right: 96px;
        }

        .even { clear: left; margin-top: 2px; margin-left: 93px;}
        .even .hex {
            margin-right: 96px;
        }






        /* Styling used for the coloured tiles. */
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

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/assets/Catan Tools Logo.png" width="65" height="65" class="d-inline-block align-center" alt="">
            catantools.co.uk
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                <a class="nav-link" href="#">Tools</a>
                <a class="nav-link" href="https://github.com/ReefLakin/CellularAutomataCatan">View On GitHub</a>
            </div>
        </div>
    </div>
</nav>

<script>
    function randomize() {
        document.getElementById("init").value = Math.floor(Math.random() * 256);
        document.getElementById("rule").value = Math.floor(Math.random() * 256);
    }
</script>


<div class="container-fluid bg-light" style="text-align: center; padding: 30px">
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="row">
            <div class="col">
                <label for="init" class="form-label">Initial Activated Cells:</label><br>
                <input type="text" class="form-control" id="init" name="init"><br>
            </div>
            <div class="col">
                <label for="rule" class="form-label">Wolfram CA Rule:</label><br>
                <input type="text" class="form-control" id="rule" name="rule">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Clear</button>
                <button type="button" onclick="randomize()" class="btn btn-warning">Randomize</button>
            </div>
        </div>
    </form>
</div>




<div class="container-fluid bg-dark">

</div>



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
if (empty($_GET["init"])) {
    $initial = decbin(88);
}
else {
    $initial = decbin((int)$_GET["init"]);
}

$concatZ = "";
if (strlen($initial) != 8) {
    for ($i = 1; $i <= 8 - strlen($initial); $i++) {
        $concatZ = $concatZ . "0";
    }
    $initial = $concatZ . $initial;
}


// Define the number representing the ECA ruleset.
// Add formatting.
if (empty($_GET["rule"])) {
    $rule = decbin(77);
}
else {
    $rule = decbin((int)$_GET["rule"]);
}


$concatZ = "";
if (strlen($rule) != 8) {
    for ($i = 1; $i <= 8 - strlen($rule); $i++) {
        $concatZ = $concatZ . "0";
    }
    $rule = $concatZ . $rule;
}


// Echo the binary value; verification purposes (disabled).
//echo $initial;


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


// Print start of above array for verification (disabled).
//echo "   ";
//echo $cells[0][0];
//echo $cells[0][1];
//echo $cells[0][2];
//echo $cells[0][3];


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
echo '<div class="container-fluid bg-dark" style="padding-bottom: 150px; padding-top: 50px; text-align: center">';
echo '    <div id="hexe">';

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
                echo '            <div class="hex hex-row imag-alive"></div>';
            }
            else {
                echo '            <div class="hex hex-row imag-dead"></div>';
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
    echo '        <br />';
    echo '        <div class="even">';
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
                echo '            <div class="hex hex-row imag-alive"></div>';
            }
            else {
                echo '            <div class="hex hex-row imag-dead"></div>';
            }
        }

        else {
            if ($cells[$rows][$cols] == 1) {
                echo '            <div class="hex hex-row real-alive"></div>';
            }
            else {
                echo '            <div class="hex hex-row real-dead"></div>';
            }
        }


    }
    echo '        </div>';
}

echo '    </div>';
echo '</div>';




?>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>
