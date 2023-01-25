<?php
define('DB_HOST', 'std-mysql'); //Адрес
define('DB_USER', 'std_2006_colorsall'); //Имя пользователя
define('DB_PASSWORD', '26072003'); //Пароль
define('DB_NAME', 'std_2006_colorsall'); //Имя БД
$mysql = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);


$claster = 5;



echo'
<!DOCTYPE HTML>
<html id="App_interface">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MyApp</title>
<script src="/UpdateScript.js"> </script>
</head>
<body>
<table>
<tr>
<td width=100px>
<div style="color: rgb(150, 150, 0)">
<div style="background: currentcolor; height:25px; width:25px;"></div>
</div>
</td>
<td width=160px> Кластеры по цветам
</td>
</tr>
</table>
';
echo'
<table border=1>';
for($i = 1; $i <= $claster; $i++){
    $result = mysqli_query($mysql, "SELECT c.r, c.g, c.b FROM centroids as c WHERE c.id = '$i'");
    $Arr = mysqli_fetch_array($result);
    $r = $Arr['r'];
    $g = $Arr['g'];
    $b = $Arr['b'];
    echo'
    <tr>
    <td width=100px>
        <div style="color: rgb('.$r.', '.$g.', '.$b.')">
        <div style="background: currentcolor; height:25px; width:25px;"></div>
        </div>
        </td>';
    
    $mysql->query("DROP TABLE IF EXISTS answer");
    $mysql->query("CREATE table if not exists answer AS SELECT p.r, p.g, p.b FROM colors_1 AS p, closest_centre AS m, centroids AS c WHERE p.id = m.color_id AND c.id = m.centroid_id AND c.id = '$i'");
    $mysql->query("ALTER table answer add id int primary key auto_increment;");
    $result = mysqli_query($mysql, "SELECT COUNT(*) AS count FROM answer;");
    $Arr = mysqli_fetch_array($result);
    echo'<td>';
    /*$result = mysqli_query($mysql, "SELECT COUNT(*) AS count FROM answer;");
    $Arr = mysqli_fetch_array($result);
    */
    $count = $Arr['count'];
    for($j = 1; $j <= $count; $j++){
        $result = mysqli_query($mysql, "SELECT p.r, p.g, p.b FROM answer AS p WHERE p.id = '$j'");
        $Arr = mysqli_fetch_array($result);
        $r = $Arr['r'];
        $g = $Arr['g'];
        $b = $Arr['b'];
        echo'
        <div style="color: rgb('.$r.', '.$g.', '.$b.')">
        <div style="background: currentcolor; height:25px; width:25px;"></div>
        </div>';
    }
    echo'</td>';
    echo'
    <tr>
    ';
}

echo'
</table>
';


echo'
</body>
</html>';




?>

