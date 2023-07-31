<!DOCTYPE html>
<html>
<head>
    <title>Редагування добрива</title>
</head>
<body>
<?php
$link = mysqli_connect("localhost", "root", "admin", "Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
    $idFertilizer = intval($_GET['id']);

    if (isset($_POST['back'])) {
        header("Location: fertilizers_main.php");
    } elseif (isset($_POST['home_page'])) {
        header("Location: home_page.php");
    }

    if (isset($_POST['submit'])) {
        // Update the existing fertilizer with the data from the form
        $nameFertilizer = $_POST['fertilizerName'];
        $idCulture = $_POST['cultureId'];

        // Update the fertilizer in the Fertilizers table
        mysqli_query($link, "UPDATE Fertilizers SET Name_fertilizer = '$nameFertilizer', ID_Culture = $idCulture WHERE ID_fertilizer = $idFertilizer");
    } else {
        // Fetch the existing fertilizer data to populate the form fields
        $fertilizerResult = mysqli_query($link, "SELECT * FROM Fertilizers WHERE ID_fertilizer = $idFertilizer");
        $fertilizer = mysqli_fetch_assoc($fertilizerResult);
        $nameFertilizer = $fertilizer['Name_fertilizer'];
        $idCulture = $fertilizer['ID_Culture'];
    }

    // Fetch all the cultures
    $resultCultures = mysqli_query($link, "SELECT * FROM Culture");
    $cultures = mysqli_fetch_all($resultCultures, MYSQLI_ASSOC);
}
?>

<form method="post">
    <label>Назва добрива:
        <input type="text" name="fertilizerName" required value="<?php echo $nameFertilizer; ?>">
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
