<?
// Скрипт проверки

// Соединямся с БД
$link=mysqli_connect("localhost", "root", "admin","Garden");

if (isset($_COOKIE['id']) && isset($_COOKIE['hash']))
{
    $id = intval($_COOKIE['id']);
    $hash = $_COOKIE['hash'];

    // Вытаскиваем из БД запись по id
    $query = mysqli_query($link, "SELECT *, INET_NTOA(Ip_Acount) AS Ip_Acount FROM Acount WHERE Id_Acount = $id LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    // Генерируємо хеш на основі Id_Acount і Hash_Acount з бази даних
    $hashToCheck = $userdata['Hash_Acount'];

    if ($hash === $hashToCheck && ($userdata['Ip_Acount'] === $_SERVER['REMOTE_ADDR'] || $userdata['Ip_Acount'] === "0"))
    {
        // Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: main.php");
    }
    else
    {
		
		print " $hash $hashToCheck ";
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
        
    }
}
else
{
    print "Включите куки";
}
?>
