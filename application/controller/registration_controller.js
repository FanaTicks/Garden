<?php
require_once 'models/registration_model.php';

class RegistrationController {
    private $model;

    public function __construct() {
        $link = mysqli_connect("localhost", "root", "admin", "Garden");
        $this->model = new RegistrationModel($link);
    }

    public function register() {
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            if ($this->model->registerUser($username, $password, $email)) {
                header("Location: login.php");
            } else {
                $error = "Не удалось зарегистрировать пользователя";
                include 'views/registration.php';
            }
        } else {
            include 'views/registration.php';
        }
    }
}
?>
