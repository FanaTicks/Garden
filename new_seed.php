<!DOCTYPE html>
<html>
<head>
    <title>Насіння</title>
</head>
<body>
<?php
if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $link = mysqli_connect("localhost", "root", "admin", "Garden");

    // Get all the cultures from the database
    $culturesResult = mysqli_query($link, "SELECT * FROM Culture");
    $cultures = mysqli_fetch_all($culturesResult, MYSQLI_ASSOC);

    if (isset($_POST['back'])) {
        header("Location: seed_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        $idSeed = $_POST['idSeed'];
        $nameSeed = $_POST['nameSeed'];
        $idCulture = $_POST['culture'];

        // Insert the seed into the Seed table
        mysqli_query($link, "INSERT INTO Seed (Id_Seed, Name_Seed, ID_Culture) VALUES ($idSeed, '$nameSeed', $idCulture)");
    }
}
?>

<form method="post">
    <label>ID Насіння:
        <input type="number" name="idSeed" required>
    </label>
    <br>
    <label>Назва насіння:
        <input type="text" name="nameSeed" required>
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
    <button name="submit" type="submit" >Зберегти</button>
</form>

<form method="POST">
    <input name="back" type="submit" value="Назад">
    <input name="home_page" type="submit" value="На головну сторінку">
</form>
</body>
</html>
