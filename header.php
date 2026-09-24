<?php
    $timer = date('Y/m/d');
?>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <br>
    <div style="width: 80%; font-size: 22; margin: 0 auto; padding: 10px; border: 2px solid #000; color: #f30; background-color: #000;">
            PlantBuddy v2.2 -> Current Date : <?php echo $timer; ?>
    </div>
    <div class='top-image' style="width:81%; margin: 0 auto; background-color: #fff; border: 2px solid #000;">
    <h1><a href="index.php"><img src="top-image.png"></img></a></h1>
    </div>

    <div style="width:81%; padding: 10px; display: flex; margin: 0 auto; align: center;">
        <div style="width:90px; padding: 10px; background-color: #fff; border: 2px solid #000;">
            <a href="index.php">Home</a>
        </div>
        <div style="width:170px; padding: 10px; background-color: #fff; border: 2px solid #000;">
            <a href="add_plant.php">Plant Controller</a>
        </div>
        <div style="width:220px; padding: 10px; background-color: #fff; border: 2px solid #000;">
            <a href="add_nutrients.php">Nutrients Controller</a>
        </div>
        <div style="width:220px; padding: 10px; background-color: #fff; border: 2px solid #000;">
            <a href="index.php">Light Controller</a>
        </div>
    </div>

    <br>
