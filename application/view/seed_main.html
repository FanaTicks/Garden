<!DOCTYPE html>
<html>
<head>
    <title>Редагування насіння</title>
</head>
<body>
<?php

$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['add'])) {
        header("Location: new_seed.php");
    } elseif (isset($_POST['back'])) {
        header("Location: home_page.php");
    }

    $result = mysqli_query($link, "SELECT Seed.*, Culture.Name_Culture FROM Seed JOIN Culture ON Seed.ID_Culture = Culture.Id_Culture");

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Назва сорту насіння</th><th>Назва культури</th><th>Редагування</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Name_Seed'] . "</td>";
            echo "<td>" . $row['Name_Culture'] . "</td>";
            echo "<td><form action='update_seed.php' method='get'><button type='submit' name='id' value='" . $row['Id_Seed'] . "'>Редагувати</button></form></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "У вас немає насіння.";
    }
} else {
    print "Увімкніть кукі";
}
?>

<form method="POST">
    <input name="add" type="submit" value="Додати нове насіння">
    <input name="back" type="submit" value="Назад">
</form>
</body>
</html>
