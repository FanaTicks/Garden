<!DOCTYPE html>
<html>
<head>
    <title>Редагування культури</title>
</head>
<body>
<?php
$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $idCulture = intval($_GET['id']);

    if (isset($_POST['back'])) {
        header("Location: culture_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        // Update the existing culture with the data from the form
        $cultureName = $_POST['cultureName'];

        // Update the culture in the Culture table
        mysqli_query($link, "UPDATE Culture SET Name_Culture = '$cultureName' WHERE Id_Culture = $idCulture");
    } else {
        // Fetch the existing culture data to populate the form fields
        $result = mysqli_query($link, "SELECT * FROM Culture WHERE Id_Culture = $idCulture");
        $culture = mysqli_fetch_assoc($result);
        $cultureName = $culture['Name_Culture'];
    }
}
?>

<form method="post">
    <label>Назва культури:
        <input type="text" name="cultureName" required value="<?php echo $cultureName; ?>">
    </label>
    <br>
    <button name="submit" type="submit">Зберегти</button>
</form>

<form method="POST">
    <input name="back" type="submit" value="Назад">
    <input name="home_page" type="submit" value="На головну сторінку">
</form>

</body>
</html>
