<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$conn1 = new PDO('sqlite:acessos.db');
$conn2 = new PDO('sqlite:acessosdw.db');

$conn2->beginTransaction();
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$result = $conn1->query('SELECT 
                            resolucao.id_resolucao,
                            resolucao.largura, 
                            resolucao.altura
                        FROM 
                            resolucao
                        ');

foreach ($result as $row)
{
    $largura = $row['largura'];
    $altura = $row['altura'];
    $id = $row['id_resolucao'];
    $apresentacao = $largura." X ".$altura;
    
    $sub_result = $conn2->query("SELECT count(*) as 'count' from DIM_RESOLUCAO where id_resolucao_erp = '{$id}'");

    $row = $sub_result->fetch();
    if ($row['count'] == 0)
    {
        $conn2->exec("INSERT INTO DIM_RESOLUCAO (largura, altura, apresentacao, id_resolucao_erp)
         VALUES ('{$largura}', '{$altura}', '{$apresentacao}', $id)");
        echo '.';
    }
}
$conn2->commit();
