<?php
require 'Rule.php';

function returnIntensity($val) {

    $final = 0;
    $manipulate = rand(1, 100);

    if ($manipulate <= 40) {
        $final = $val;
    }
    elseif ($manipulate <= 55) {
        $final = $val + 7;
    }
    elseif ($manipulate <= 70) {
        $final = $val - 7;
    }
    elseif ($manipulate <= 80) {
        $final = $val + 18;
    }
    elseif ($manipulate <= 90) {
        $final = $val - 18;
    }
    elseif ($manipulate <= 95) {
        $final = $val + 30;
    }
    elseif ($manipulate <= 100) {
        $final = $val - 30;
    }

    if ($final <= 30) {
        return 1;
    }
    elseif ($final <= 70) {
        return 2;
    }
    else {
        return 3;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>


    <!-- Required Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <link rel="stylesheet" href="styles/bootstrap.css">

    <link href="style.css" rel="stylesheet" type="text/css">

    <!-- Title -->
    <title>Catan House Rule Generator</title>


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
                <a class="nav-link" href="index.php">Landmass Generator<span class="badge badge-secondary" style="margin-left: 5px">New</span></a>
                <a class="nav-link" href="deprecated.php">Deprecated Generator</a>
                <a class="nav-link active" aria-current="page" href="house.php">House Rule Generator<span class="badge badge-secondary" style="margin-left: 5px">New</span></a>
                <a class="nav-link" href="https://github.com/ReefLakin/CellularAutomataCatan">View On GitHub</a>
            </div>
        </div>
    </div>
</nav>

<div class="container-fluid bg-light" style="padding: 5% 15%;text-align: center">
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <fieldset>
            <legend>Generation Settings</legend>
            <label style="text-align: left" class="form-label" for="intensity">Intensity:</label>
            <input class="form-range" type="range" id="intensity" name="intensity" min="1" max="100" value="<?php if (!empty($_GET["intensity"])) {echo $_GET["intensity"];} ?>">
            <br><br>
            <button type="submit" class="btn btn-dark">Generate</button>
        </fieldset>
    </form>
</div>


<div class="container-fluid bg-dark" style="text-align: center; padding: 9%">
<?php
$rule = new Rule();
if (empty($_GET["intensity"])) {
    $rule->generateRule(returnIntensity(50));
}
else {
    $rule->generateRule(returnIntensity($_GET["intensity"]));
}

$tit = $rule->getTitle();
$tex = $rule->getText();

echo "<h2 style='color: white'>$tit</h2>";
echo "<p style='color: white'>$tex</p>";


?>

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