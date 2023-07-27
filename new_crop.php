<!DOCTYPE html>
<html>
<head>
    <title>Посів</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php
if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $link = mysqli_connect("localhost", "root", "admin", "Garden");

// Fetch seed names from the Seed table
    $result = mysqli_query($link, "SELECT * FROM Seed");
    $options = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='" . $row['Id_Seed'] . "'>" . $row['Name_Seed'] . "</option>";
    }

    if (isset($_POST['submit'])) {


        $link = mysqli_connect("localhost", "root", "admin", "Garden");

        $sowingName = $_POST['sowingName'];
        $numPlots = $_POST['numPlots'];
        $hash = $_COOKIE['hash'];
        $result = mysqli_query($link, "SELECT Id_Acount FROM Acount WHERE Hash_Acount = '$hash'");
        $idAcountRow = mysqli_fetch_assoc($result);
        $idAcount = $idAcountRow['Id_Acount'];

// Insert the sowing into the Sowing table
        mysqli_query($link, "INSERT INTO Sowing (Name_Sowing, Number_Of_Plots_Area, ID_Acount) VALUES ('$sowingName', $numPlots , $idAcount)");

        $idSowing = mysqli_insert_id($link); // Get the ID of the last inserted sowing

        for ($i = 0; $i < $numPlots; $i++) {
            $numLines = $_POST["numLinesPlot$i"];


            // Insert the area into the Area table
            mysqli_query($link, "INSERT INTO Area (Number_Of_Lines_Area, ID_Sowing) VALUES ($numLines, $idSowing)");

            $idArea = mysqli_insert_id($link); // Get the ID of the last inserted area

            for ($j = 0; $j < $numLines; $j++) {
                $idSeed = $_POST["cropLinePlot{$i}Line{$j}"];
                // Insert the line into the Line table
                mysqli_query($link, "INSERT INTO Line (ID_Seed, ID_Area) VALUES ($idSeed, $idArea)");
            }
        }
    }
}
?>

<form id="sowingForm" method="post">
    <label>Назва засіву:
        <input type="text" name="sowingName" required>
    </label>
    <br>
    <label>Кількість ділянок:
        <input type="number" id="numPlots" name="numPlots" min="1">
    </label>
    <button type="button" id="generatePlots">Ввести</button>

    <div id="plotsContainer"></div>

    <button name="submit" type="submit" >Зберегти</button>
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
