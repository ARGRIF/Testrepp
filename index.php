<?php

require 'application/lib/Dev.php'; // підключення

use application\core\Router; // створення псевдоніму для простору імен


spl_autoload_register(function ($class){ // спрацьовує до того як видати помилку про відсутність класу
    $path = str_replace('\\', '/', $class.'.php'); // заміна слешів для коректного шляху
    if(file_exists($path)) { // перевірка існування файла
        require $path;
    }

});


session_start();


$router = new Router;
$router->run();
