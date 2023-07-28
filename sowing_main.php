<?php

$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['add'])) {
        header("Location: new_crop.php");
    }elseif (isset($_POST['back'])) {
        header("Location: home_page.php");
    }

    $id = intval($_COOKIE['id']);
    $result = mysqli_query($link, "SELECT * FROM Sowing WHERE ID_Acount = $id");

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Назва посіву</th><th>Деталі</th><th>Редагування</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Name_Sowing'] . "</td>";
            echo "<td><a href='sowing_details.php?id=" . $row['Id_Sowing'] . "'>Деталі</a></td>";
            echo "<td><a href='update_crop.php?id=" . $row['Id_Sowing'] . "'>Редагувати</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "У вас немає посівів.";
    }
} else {
    print "Включите куки";
}
?>

<form method="POST">
    <input name="add" type="submit" value="Додати новий засів">
    <input name="back" type="submit" value="Назад">
</form>
