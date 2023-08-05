<?php
$link = mysqli_connect("localhost", "root", "admin", "Garden");
$idSowing = intval($_GET['id']);
$sowingName = $numPlots = $plotsHTML = "";

$result = mysqli_query($link, "SELECT * FROM Seed");
$options = "";
while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='" . $row['Id_Seed'] . "'>" . $row['Name_Seed'] . "</option>";
}

$optionsJson = json_encode($options);

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['back'])) {
        header("Location: sowing_main.php");
        exit;
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
        exit;
    }

    if (isset($_POST['submit'])) {
        $sowingName = $_POST['sowingName'];
        $numPlots = $_POST['numPlots'];
        $hash = $_COOKIE['hash'];
        $result = mysqli_query($link, "SELECT Id_Acount FROM Acount WHERE Hash_Acount = '$hash'");
        $idAcountRow = mysqli_fetch_assoc($result);
        $idAcount = $idAcountRow['Id_Acount'];

        mysqli_query($link, "UPDATE Sowing SET Name_Sowing = '$sowingName', Number_Of_Plots_Area = $numPlots WHERE ID_Acount = $idAcount AND Id_Sowing = $idSowing");

        mysqli_query($link, "DELETE FROM Line WHERE ID_Area IN (SELECT ID_Area FROM Area WHERE ID_Sowing = $idSowing)");
        mysqli_query($link, "DELETE FROM Area WHERE ID_Sowing = $idSowing");

        for ($i = 0; $i < $numPlots; $i++) {
            $numLines = $_POST["numLinesPlot$i"];
            mysqli_query($link, "INSERT INTO Area (Number_Of_Lines_Area, ID_Sowing) VALUES ($numLines, $idSowing)");
            $idArea = mysqli_insert_id($link);

            for ($j = 0; $j < $numLines; $j++) {
                if (isset($_POST["cropLinePlot{$i}Line{$j}"])) {
                    $idSeed = $_POST["cropLinePlot{$i}Line{$j}"];
                    mysqli_query($link, "INSERT INTO Line (ID_Seed, ID_Area) VALUES ($idSeed, $idArea)");
                }
            }
        }
    } else {
        $result = mysqli_query($link, "SELECT * FROM Sowing WHERE Id_Sowing = $idSowing");
        $sowing = mysqli_fetch_assoc($result);
        $numPlots = $sowing['Number_Of_Plots_Area'];
        $sowingName = $sowing['Name_Sowing'];

        $areas = [];
        $result = mysqli_query($link, "SELECT * FROM Area WHERE ID_Sowing = $idSowing");
        while ($row = mysqli_fetch_assoc($result)) {
            $idArea = $row['Id_Area'];
            $area = [
                'numLines' => $row['Number_Of_Lines_Area'],
                'lines' => []
            ];

            $lineResult = mysqli_query($link, "SELECT * FROM Line WHERE ID_Area = $idArea");
            while ($lineRow = mysqli_fetch_assoc($lineResult)) {
                $area['lines'][] = $lineRow['ID_Seed'];
            }

            $areas[] = $area;
        }

        $plotsHTML = '';
        if (isset($areas) && is_array($areas)) {
            foreach ($areas as $i => $area) {
                $plotsHTML .= "<div>";
                $plotsHTML .= "<label>Кількість рядків ділянки " . ($i + 1) . ":";
                $plotsHTML .= "<input type='number' name='numLinesPlot$i' min='1' value='" . $area['numLines'] . "'>";
                $plotsHTML .= "</label>";
                $plotsHTML .= "<button type='button' class='generateLines' data-plot='$i'>Ввести</button>";
                $plotsHTML .= "<table id='linesPlot$i'>";

                if (isset($area['lines']) && is_array($area['lines'])) {
                    foreach ($area['lines'] as $j => $idSeed) {
                        $plotsHTML .= "<tr>";
                        $plotsHTML .= "<td>";
                        $plotsHTML .= "<select name='cropLinePlot{$i}Line{$j}'>";
                        $optionStr = str_replace("value='" . $idSeed . "'", "value='" . $idSeed . "' selected", $options);
                        $plotsHTML .= $optionStr;
                        $plotsHTML .= "</select>";
                        $plotsHTML .= "</td>";
                        $plotsHTML .= "</tr>";
                    }
                }

                $plotsHTML .= "</table>";
                $plotsHTML .= "</div>";
            }
        }
    }
}
?>
