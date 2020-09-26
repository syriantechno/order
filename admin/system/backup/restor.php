<?php
/**
 * Created by PhpStorm.
 * User: loayalshaeer
 * Date: 2020-09-05
 * Time: 04:56
 */

$connection = mysqli_connect(_serverName, _userName, _userPassword, _dbName);
$filename = 'database_' . _dbName . '.sql';
$handle = fopen($filename, "r+");
$contents = fread($handle, filesize($filename));
$sql = explode(';', $contents);
foreach ($sql as $query) {
    $result = mysqli_query($connection, $query);
    if ($result) {


        echo '
              
                   
                  
                 
             
                  ';

    }
}
fclose($handle);

