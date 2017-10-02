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
                            cliente.id_cliente,
                            cliente.nome, 
                            perfil.descricao as perfil, 
                            endereco.*, 
                            cidade.nome as cidade, 
                            estado.nome as estado, 
                            estado.pais 
                        FROM 
                            cliente, 
                            perfil, 
                            endereco, 
                            cidade, 
                            estado 
                        WHERE 
                            cliente.id_endereco = endereco.id_endereco AND 
                            cliente.id_perfil = perfil.id_perfil AND 
                            endereco.id_cidade = cidade.id_cidade AND 
                            cidade.id_estado = estado.id_estado
                        ');

foreach ($result as $row)
{
    $nome = $row['nome'];
    $perfil = $row['perfil'];
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
    $id = $row['id_cliente'];
    
    $sub_result = $conn2->query("SELECT count(*) as 'count' from DIM_CLIENTE where id_cliente_erp = '{$id}'");
    
    $row = $sub_result->fetch();
    if ($row['count'] == 0)
    {
        $conn2->exec("INSERT INTO DIM_CLIENTE (nome, perfil, latitude, longitude, complemento, numero, rua, logradouro, bairro, codigo_postal, cidade, estado, pais, id_cliente_erp)
         VALUES ('{$nome}', '{$perfil}', '{$latitude}', '{$longitude}', '{$complemento}', '{$numero}', '{$rua}', '{$logradouro}', '{$bairro}', '{$codigo_postal}', '{$cidade}', '{$estado}', '{$pais}', $id)");
        echo '.';
    }
}
$conn2->commit();
