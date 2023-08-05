<!DOCTYPE html>
<html>
<head>
    <title>Редагування добрив</title>
</head>
<body>
<?php

$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['add'])) {
        header("Location: new_fertilizer.php");
    } elseif (isset($_POST['back'])) {
        header("Location: home_page.php");
    }

    $result = mysqli_query($link, "SELECT Fertilizers.*, Culture.Name_Culture FROM Fertilizers JOIN Culture ON Fertilizers.ID_Culture = Culture.Id_Culture");

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Назва добрива</th><th>Назва культури</th><th>Редагування</th><th>Оцінювання</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Name_fertilizer'] . "</td>";
            echo "<td>" . $row['Name_Culture'] . "</td>";
            echo "<td><form action='update_fertilizer.php' method='get'><button type='submit' name='id' value='" . $row['ID_fertilizer'] . "'>Редагувати</button></form></td>";
            echo "<td><form action='fertilizer_evaluation.php' method='get'><button type='submit' name='id' value='" . $row['ID_fertilizer'] . "'>Оцінити</button></form></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "У вас немає добрив.";
    }
} else {
    print "Увімкніть кукі";
}
?>

<form method="POST">
    <input name="add" type="submit" value="Додати нове добриво">
    <input name="back" type="submit" value="Назад">
</form>
</body>
</html>
