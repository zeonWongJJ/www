<?php
spl_autoload_register('classLoader');

use JPush\Client as JPush;

$app_key = '194bf174eb98547a8e751ac3';
$master_secret = '2a1ed8a575ecc57b64e14dda';
$push_content = 'Hello World';

$client = new JPush($app_key, $master_secret);
$result = $client->push()
    ->setPlatform('all')
    ->addAlias('androidAlias')//androidAlias 别名，到时候直接用用户ID
    //->addAllAudience(['alias' => ['qidu']])
    ->setNotificationAlert($push_content)
    ->send();



function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/src/' . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
