<?php

$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['add'])) {
        header("Location: new_culture.php");
    } elseif (isset($_POST['cultureId'])) {
        $idCulture = $_POST['cultureId'];
        header("Location: update_culture.php?id=$idCulture");
    } elseif (isset($_POST['back'])) {
        header("Location: home_page.php");
    }

    $result = mysqli_query($link, "SELECT * FROM Culture");

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Назва культури</th><th>Редагування</th><th></th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Name_Culture'] . "</td>";
            echo "<td><form method='POST'><button name='cultureId' type='submit' value='" . $row['Id_Culture'] . "'>Редагувати</button></form></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "У вас немає культур.";
    }
} else {
    print "Увімкніть кукі";
}
?>

<form method="POST">
    <input name="add" type="submit" value="Додати нову культуру">
    <input name="back" type="submit" value="Назад">
</form>
