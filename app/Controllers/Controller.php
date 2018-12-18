<?php

namespace App\Controllers;

class Controller
{
    public function render($viewName, array $params = [])
    {
        $viewFile = dirname(__DIR__, 2).'/views/'.$viewName.'.php';

        if (isset($_SESSION['temporary'])) {
            extract($_SESSION['temporary'], EXTR_OVERWRITE);
            unset($_SESSION['temporary']);
        }

        extract($params, EXTR_OVERWRITE);
        ob_start();
        require $viewFile;
        $body = ob_get_clean();
        ob_end_clean();

        echo $body;

        return true;
    }

    public function redirect($location, $data = [])
    {
        $_SESSION['temporary'] = $data;
        header("Location: $location");
    }
}