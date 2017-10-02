<?php
$conn1 = new PDO('sqlite:acessos.db');
$conn2 = new PDO('sqlite:acessosdw.db');

$conn2->beginTransaction();
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$result = $conn1->query('SELECT endereco.*, cidade.nome as cidade, estado.nome as estado, estado.pais FROM endereco, cidade, estado WHERE endereco.id_cidade = cidade.id_cidade AND cidade.id_estado = estado.id_estado');

foreach ($result as $row)
{
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $complemento = $row['complemento'];
    $numero = $row['numero'];
    $rua = $row['rua'];
    $logradouro = $row['logradouro'];
    $bairro = $row['bairro'];
    $codigo_postal = $row['codigo_postal'];
    $cidade = $row['cidade'];
    $estado = $row['estado'];
    $pais = $row['pais'];
    $id = $row['id_endereco'];
    
    $sub_result = $conn2->query("SELECT count(*) as 'count' from DIM_ENDERECO where id_endereco_erp = '{$id}'");
    
    $row = $sub_result->fetch();
    if ($row['count'] == 0)
    {
        $conn2->exec("INSERT INTO DIM_ENDERECO (latitude, longitude, complemento, numero, rua, logradouro, bairro, codigo_postal, cidade, estado, pais, id_endereco_erp)
         VALUES ('{$latitude}', '{$longitude}', '{$complemento}', '{$numero}', '{$rua}', '{$logradouro}', '{$bairro}', '{$codigo_postal}', '{$cidade}', '{$estado}', '{$pais}', $id)");

        echo '.';
    }
}
$conn2->commit();
