<!DOCTYPE html>
<html>
<head>
    <title>Редагування культури</title>
</head>
<body>
<?php
$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['back'])) {
        header("Location: culture_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        // Update the existing culture with the data from the form
        $idCulture = $_POST['cultureId'];
        $cultureName = $_POST['cultureName'];

        // Update the culture in the Culture table
        mysqli_query($link, "UPDATE Culture SET Name_Culture = '$cultureName' WHERE Id_Culture = $idCulture");
    }

    // Fetch all the cultures
    $result = mysqli_query($link, "SELECT * FROM Culture");
    $cultures = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<form method="post">
    <label>Виберіть ID культури:
        <select name="cultureId" required onchange="this.form.submit()">
            <?php foreach ($cultures as $culture) : ?>
                <option value="<?php echo $culture['Id_Culture']; ?>" <?php if (isset($idCulture) && $idCulture == $culture['Id_Culture']) echo "selected"; ?>>
                    <?php echo $culture['Id_Culture']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <br>
    <label>Назва культури:
        <input type="text" name="cultureName" required value="<?php echo isset($cultureName) ? $cultureName : ''; ?>">
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
