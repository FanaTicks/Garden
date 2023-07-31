<!DOCTYPE html>
<html>
<head>
    <title>Культури</title>
</head>
<body>
<?php
if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $link = mysqli_connect("localhost", "root", "admin", "Garden");

    if (isset($_POST['back'])) {
        header("Location: culture_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        $cultureName = $_POST['cultureName'];

        // Insert the culture into the Culture table
        mysqli_query($link, "INSERT INTO Culture (Name_Culture) VALUES ('$cultureName')");
    }
}
?>

<form method="post">
    <label>Назва культури:
        <input type="text" name="cultureName" required>
    </label>
    <br>
    <button name="submit" type="submit" >Зберегти</button>
</form>

<form method="POST">
    <input name="back" type="submit" value="Назад">
    <input name="home_page" type="submit" value="На головну сторінку">
</form>
</body>
</html>
