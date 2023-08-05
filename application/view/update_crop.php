<!DOCTYPE html>
<html>
<head>
    <title>Редагування посіву</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php
if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $link = mysqli_connect("localhost", "root", "admin", "Garden");
    $idSowing = intval($_GET['id']);

    if (isset($_POST['back'])) {
        header("Location: sowing_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.html");
    }

    // Fetch seed names from the Seed table
    $result = mysqli_query($link, "SELECT * FROM Seed");
    $options = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='" . $row['Id_Seed'] . "'>" . $row['Name_Seed'] . "</option>";
    }

    if (isset($_POST['submit'])) {
        // Update the existing sowing and its associated areas and lines with the data from the form

        $sowingName = $_POST['sowingName'];
        $numPlots = $_POST['numPlots'];
        $hash = $_COOKIE['hash'];
        $result = mysqli_query($link, "SELECT Id_Acount FROM Acount WHERE Hash_Acount = '$hash'");
        $idAcountRow = mysqli_fetch_assoc($result);
        $idAcount = $idAcountRow['Id_Acount'];

        // Update the sowing in the Sowing table
        mysqli_query($link, "UPDATE Sowing SET Name_Sowing = '$sowingName', Number_Of_Plots_Area = $numPlots WHERE ID_Acount = $idAcount AND Id_Sowing = $idSowing");

        // Update the areas and lines in the Area and Line tables
        // This could get complicated depending on how the data is structured and what changes are allowed
        // For now, let's assume we just delete all existing areas and lines and recreate them from the form data

        mysqli_query($link, "DELETE FROM Line WHERE ID_Area IN (SELECT ID_Area FROM Area WHERE ID_Sowing = $idSowing)");
        mysqli_query($link, "DELETE FROM Area WHERE ID_Sowing = $idSowing");

        for ($i = 0; $i < $numPlots; $i++) {
            $numLines = $_POST["numLinesPlot$i"];

            // Insert the area into the Area table
            mysqli_query($link, "INSERT INTO Area (Number_Of_Lines_Area, ID_Sowing) VALUES ($numLines, $idSowing)");

            $idArea = mysqli_insert_id($link); // Get the ID of the last inserted area

            for ($j = 0; $j < $numLines; $j++) {
                if (isset($_POST["cropLinePlot{$i}Line{$j}"])) {
                    $idSeed = $_POST["cropLinePlot{$i}Line{$j}"];
                    // Insert the line into the Line table
                    mysqli_query($link, "INSERT INTO Line (ID_Seed, ID_Area) VALUES ($idSeed, $idArea)");
                }
            }
        }
        header("Location: sowing_main.php");
        exit(); //
    } else {
        // Fetch the existing sowing data to populate the form fields
        $result = mysqli_query($link, "SELECT * FROM Sowing WHERE Id_Sowing = $idSowing");
        $sowing = mysqli_fetch_assoc($result);
        $numPlots = $sowing['Number_Of_Plots_Area'];
        $sowingName = $sowing['Name_Sowing'];

        // Fetch the existing areas and lines
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
    }
}
?>

<form id="sowingForm" method="post">
    <label>Назва засіву:
        <input type="text" name="sowingName" required value="<?php echo $sowingName; ?>">
    </label>
    <br>
    <label>Кількість ділянок:
        <input type="number" id="numPlots" name="numPlots" min="1" value="<?php echo $numPlots; ?>">
    </label>
    <button type="button" id="generatePlots">Ввести</button>

    <div id="plotsContainer">
        <?php
        if (isset($areas) && is_array($areas)) {
            foreach ($areas as $i => $area) {
                echo "<div>";
                echo "<label>Кількість рядків ділянки " . ($i + 1) . ":";
                echo "<input type='number' name='numLinesPlot$i' min='1' value='" . $area['numLines'] . "'>";
                echo "</label>";
                echo "<button type='button' class='generateLines' data-plot='$i'>Ввести</button>";
                echo "<table id='linesPlot$i'>";

                if (isset($area['lines']) && is_array($area['lines'])) {
                    foreach ($area['lines'] as $j => $idSeed) {
                        echo "<tr>";
                        echo "<td>";
                        echo "<select name='cropLinePlot{$i}Line{$j}'>";
                        // Add the options, marking the one that matches the ID of the seed as selected
                        $optionStr = str_replace("value='" . $idSeed . "'", "value='" . $idSeed . "' selected", $options);
                        echo $optionStr;
                        echo "</select>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }

                echo "</table>";
                echo "</div>";
            }
        }
        ?>
    </div>

    <button type="submit" name="submit">Зберегти</button>
</form>

<form method="POST">
    <input name="back" type="submit" value="Назад">
    <input name="home_page" type="submit" value="На головну сторінку">
</form>

<script>
    $(document).ready(function() {
        $('#generatePlots').click(function() {
            var numPlots = $('#numPlots').val();
            $('#plotsContainer').empty();

            for (var i = 0; i < numPlots; i++) {
                $('#plotsContainer').append(
                    `<div>
                        <label>Кількість рядків ділянки ${i + 1}:
                            <input type="number" name="numLinesPlot${i}" min="1">
                        </label>
                        <button type="button" class="generateLines" data-plot="${i}">Ввести</button>
                        <table id="linesPlot${i}"></table>
                    </div>`
                );
            }
        });

        $(document).on('click', '.generateLines', function() {
            var plot = $(this).data('plot');
            var numLines = $(`input[name="numLinesPlot${plot}"]`).val();
            $(`#linesPlot${plot}`).empty();

            for (var i = 0; i < numLines; i++) {
                $(`#linesPlot${plot}`).append(
                    `<tr>
                        <td>
                            <select name="cropLinePlot${plot}Line${i}">
                                <?php echo $options; ?>
                            </select>
                        </td>
                    </tr>`
                );
            }
        });
    });
</script>
</body>
</html>
