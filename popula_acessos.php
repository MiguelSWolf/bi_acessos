<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');
$conn = new PDO('sqlite:acessos.db');


$estados = ["Acre", "Alagoas", "Amapá", "Amazonas", "Bahia", "Ceará", "Distrito Federal", "Espírito Santo", "Goiás", "Maranhão", "Mato Grosso", "Mato Grosso do Sul", "Minas Gerais", "Pará", "Paraíba", "Paraná", "Pernambuco", "Piauí", "Rio de Janeiro", "Rio Grande do Norte", "Rio Grande do Sul", "Rondônia", "Roraima", "Santa Catarina", "São Paulo", "Sergipe", "Tocantins"];
$capitais = ["Rio Branco", "Maceió", "Macapá", "Manaus", "Salvador", "Fortaleza", "Brasília", "Vitória", "Goiânia", "São Luís", "Cuiabá", "Campo Grande", "Belo Horizonte", "Belém", "João Pessoa", "Curitiba", "Recife", "Teresina", "Rio de Janeiro", "Natal", "Porto Alegre", "Porto Velho", "Boa Vista", "Florianópolis", "São Paulo", "Aracaju", "Palmas"];
$perfis = ["Administrativo", "Comprador", "Potencial Comprador"];
$nomePessoas = ["Alice", "Miguel", "Sophia", "Arthur", "Júlia", "Davi", "Laura", "Pedro", "Isabella", "Bernardo", "Manuela", "Gabriel", "Luiza", "Lucas", "Helena", "Matheus", "Valentina", "Heitor", "Giovanna", "Rafael", "Maria Eduarda", "Enzo", "Beatriz", "Nicolas", "Maria Clara", "Lorenzo", "Maria Luiza", "Guilherme", "Heloísa", "Samuel", "Mariana", "Theo", "Lara", "Felipe", "Lívia", "Gustavo", "Lorena", "Henrique", "Ana Clara", "João Pedro", "Isadora", "João Lucas", "Rafaela", "Daniel", "Sarah", "Murilo", "Yasmin", "Vitor", "Ana Luiza", "Pedro Henrique", "Letícia", "Eduardo", "Nicole", "Leonardo", "Gabriela", "Pietro", "Isabelly", "Benjamin", "Melissa", "Isaac", "Cecília", "João", "Esther", "Joaquim", "Ana Júlia", "Lucca", "Emanuelly", "Caio", "Clara", "Vinicius", "Marina", "Cauã", "Rebeca", "Bryan", "Vitória", "João Miguel", "Isis", "Vicente", "Lavínia", "Francisco", "Maria", "Antônio", "Bianca", "Benício", "Ana Beatriz", "João Vitor", "Larissa", "Enzo Gabriel", "Maria Fernanda", "Davi Lucas", "Catarina", "Davi Lucca", "Alícia", "Thiago", "Maria Alice", "Thomas", "Amanda", "Emanuel", "Ana", "Enrico"];
$dominios = ["www.google.com.br", "www.americanas.com.br", "www.zoom.com.br", "www.submarino.com.br", "www.kabum.com.br"];
$tituloPaginas = ["Kit Teclado Musical Ctk-1200 Casio + Fonte+ Capa + Suporte X", "Kit Teclado Musical Yamaha Psr-f51 61 Teclas 114 Estilos", "Kit Teclado Yamaha Ypt-255 Com 02fontes+suporte+capa+bag", "Razer Anansi Multicolor Teclado Para Mmo Garantia 1ano", "Razer Deathstalker Essential Garantia 1 Ano Liquidação 2016", "Teclado Arranjador Roland Bk5", "Teclado Casio Ctk-1200 -61 Teclas,100 Ritmos", "Teclado Casio Ctk-3200 - 61 Teclas Estilo Piano", "Teclado Digital Casio Ctk6200 61 Tc Usb C/fonte Frete Grátis", "Teclado Gamer Luminoso Led Pc Semi Mecânico Neon Usb T168", "Teclado Musical Yamaha Psr E453 61 Teclas C/ Fonte Original", "Teclado Razer Blackwidow X Chroma Tournament Novo, Lacrado", "Teclado Razer Cyclosa Macro Multimídia Usb", "Teclado Razer Ornata Chroma Membrana Mecanico - Lacrado"];
$urlPaginas = ["kit-teclado-musical-ctk-1200-casio-fonte-capa-suporte-x", "kit-teclado-musical-yamaha-psr-f51-61-teclas-114-estilos", "kit-teclado-yamaha-ypt-255-com-02fontes+suporte+capa+bag", "razer-anansi-multicolor-teclado-para-mmo-garantia-1ano", "razer-deathstalker-essential-garantia-1-ano-liquidação-2016", "teclado-arranjador-roland-bk5", "teclado-casio-ctk-1200-61-teclas,100-ritmos", "teclado-casio-ctk-3200-61-teclas-estilo-piano", "teclado-digital-casio-ctk6200-61-tc-usb-c/fonte-frete-grátis", "teclado-gamer-luminoso-led-pc-semi-mecânico-neon-usb-t168", "teclado-musical-yamaha-psr-e453-61-teclas-c/-fonte-original", "teclado-razer-blackwidow-x-chroma-tournament-novo,-lacrado", "teclado-razer-cyclosa-macro-multimídia-usb", "teclado-razer-ornata-chroma-membrana-mecanico-lacrado"];
$limiteEnderecos = 1000;
$limiteClientes = 100;
$limitePaginas = 100;
$limiteAcessos = 10000;




{
    $conn->query('begin');
    $create = file_get_contents("create.sql");
    $conn->exec($create);
    $conn->query('commit');
}


{
    $count = 0;
    $conn->query('begin');
    foreach ($estados as $estado) {
        $sql = "INSERT INTO estado (nome, pais) VALUES ('$estado', 'Brasil')";
        $count++;
        $conn->query($sql);
    }
    $conn->query('commit');
    echo "Inserido $count estados<br />";
}


{
    $count = 0;
    $conn->query('begin');
    foreach ($capitais as $capital) {
        $sql = "INSERT INTO cidade (nome, id_estado) VALUES ('$capital', '".($count+1)."')";
        $count++;
        $conn->query($sql);
    }
    $conn->query('commit');
    echo "Inserido $count cidades<br />";
}


{
    $count = 0;
    $conn->query('begin');
    for ($i = 0; $i < $limiteEnderecos; $i++) {
        $latitude = rand();
        $longitude = rand();
        $id_cidade = rand(1, count($capitais));
        $sql = "INSERT INTO endereco (latitude, longitude, id_cidade) VALUES ('$latitude', '$longitude', $id_cidade)";
        $count++;
        $conn->query($sql);
    }
    $conn->query('commit');
    echo "Inserido $count enderecos<br />";
}


{
    $count = 0;
    $conn->query('begin');
    foreach ($perfis as $perfil) {
        $sql = "INSERT INTO perfil (descricao) VALUES ('$perfil')";
        $count++;
        $conn->query($sql);
    }
    $conn->query('commit');
    echo "Inserido $count perfis<br />";
}


{
    $count = 0;
    $conn->query('begin');
    for ($i = 0; $i < $limiteClientes; $i++) {
        $nome =  $nomePessoas[array_rand($nomePessoas)];
        $id_endereco = rand(1, count($limiteEnderecos));
        $id_perfil = rand(1, count($perfis));
        $sql = "INSERT INTO cliente (nome, id_endereco, id_perfil) VALUES ('$nome', $id_endereco, $id_perfil)";
        $count++;
        $conn->query($sql);
    }
    $conn->query('commit');
    echo "Inserido $count clientes<br />";
}


{
    $count = 0;
    $conn->query('begin');
    for ($i = 0; $i < $limitePaginas; $i++) {
        $dominio = $dominios[array_rand($dominios)];
        $index = array_rand($tituloPaginas);
        $url = $urlPaginas[$index];
        $titulo = $tituloPaginas[$index];
        $sql = "INSERT INTO pagina (url, dominio, titulo) VALUES ('$url', '$dominio', '$titulo')";
        $count++;
        $conn->query($sql);
    }
    $conn->query('commit');
    echo "Inserido $count pagina<br />";
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO motor (nome) VALUES ('Webkit')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Presto')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Trident')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Gekko')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Blink')");
    $conn->query('commit');
    echo "Inserido 5 motores<br />";
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO motor (nome) VALUES ('Webkit')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Presto')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Trident')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Gekko')");
    $conn->query("INSERT INTO motor (nome) VALUES ('Blink')");
    $conn->query('commit');
    echo "Inserido 5 motores<br />";
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO empresa (nome) VALUES ('Google')");
    $conn->query("INSERT INTO empresa (nome) VALUES ('Opera')");
    $conn->query("INSERT INTO empresa (nome) VALUES ('Mozilla')");
    $conn->query("INSERT INTO empresa (nome) VALUES ('Microsoft')");
    $conn->query("INSERT INTO empresa (nome) VALUES ('Apple')");
    $conn->query('commit');
    echo "Inserido 5 empresas<br />";
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 41.0.2228.0', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36', 1, 1);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 41.0.2227.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.1 Safari/537.36', 1, 1);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 41.0.2227.0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36', 1, 1);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 41.0.2226.0', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2226.0 Safari/537.36', 1, 4);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 41.0.2225.0', 'Mozilla/5.0 (Windows NT 6.4; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2225.0 Safari/537.36', 1, 4);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 41.0.2224.3', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2224.3 Safari/537.36', 1, 1);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 40.0.2214.93', 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.93 Safari/537.36', 1, 1);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 37.0.2062.124', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', 1, 2);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 37.0.2049.0', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2049.0 Safari/537.36', 1, 1);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Chrome 36.0.1985.67', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36', 1, 1);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Firefox 40.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1', 3, 4);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Firefox 36.0', 'Mozilla/5.0 (Windows NT 6.3; rv:36.0) Gecko/20100101 Firefox/36.0', 3, 4);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Firefox 33.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10; rv:33.0) Gecko/20100101 Firefox/33.0', 3, 4);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Firefox 31.0', 'Mozilla/5.0 (X11; Linux i586; rv:31.0) Gecko/20100101 Firefox/31.0', 3, 4);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Firefox 29.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20120101 Firefox/29.0', 3, 4);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Opera 12.16', 'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16', 2, 2);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Opera 12.14', 'Opera/9.80 (Windows NT 6.0) Presto/2.12.388 Version/12.14', 2, 2);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Opera 12.02', 'Opera/12.80 (Windows NT 5.1; U; en) Presto/2.10.289 Version/12.02', 2, 2);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Opera 12.00', 'Opera/9.80 (Windows NT 6.1; U; es-ES) Presto/2.9.181 Version/12.00', 2, 5);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Safari 7.0.3', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A', 5, 5);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Safari 6.0', 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25', 5, 5);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Safari 5.1.7', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2', 5, 5);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Safari 5.1.3', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/534.55.3 (KHTML, like Gecko) Version/5.1.3 Safari/534.53.10', 5, 5);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Safari 5.1', 'Mozilla/5.0 (iPad; CPU OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko ) Version/5.1 Mobile/9B176 Safari/7534.48.3', 5, 5);");
    $conn->query("INSERT INTO navegador(versao, user_agent, id_empresa, id_motor) values('Safari 5.0.5', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; de-at) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1', 5, 5);");
    $conn->query('commit');
    echo "Inserido 25 navegadores<br />";
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO resolucao (largura, altura) VALUES (640, 480)");
    $conn->query("INSERT INTO resolucao (largura, altura) VALUES (480, 640)");
    $conn->query("INSERT INTO resolucao (largura, altura) VALUES (720, 480)");
    $conn->query("INSERT INTO resolucao (largura, altura) VALUES (480, 720)");
    $conn->query("INSERT INTO resolucao (largura, altura) VALUES (1440, 900)");
    $conn->query("INSERT INTO resolucao (largura, altura) VALUES (1920, 1080)");
    $conn->query('commit');
    echo "Inserido 6 resolucoes<br />";
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO marca (nome) VALUES ('Apple')");
    $conn->query("INSERT INTO marca (nome) VALUES ('Samsung')");
    $conn->query("INSERT INTO marca (nome) VALUES ('Dell')");
    $conn->query('commit');
    echo "Inserido 3 marcas<br />";    
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO tipo_dispositivo (nome) VALUES ('Desktop')");
    $conn->query("INSERT INTO tipo_dispositivo (nome) VALUES ('Smartphone')");
    $conn->query("INSERT INTO tipo_dispositivo (nome) VALUES ('Notebook')");
    $conn->query('commit');
    echo "Inserido 3 tipos de dispositivos<br />";    
}


{
    $conn->query('begin');
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Iphone 5S', 2, 1)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Iphone 6S', 2, 1)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Iphone X', 2, 1)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Iphone 7 Plus', 2, 1)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Samsung Note 7', 2, 2)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Samsung S7', 2, 2)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Samsung S7 Edge', 2, 2)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Samsung S8', 2, 2)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Vostro 1520', 2, 3)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Vostro 2520', 2, 3)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('XPS 1530', 1, 3)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Vostro 1520', 1, 3)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('XPS 230', 1, 3)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('XPS 530', 1, 3)");
    $conn->query("INSERT INTO dispositivo (nome, id_tipo_dispositivo, id_marca) VALUES ('Samsung Essentials E25S', 3, 2)");
    $conn->query('commit');
    echo "Inserido 15 dispositivos<br />";    
}


{
    $count = 0;
    $conn->query('begin');
    for ($i = 0; $i < $limiteAcessos; $i++) {
        $data = new DateTime();
        $data->setDate(2017, 9, rand(1,30));
        $data->setTime(rand(0,23), rand(0,59), 0);
        $data_acesso = $data->format('Y-m-d H:i:s');
        $duracao = rand(1, 240);
        $ip = rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255).'.'.rand(0, 255);
        $id_cliente = rand(1, $limiteClientes);
        $id_endereco = rand(1, $limiteEnderecos);
        $id_pagina = rand(1, $limitePaginas);
        $id_pagina_entrada = rand(1, $limitePaginas);
        $id_pagina_saida = rand(1, $limitePaginas);
        $id_navegador = rand(1, 25);
        $id_dispositivo = rand(1,15);
        $id_resolucao = rand(1, 6);

        $sql = "INSERT INTO acesso (data_acesso, duracao, ip, id_cliente, id_endereco, id_pagina, id_pagina_entrada, id_pagina_saida, id_navegador, id_dispositivo, id_resolucao) VALUES 
        ('$data_acesso', $duracao, '$ip', $id_cliente, $id_endereco, $id_pagina, $id_pagina_entrada, $id_pagina_saida, $id_navegador, $id_dispositivo, $id_resolucao)"; 
        $count++;
        $conn->query($sql);
    }
    $conn->query('commit');
    echo "Inserido $count acessos<br />";
}



unset($conn);