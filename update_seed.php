<!DOCTYPE html>
<html>
<head>
    <title>Редагування насіння</title>
</head>
<body>
<?php
$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    if (isset($_POST['back'])) {
        header("Location: seed_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        // Update the existing seed with the data from the form
        $idSeed = $_POST['seedId'];
        $nameSeed = $_POST['seedName'];
        $idCulture = $_POST['cultureId'];

        // Update the seed in the Seed table
        mysqli_query($link, "UPDATE Seed SET Name_Seed = '$nameSeed', ID_Culture = $idCulture WHERE Id_Seed = $idSeed");
    }

    // Fetch all the seeds
    $result = mysqli_query($link, "SELECT * FROM Seed");
    $seeds = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Fetch all the cultures
    $resultCultures = mysqli_query($link, "SELECT * FROM Culture");
    $cultures = mysqli_fetch_all($resultCultures, MYSQLI_ASSOC);
}
?>

<form method="post">
    <label>Виберіть ID насіння:
        <select name="seedId" required onchange="this.form.submit()">
            <?php foreach ($seeds as $seed) : ?>
                <option value="<?php echo $seed['Id_Seed']; ?>" <?php if (isset($idSeed) && $idSeed == $seed['Id_Seed']) echo "selected"; ?>>
                    <?php echo $seed['Id_Seed']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <br>
    <label>Назва насіння:
        <input type="text" name="seedName" required value="<?php echo isset($nameSeed) ? $nameSeed : ''; ?>">
    </label>
    <br>
    <label>Виберіть ID культури:
        <select name="cultureId" required>
            <?php foreach ($cultures as $culture) : ?>
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