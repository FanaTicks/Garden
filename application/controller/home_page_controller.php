<?
if (isset($_COOKIE['id']) && isset($_COOKIE['hash']))
{
    if (isset($_POST['sowing'])) {
        header("Location: ../view/sowing_main.php");
    }elseif (isset($_POST['culture'])){
        header("Location: ../view/culture_main.html");
    }elseif (isset($_POST['seed'])){
        header("Location: ../view/seed_main.html");
    }elseif (isset($_POST['fertilizers_herbicides'])){
        header("Location: ../view/fertilizers_main.html");
    }

} else
{
    print "Включите куки";
}
?>