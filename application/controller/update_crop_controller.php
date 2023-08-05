<?php
include '../model/new_crop_model.php';

$options = "";

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $options = getSeeds();
    if (isset($_POST['back'])) {
        header("Location: sowing_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    $options = getSeeds();

    if (isset($_POST['submit'])) {
        $sowingName = $_POST['sowingName'];
        $numPlots = $_POST['numPlots'];
        $hash = $_COOKIE['hash'];

        $idSowing = insertSowing($sowingName, $numPlots, $hash);

        for ($i = 0; $i < $numPlots; $i++) {
            $numLines = $_POST["numLinesPlot$i"];
            $idArea = insertArea($numLines, $idSowing);

            for ($j = 0; $j < $numLines; $j++) {
                $idSeed = $_POST["cropLinePlot{$i}Line{$j}"];
                insertLine($idSeed, $idArea);
            }
        }
    }
}

include '../view/new_crop.html';
?>
