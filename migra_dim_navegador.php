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
                            navegador.id_navegador, 
                            navegador.versao, 
                            navegador.user_agent, 
                            empresa.nome as empresa, 
                            motor.nome as motor
                        FROM 
                            navegador, 
                            empresa, 
                            motor
                        WHERE 
                            navegador.id_empresa = empresa.id_empresa AND 
                            navegador.id_motor = motor.id_motor
                        ');

foreach ($result as $row)
{
    $versao = $row['versao'];
    $user_agent = $row['user_agent'];
    $empresa = $row['empresa'];
    $motor = $row['motor'];
    $id = $row['id_navegador'];
    
    $sub_result = $conn2->query("SELECT count(*) as 'count' from DIM_NAVEGADOR where id_navegador_erp = '{$id}'");
    
    $row = $sub_result->fetch();
    if ($row['count'] == 0)
    {
        $conn2->exec("INSERT INTO DIM_NAVEGADOR (versao, user_agent, empresa, motor, id_navegador_erp)
         VALUES ('{$versao}', '{$user_agent}', '{$empresa}', '{$motor}', $id)");
        echo '.';
    }
}
$conn2->commit();