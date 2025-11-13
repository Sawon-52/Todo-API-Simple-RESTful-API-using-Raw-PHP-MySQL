
<?php

require_once __DIR__ . '/../autoload.php';

use App\Core\Router;
// use App\Core\Database;

$router = new Router();
// $router->setDatabase($db)

$router->get('api/users', 'UserController@index');
$router->post('api/users', 'UserController@store');
// রুট প্যারামিটার হ্যান্ডলিং-এর জন্য Router ক্লাস-কে আরো উন্নত করতে হবে (যেমন, /api/users/1)

// রিকোয়েস্ট ডিসপ্যাচ করা (Best Practice অনুযায়ী রেসপন্স এখানেই তৈরি হবে)
$router->dispatch();