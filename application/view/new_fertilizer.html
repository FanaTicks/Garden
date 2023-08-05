<!DOCTYPE html>
<html>
<head>
    <title>Добрива</title>
</head>
<body>
<?php
if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $link = mysqli_connect("localhost", "root", "admin", "Garden");

    // Get all the cultures from the database
    $culturesResult = mysqli_query($link, "SELECT * FROM Culture");
    $cultures = mysqli_fetch_all($culturesResult, MYSQLI_ASSOC);

    if (isset($_POST['back'])) {
        header("Location: fertilizers_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        $nameFertilizer = $_POST['nameFertilizer'];
        $idCulture = $_POST['culture'];

        // Insert the fertilizer into the Fertilizers table
        mysqli_query($link, "INSERT INTO Fertilizers (Name_fertilizer, ID_Culture) VALUES ('$nameFertilizer', $idCulture)");
    }
}
?>

<form method="post">
    <label>Назва добрива:
        <input type="text" name="nameFertilizer" required>
    </label>
    <br>
    <label>Культура:
        <select name="culture">
            <?php foreach($cultures as $culture): ?>
                <option value="<?php echo $culture['Id_Culture']; ?>">
                    <?php echo $culture['Name_Culture']; ?>
                </option>
            <?php endforeach; ?>
        </select>
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
