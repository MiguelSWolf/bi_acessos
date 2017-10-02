<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$conn1 = new PDO('sqlite:acessos.db');
$conn2 = new PDO('sqlite:acessosdw.db');

$conn2->beginTransaction();
$conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$cache_pagina = array();
$cache_endereco = array();
$cache_cliente = array();
$cache_resolucao = array();
$cache_dispositivo = array();
$cache_navegador = array();
$cache_ip = array();
$cache_data = array();
$cache_tempo = array();



$result = $conn2->query("SELECT * FROM DIM_PAGINA ORDER BY id_pagina");
foreach ($result as $row) {
    $cache_pagina[$row['id_pagina_erp']] = $row['id_pagina'];
}
$result = $conn2->query("SELECT * FROM DIM_ENDERECO ORDER BY id_endereco");
foreach ($result as $row) {
    $cache_endereco[$row['id_endereco_erp']] = $row['id_endereco'];
}
$result = $conn2->query("SELECT * FROM DIM_CLIENTE ORDER BY id_cliente");
foreach ($result as $row) {
    $cache_cliente[$row['id_cliente_erp']] = $row['id_cliente'];
}
$result = $conn2->query("SELECT * FROM DIM_RESOLUCAO ORDER BY id_resolucao");
foreach ($result as $row) {
    $cache_resolucao[$row['id_resolucao_erp']] = $row['id_resolucao'];
}
$result = $conn2->query("SELECT * FROM DIM_DISPOSITIVO ORDER BY id_dispositivo");
foreach ($result as $row) {
    $cache_dispositivo[$row['id_dispositivo_erp']] = $row['id_dispositivo'];
}
$result = $conn2->query("SELECT * FROM DIM_NAVEGADOR ORDER BY id_navegador");
foreach ($result as $row) {
    $cache_navegador[$row['id_navegador_erp']] = $row['id_navegador'];
}
$result = $conn2->query("SELECT * FROM DIM_IP ORDER BY id_ip");
foreach ($result as $row) {
    $cache_ip[$row['ip_erp']] = $row['id_ip'];
}
$result = $conn2->query("SELECT * FROM DIM_DATA ORDER BY data");
foreach ($result as $row) {
    $cache_data[$row['data']] = $row['id_data'];
}
$result = $conn2->query("SELECT * FROM DIM_TEMPO ORDER BY tempo");
foreach ($result as $row) {
    $cache_tempo[$row['tempo']] = $row['id_tempo'];
}

$result = $conn1->query("SELECT
                            acesso.*
                        FROM
                            acesso");

foreach ($result as $row)
{
    $aux = explode(" ",$row['data_acesso']);
    $id_data = $aux[0];
    $id_tempo = $aux[1];
    $id_pagina = $row['id_pagina'];
    $id_pagina_entrada = $row['id_pagina_entrada'];
    $id_pagina_saida = $row['id_pagina_saida'];
    $id_endereco = $row['id_endereco'];
    $id_cliente = $row['id_cliente'];
    $id_resolucao = $row['id_resolucao'];
    $id_dispositivo = $row['id_dispositivo'];
    $id_navegador = $row['id_navegador'];
    $id_ip = $row['ip'];
    $duracao = $row['duracao'];
    
    $sql = "INSERT INTO FAT_ACESSO 
                        (id_pagina, id_pagina_entrada, id_pagina_saida, id_endereco, id_cliente, id_resolucao, id_dispositivo, id_navegador, id_ip, id_data, id_tempo, duracao)
                    VALUES (
                            '{$cache_pagina[$id_pagina]}',
                            '{$cache_pagina[$id_pagina_entrada]}',
                            '{$cache_pagina[$id_pagina_saida]}',
                            '{$cache_endereco[$id_endereco]}',
                            '{$cache_cliente[$id_cliente]}',
                            '{$cache_resolucao[$id_resolucao]}',
                            '{$cache_dispositivo[$id_dispositivo]}',
                            '{$cache_navegador[$id_navegador]}',
                            '{$cache_ip[$id_ip]}',
                            '{$cache_data[$id_data]}',
                            '{$cache_tempo[$id_tempo]}',
                            '{$duracao}'
                           )";
    $conn2->exec($sql);
    echo '.';
}
$conn2->commit();


// CREATE TABLE acesso (
//     id_acesso INTEGER PRIMARY KEY,
//     data_acesso DATETIME,
//     duracao INTEGER,
//     ip TEXT,
//     id_cliente INTEGER REFERENCES cliente(id_cliente), 
//     id_endereco INTEGER REFERENCES endereco(id_endereco),
//     id_pagina INTEGER REFERENCES pagina(id_pagina),
//     id_pagina_entrada INTEGER REFERENCES pagina(id_pagina),
//     id_pagina_saida INTEGER REFERENCES pagina(id_pagina),
//     id_navegador INTEGER REFERENCES navegador(id_navegador),
//     id_dispositivo INTEGER REFERENCES dispositivo(id_dispositivo),
//     id_resolucao INTEGER REFERENCES resolucao(id_resolucao)
// );