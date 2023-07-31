<!DOCTYPE html>
<html>
<head>
    <title>Редагування насіння</title>
</head>
<body>
<?php
$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $idSeed = intval($_GET['id']);

    if (isset($_POST['back'])) {
        header("Location: seed_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        // Update the existing seed with the data from the form
        $nameSeed = $_POST['seedName'];
        $idCulture = $_POST['cultureId'];

        // Update the seed in the Seed table
        mysqli_query($link, "UPDATE Seed SET Name_Seed = '$nameSeed', ID_Culture = $idCulture WHERE Id_Seed = $idSeed");
    } else {
        // Fetch the existing seed data to populate the form fields
        $seedResult = mysqli_query($link, "SELECT * FROM Seed WHERE Id_Seed = $idSeed");
        $seed = mysqli_fetch_assoc($seedResult);
        $nameSeed = $seed['Name_Seed'];
        $idCulture = $seed['ID_Culture'];
    }

    // Fetch all the cultures
    $resultCultures = mysqli_query($link, "SELECT * FROM Culture");
    $cultures = mysqli_fetch_all($resultCultures, MYSQLI_ASSOC);
}
?>

<form method="post">
    <label>Назва насіння:
        <input type="text" name="seedName" required value="<?php echo $nameSeed; ?>">
    </label>
    <br>
    <label>Виберіть культуру:
        <select name="cultureId" required>
            <?php foreach ($cultures as $culture) : ?>
                <option value="<?php echo $culture['Id_Culture']; ?>" <?php if ($idCulture == $culture['Id_Culture']) echo "selected"; ?>>
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
