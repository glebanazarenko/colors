<?php
define('DB_HOST', 'localhost'); //Адрес
define('DB_USER', 'root'); //Имя пользователя
define('DB_PASSWORD', ''); //Пароль
define('DB_NAME', 'gleb'); //Имя БД
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
    $result = mysqli_query($mysql, "SELECT c.r, c.g, c.b FROM cluster as c WHERE c.id = '$i'");
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
    $mysql->query("CREATE table if not exists answer AS SELECT p.r, p.g, p.b FROM colors_1 AS p, mindists AS m, cluster AS c WHERE p.id = m.pid AND c.id_c = m.cid AND c.id_c = '$i'");
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




/*
set @k = 7;
drop table if exists cluster;
CREATE table if not exists cluster AS SELECT * from colors_1 WHERE colors_1.id < @k;

alter table cluster
add id_c int primary key auto_increment;


    drop table if exists temp;
    create table if not exists temp AS 
        SELECT c.id as cid, p.id as pid, pow(pow(c.r - p.r, 2) + pow(c.g - p.g, 2) + pow(c.b - p.b, 2), 0.5) as dist
        from cluster c, colors_1 p
        order by p.id, dist;

    set @x := 0;
    drop table if exists mindists;
    create table if not exists mindists AS
        select cid, pid, dist
        from (select (@x:=@x+1) as x, mt.* from temp mt) t
        where x mod @k = 1;

    drop table if exists centroid;
    CREATE table if not EXISTS centroid AS
        SELECT c.id, AVG(p.r) as r, avg(p.g) as g, avg(p.b) as b
        FROM cluster as c, mindists as m, colors_1 as p
        WHERE c.id = m.cid AND m.pid = p.id
        GROUP by c.id;

    UPDATE cluster c
        set c.r = (SELECT ce.r From centroid as ce WHERE c.id = ce.id);

    UPDATE cluster c
        set c.g = (SELECT ce.g From centroid as ce WHERE c.id = ce.id);

    UPDATE cluster c
        set c.b = (SELECT ce.b From centroid as ce WHERE c.id = ce.id);
    
    drop table if exists temp;
    create table if not exists temp AS 
        SELECT c.id as cid, p.id as pid, pow(pow(c.r - p.r, 2) + pow(c.g - p.g, 2) + pow(c.b - p.b, 2), 0.5) as dist
        from cluster c, colors_1 p
        order by p.id, dist;

    set @x := 0;
    drop table if exists mindists;
    create table if not exists mindists AS
        select cid, pid, dist
        from (select (@x:=@x+1) as x, mt.* from temp mt) t
        where x mod @k = 1;

    drop table if exists centroid;
    CREATE table if not EXISTS centroid AS
        SELECT c.id, AVG(p.r) as r, avg(p.g) as g, avg(p.b) as b
        FROM cluster as c, mindists as m, colors_1 as p
        WHERE c.id = m.cid AND m.pid = p.id
        GROUP by c.id;

    UPDATE cluster c
        set c.r = (SELECT ce.r From centroid as ce WHERE c.id = ce.id);

    UPDATE cluster c
        set c.g = (SELECT ce.g From centroid as ce WHERE c.id = ce.id);

    UPDATE cluster c
        set c.b = (SELECT ce.b From centroid as ce WHERE c.id = ce.id);
*/
?>

