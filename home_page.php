<?

if (isset($_COOKIE['id']) && isset($_COOKIE['hash']))
{
    if (isset($_POST['sowing'])) {
        header("Location: sowing_main.php");
    }elseif (isset($_POST['culture'])){
        header("Location: culture_main.php");
    }elseif (isset($_POST['seed'])){
        header("Location: seed_main.php");
    }

} else
{
    print "Включите куки";
}
?>

<form method="POST">
    <input name="sowing" type="submit" value="Посіви">
    <input name="culture" type="submit" value="Культури">
    <input name="seed" type="submit" value="Насіння">
    <input name="result" type="submit" value="Результати">
    <input name="analytics" type="submit" value="Аналітика">
    <input name="fertilizers_erbicides" type="submit" value="Добрива та гербіциди">
</form>