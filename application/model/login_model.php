<?php
class LoginModel {
    public function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }


    public function authenticate() {
        // Соединямся с БД
        $link = mysqli_connect("localhost", "root", "admin", "Garden");

            // Вытаскиваем из БД запись, у которой логин равняется введенному
            $query = mysqli_query($link, "SELECT Id_Acount, Password_Acount FROM Acount WHERE Login_Acount='" . mysqli_real_escape_string($link, $_POST['login']) . "' LIMIT 1");
            $data = mysqli_fetch_assoc($query);

            // Сравниваем пароли
            if ($data && $data['Password_Acount'] === md5($_POST['password'])) {
                // Генерируем случайное число и шифруем его
                $hash = md5($this->generateCode(10));

                if (!empty($_POST['not_attach_ip'])) {
                    // Если пользователь выбрал привязку к IP
                    // Переводим IP в строку
                    $insip = ", Ip_Acount=INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "')";
                }

                // Записываем в БД новый хеш авторизации и IP
                mysqli_query($link, "UPDATE Acount SET Hash_Acount='" . $hash . "' " . $insip . " WHERE Id_Acount='" . $data['Id_Acount'] . "'");

                // Ставим куки
                setcookie("id", $data['Id_Acount'], time() + 60 * 60 * 24 * 30, "/");
                setcookie("hash", $hash, time() + 60 * 60 * 24 * 30, "/", null, null, true); // httponly !!!

                // Переадресовываем браузер на страницу проверки нашего скрипта
                return "success";
            } else {
                print "Вы ввели неправильный логин/пароль";
            }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registerModel = new LoginModel();
    $response = $registerModel->authenticate();
    echo $response;
}
?>

