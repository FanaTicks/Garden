<?php

$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['back'])) {
        header("Location: sowing_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.html");
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result_sowing = mysqli_query($link, "SELECT * FROM Sowing WHERE Id_Sowing = $id");
        $result_area = mysqli_query($link, "SELECT * FROM Area WHERE ID_Sowing = $id");

        if (mysqli_num_rows($result_sowing) > 0) {
$row = mysqli_fetch_assoc($result_sowing);
echo "<table>";
    echo "<tr><th>Назва посіву</th></tr>";
    echo "<tr>";
        echo "<td>" . $row['Name_Sowing'] . "</td>";
        echo "</tr>";

    $number_area = 1;
    while ($row_area = mysqli_fetch_assoc($result_area)) {
    $area_id = $row_area['Id_Area'];
    echo "<tr><th>Ділянка номер $number_area</th></tr>";
    echo "<tr>";
        echo "<td>";
            $result_line = mysqli_query($link, "SELECT Seed.Name_Seed FROM Sowing
            JOIN Area ON Sowing.Id_Sowing = Area.ID_Sowing
            JOIN Line ON Area.Id_Area = Line.ID_Area
            JOIN Seed ON Line.ID_Seed = Seed.Id_Seed
            WHERE Area.Id_Area = $area_id AND Sowing.Id_Sowing = $id");

            while ($row_line = mysqli_fetch_assoc($result_line)) {
            echo "<tr>";
        echo "<td>" . $row_line['Name_Seed'] . "</td>";
        echo "</tr>";
    }
    echo "</td>";
    echo "</tr>";
    $number_area++;
    }

    echo "</table>";
} else {
echo "Посів не знайдено";
}
} else {
echo "Не передано ID посіву.";
}
} else {
print "Включите куки";
}
?>

<form method="POST">
    <input name="back" type="submit" value="Назад">
    <input name="home_page" type="submit" value="На головну сторінку">
</form>
