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
                            dispositivo.id_dispositivo,
                            dispositivo.nome, 
                            marca.nome as marca, 
                            tipo_dispositivo.nome as tipo_dispositivo
                        FROM 
                            dispositivo, 
                            tipo_dispositivo,
                            marca
                        WHERE 
                            dispositivo.id_marca = marca.id_marca AND 
                            dispositivo.id_tipo_dispositivo = tipo_dispositivo.id_tipo_dispositivo
                        ');

foreach ($result as $row)
{
    $nome = $row['nome'];
    $marca = $row['marca'];
    $tipo_dispositivo = $row['tipo_dispositivo'];
    $id = $row['id_dispositivo'];
    
    $sub_result = $conn2->query("SELECT count(*) as 'count' from DIM_DISPOSITIVO where id_dispositivo_erp = '{$id}'");

    $row = $sub_result->fetch();
    if ($row['count'] == 0)
    {
        $conn2->exec("INSERT INTO DIM_DISPOSITIVO (nome, marca, tipo_dispositivo, id_dispositivo_erp)
         VALUES ('{$nome}', '{$marca}', '{$tipo_dispositivo}', $id)");
        echo '.';
    }
}
$conn2->commit();