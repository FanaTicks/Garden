<!DOCTYPE html>
<html>
<head>
    <title>Оцінювання добрива</title>
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
        // Insert the evaluation into the Evaluation table
        $assessment = $_POST['assessment'];
        $description = $_POST['description'];

        mysqli_query($link, "INSERT INTO Evaluation (ID_fertilizer, Assessment, Description) VALUES ($idFertilizer, $assessment, '$description')");
    } else {
        // Fetch the existing fertilizer data to display the name and culture
        $fertilizerResult = mysqli_query($link, "SELECT Fertilizers.*, Culture.Name_Culture FROM Fertilizers JOIN Culture ON Fertilizers.ID_Culture = Culture.Id_Culture WHERE Fertilizers.ID_fertilizer = $idFertilizer");
        $fertilizer = mysqli_fetch_assoc($fertilizerResult);
        $nameFertilizer = $fertilizer['Name_fertilizer'];
        $nameCulture = $fertilizer['Name_Culture'];
    }
}
?>

<form method="post">
    <label>Назва добрива:
        <input type="text" name="fertilizerName" readonly value="<?php echo $nameFertilizer; ?>">
    </label>
    <br>
    <label>Культура:
        <input type="text" name="cultureName" readonly value="<?php echo $nameCulture; ?>">
    </label>
    <br>
    <label>Оцінка:
        <select name="assessment" required>
            <?php for ($i = 1; $i <= 10; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </label>
    <br>
    <label>Опис/уточнення:
        <textarea name="description" required></textarea>
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
