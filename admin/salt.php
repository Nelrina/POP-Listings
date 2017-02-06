<?php
/*
function getOptimalCost($timeTarget)
{ 
    $cost = 9;
    do {
        $cost++;
        $start = microtime(true);
        password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
        $end = microtime(true);
    } while (($end - $start) < $timeTarget);
    
    return $cost;
}

echo getOptimalCost(0.3);


$rootPath = $_SERVER['DOCUMENT_ROOT'];
$thisPath = dirname($_SERVER['PHP_SELF']);
echo $rootPath . "<br />";
echo $thisPath . "<br />";


echo $_SERVER['DOCUMENT_ROOT'] . '/' . "<br />"; // $root_path_absolute 
echo "http://{$_SERVER['HTTP_HOST']}/" . "<br />"; // $root_path_web 
echo str_replace( basename( $_SERVER['PHP_SELF'] ), '', $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'] ) . "joined/" . "<br />"; // $joined_images_dir*/

echo htmlspecialchars("lala@orange.fr");
echo htmlspecialchars("http://www.lolo.fr");
?>
