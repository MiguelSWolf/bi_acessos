<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

$conn1 = new PDO('sqlite:acessos.db');
$conn2 = new PDO('sqlite:acessosdw.db');

$conn2->beginTransaction();
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$result = $conn1->query('SELECT ip FROM acesso');
foreach ($result as $row)
{
    $ip = $row['ip'];
    
    $sub_result = $conn2->query("SELECT count(*) as 'count' from DIM_IP where ip_erp = '{$ip}'");
    $row = $sub_result->fetch();
    if ($row['count'] == 0)
    {

        $conn2->exec("INSERT INTO DIM_IP (ip_erp) VALUES ('{$ip}')");
        echo '.';
    }
}
$conn2->commit();
