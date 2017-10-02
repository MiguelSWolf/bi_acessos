<?php
$conn1 = new PDO('sqlite:acessos.db');
$conn2 = new PDO('sqlite:acessosdw.db');

$conn2->beginTransaction();
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$result = $conn1->query('SELECT * FROM pagina');

foreach ($result as $row)
{
    $url = $row['url'];
    $dominio = $row['dominio'];
    $titulo = $row['titulo'];
    $codigo = $row['codigo'];
    $id = $row['id_pagina'];
    
    $sub_result = $conn2->query("SELECT count(*) as 'count' from DIM_PAGINA where id_pagina_erp = '{$id}'");
    
    $row = $sub_result->fetch();
    if ($row['count'] == 0)
    {
        $conn2->exec("INSERT INTO DIM_PAGINA (url, dominio, titulo, codigo, id_pagina_erp)
                                       VALUES ('{$url}', '{$dominio}', '{$titulo}', '{$codigo}', $id)");

        echo '.';
    }
}
$conn2->commit();