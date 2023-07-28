<?

// Соединямся с БД
$link=mysqli_connect("localhost", "root", "admin","Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash']))
{
    if (isset($_POST['add'])) {
        header("Location: new_crop.php");
    }elseif (isset($_POST['update'])){
        header("Location: update_crop.php");
    }
    $id = intval($_COOKIE['id']);
    $result_sowing = mysqli_query($link, "SELECT * FROM Sowing WHERE Id_Sowing = $id");
    $result_area = mysqli_query($link, "SELECT * FROM Area WHERE ID_Sowing = $id");
    $result_line = mysqli_query($link, "SELECT Seed.Name_Seed FROM Sowing
                                              JOIN Area ON Sowing.Id_Sowing = Area.ID_Sowing
                                              JOIN Line ON Area.Id_Area = Line.ID_Area
                                              JOIN Seed ON Line.ID_Seed = Seed.Id_Seed
                                              WHERE Sowing.Id_Sowing = $id");

    if (mysqli_num_rows($result_sowing) > 0) {
        // Выводим таблицу HTML
        $row = mysqli_fetch_assoc($result_sowing);
        echo "<table>";
        echo "<tr><th>Назва посіву</th></tr>";
        echo "<tr>";
        echo "<td>" . $row['Name_Sowing'] . "</td>";
        echo "</tr>";
        // Проходимся по каждой записи результата
        while ($row_area = mysqli_fetch_assoc($result_area)) {
            $number_area=1;
            echo "<table>";
            echo "<tr><th>Ділянка номер $number_area</th></tr>";
            echo "<tr>";
            echo "<td>";
            while ($row_line = mysqli_fetch_assoc($result_line)) {
                echo "<tr>";
                echo "<td>" . $row_line['Name_Seed'] . "</td>";
                echo "</tr>";
            }
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            $number_area++;
        }

        echo "</table>";
    } else {
        echo "Посів не знайдено";
    }
} else
{
    print "Включите куки";
}
?>