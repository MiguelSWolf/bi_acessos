<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

$conn = new PDO('sqlite:acessosdw.db');

$turnos = ['Manhã','Tarde', 'Noite', 'Madrugada'];

$conn->query('begin');
$time = new DateTime();
$time->setTime(0,0,0);
while ($time->format("H:i") != "23:59")
{
    $tempo = $time->format('H:i:s');
    $hora = (int) $time->format('H');
    $minuto = (int) $time->format('i');
    $segundo = (int) $time->format('s');
    $turno = $turnos[3];
    if($hora > 6)
        $turno = $turnos[0];
    if($hora > 12)
        $turno = $turnos[1];
    if($hora > 18)
        $turno = $turnos[2];

    $sql = "INSERT INTO DIM_TEMPO (hora, minuto, segundo, turno, tempo) VALUES ($hora, $minuto, $segundo, '$turno', '$tempo')";
    echo ".";
    $conn->query($sql);
    $time->add(new DateInterval('PT1M'));
}
$conn->query('commit');
unset($conn);

