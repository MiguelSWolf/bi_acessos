<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

$conn = new PDO('sqlite:acessosdw.db');
// $conn->query('CREATE TABLE DIM_DATA (id_tempo integer primary key not null, dia integer, mes integer, ano integer, nome_dia text, nome_mes text, data date)');
$data = '2017-01-01';

$dias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
$meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

$conn->query('begin');
$date = new DateTime( $data );
while ($data !== '2024-12-31')
{
    $date->add(new DateInterval('P1D'));
    $data = $date->format('Y-m-d');
    $pieces = explode('-', $data);
    $dia = (int) $date->format('j');
    $mes = (int) $date->format('n');
    $ano = (int) $date->format('Y');
    $nome_dia = $dias[$date->format('w')];
    $nome_mes = $meses[ $mes-1 ];
    $sql = "INSERT INTO DIM_DATA (dia, mes, ano, nome_dia, nome_mes, data) VALUES ($dia, $mes, $ano, '$nome_dia', '$nome_mes', '$data')";
    echo ".";
    $conn->query($sql);
}
$conn->query('commit');
unset($conn);
