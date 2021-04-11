<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="stylesheet" href="styles/lux.css">

    <link href="styles/style.css" rel="stylesheet" type="text/css">

    <!-- Title -->
    <title>Cellular Automata Catan</title>

    <style>

        /* Styling used for the coloured tiles. */

        .real-dead {
            background-color: #8be2ef;
        }

        .real-alive {
            background-color: #70e30a;
        }

        .imag-dead {
            background-color: #bdbfba;
        }

        .imag-alive {
            background-color: #6a6e63;





    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="/assets/Catan Tools Logo.png" width="65" height="65" class="d-inline-block align-center" alt="">
            catantools.co.uk
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="https://github.com/ReefLakin/CellularAutomataCatan">View on GitHub</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Generators
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="index.php">Landmass Generator<span class="badge badge-info" style="margin-left: 5px">New</span></a></li>
                        <li><a class="dropdown-item" href="./pages/deprecated.php">Deprecated Landmass Generator</a></li>
                        <li><a class="dropdown-item" href="./pages/house.php">House Rules Generator<span class="badge badge-info" style="margin-left: 5px">New</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    function randomize() {
        document.getElementById("init").value = Math.floor(Math.random() * 256);
        document.getElementById("rule").value = Math.floor(Math.random() * 256);
    }

    function clearForms() {
        document.getElementById("init").value = "";
        document.getElementById("rule").value = "";
    }
</script>


<div class="container-fluid bg-light" style="text-align: center; padding: 30px">
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="row">
            <label for="init" class="form-label">Enter denary value of starting cells:</label><br>
            <input type="text" class="form-control" id="init" name="init" placeholder="1-255" value="<?php if (!empty($_GET["init"])) {echo $_GET["init"];} ?>"><br>
        </div>
        <br>
        <div class="row">
            <label for="rule" class="form-label">Enter your Wolfram rule:</label><br>
            <input type="text" class="form-control" id="rule" name="rule" placeholder="1-255" value="<?php if (!empty($_GET["rule"])) {echo $_GET["rule"];} ?>">
        </div>
        <br>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-dark" style="margin: 6px">Submit</button>
                <button type="button" onclick="clearForms()" class="btn btn-dark" style="margin: 6px">Clear</button>
                <button type="button" onclick="randomize()" class="btn btn-dark" style="margin: 6px">Randomize</button>
            </div>
        </div>
    </form>
</div>







<div class="container-fluid bg-dark" style="padding-top: 3%; padding-bottom: 3%;">
    <div id="hexGrid">
        <div class="hexCrop">
            <div class="hexGrid">

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
for ($rows = 0; $rows < 8; $rows++) {
    for ($cols = 0; $cols < 8; $cols++) {

        if (
            ($rows == 0 && $cols == 0) ||
            ($rows == 0 && $cols == 2) ||
            ($rows == 0 && $cols == 4) ||
            ($rows == 0 && $cols == 6) ||
            ($rows == 1 && $cols == 0) ||
            ($rows == 1 && $cols == 6) ||
            ($rows == 7 && $cols == 0) ||
            ($rows == 7 && $cols == 6) ||
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
                echo '<div class="hex imag-alive"></div>';
            }
            else {
                echo '<div class="hex imag-dead"></div>';
            }
        }
        else {
            if ($cells[$rows][$cols] == 1) {
                echo '<div class="hex real-alive"></div>';
            }
            else {
                echo '<div class="hex real-dead"></div>';
            }
        }
    }
}
?>

            </div>
        </div>
    </div>
</div>


<div class="container-fluid bg-light">
    <footer style="text-align: center; padding-top: 1%">
        <div class="row">
            <p>&copy Reef Lakin 2021 | Based upon “ CATAN,” a creation and design of Klaus Teuber and property of CATAN GmbH.</p>
        </div>
    </footer>
</div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>
