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
    $result = mysqli_query($link, "SELECT * FROM Sowing WHERE ID_Acount = $id");

    if (mysqli_num_rows($result) > 0) {
        // Выводим таблицу HTML
        echo "<table>";
        echo "<tr><th>Назва посіву</th><th>Деталі</th></tr>";

        // Проходимся по каждой записи результата
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Name_Sowing'] . "</td>";
            echo "<td><a href='sowing_details.php?id=" . $row['Id_Sowing'] . "'>Деталі</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "У вас немає посівів.";
    }
} else
{
    print "Включите куки";
}
?>

<form method="POST">
    <input name="add" type="submit" value="Додати новий засів">
    <input name="update" type="submit" value="Редагувати засів">
</form>