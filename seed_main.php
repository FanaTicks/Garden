<?php

$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['add'])) {
        header("Location: new_seed.php");
    } elseif (isset($_POST['update'])) {
        header("Location: update_seed.php");
    } elseif (isset($_POST['back'])) {
        header("Location: home_page.php");
    }

    $result = mysqli_query($link, "SELECT * FROM Seed");

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Id_Seed</th><th>Name_Seed</th><th>ID_Culture</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Id_Seed'] . "</td>";
            echo "<td>" . $row['Name_Seed'] . "</td>";
            echo "<td>" . $row['ID_Culture'] . "</td>";
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
    <input name="update" type="submit" value="Редагувати насіння">
    <input name="back" type="submit" value="Назад">
</form>
