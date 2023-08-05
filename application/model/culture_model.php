<?php
require_once 'models/culture_model.php';

class CultureController {
    private $model;

    public function __construct() {
        $link = mysqli_connect("localhost", "root", "admin", "Garden");
        $this->model = new CultureModel($link);
    }

    public function mainPage() {
        if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
            // Handle various actions such as adding, editing, and deleting cultures
            // You can add specific code here based on your requirements
            // ...

            $cultures = $this->model->getAllCultures();
            include 'views/culture_main.php';
        }
    }
}
?>
