DROP TABLE IF EXISTS estado;
DROP TABLE IF EXISTS cidade;
DROP TABLE IF EXISTS endereco;
DROP TABLE IF EXISTS perfil;
DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS pagina;
DROP TABLE IF EXISTS acesso;
DROP TABLE IF EXISTS motor;
DROP TABLE IF EXISTS empresa;
DROP TABLE IF EXISTS navegador;
DROP TABLE IF EXISTS resolucao;
DROP TABLE IF EXISTS marca;
DROP TABLE IF EXISTS tipo_dispositivo;
DROP TABLE IF EXISTS dispositivo;
DROP TABLE IF EXISTS funcao;
DROP TABLE IF EXISTS interacao;

CREATE TABLE estado(
    id_estado INTEGER PRIMARY KEY,
    nome TEXT,
    pais TEXT 
);

CREATE TABLE cidade(
    id_cidade INTEGER PRIMARY KEY,
    nome TEXT,
    id_estado INTEGER REFERENCES estado(id_estado)
);

CREATE TABLE endereco (
    id_endereco INTEGER PRIMARY KEY,
    latitude TEXT,
    longitude TEXT,
    complemento TEXT,
    numero TEXT,
    rua TEXT,
    logradouro TEXT,
    bairro TEXT,
    codigo_postal TEXT,
    id_cidade INTEGER REFERENCES cidade(id_cidade)
);

CREATE TABLE perfil (
    id_perfil INTEGER PRIMARY KEY,
    descricao TEXT 
);

CREATE TABLE cliente (
    id_cliente INTEGER PRIMARY KEY,
    nome TEXT,
    id_perfil INTEGER REFERENCES perfil(id_perfil),
    id_endereco INTEGER REFERENCES endereco(id_endereco)
);

CREATE TABLE pagina (
    id_pagina INTEGER PRIMARY KEY,
    url TEXT,
    dominio TEXT,
    codigo TEXT,
    titulo TEXT 
);

CREATE TABLE motor(
    id_motor INTEGER PRIMARY KEY,
    nome TEXT
);

CREATE TABLE empresa(
    id_empresa INTEGER PRIMARY KEY,
    nome TEXT
);

CREATE TABLE navegador(
    id_navegador INTEGER PRIMARY KEY,
    versao TEXT,
    user_agent TEXT,
    id_empresa INTEGER REFERENCES empresa(id_empresa),
    id_motor INTEGER REFERENCES motor(id_motor)
);

CREATE TABLE resolucao(
    id_resolucao INTEGER PRIMARY KEY,
    largura INTEGER,
    altura INTEGER
);

CREATE TABLE marca(
    id_marca INTEGER PRIMARY KEY,
    nome TEXT
);

CREATE TABLE tipo_dispositivo(
    id_tipo_dispositivo INTEGER PRIMARY KEY,
    nome TEXT
);

CREATE TABLE dispositivo(
    id_dispositivo INTEGER PRIMARY KEY,
    nome TEXT,
    id_tipo_dispositivo INTEGER REFERENCES tipo_dispositivo(id_tipo_dispositivo),
    id_marca INTEGER REFERENCES marca(id)
);

CREATE TABLE acesso (
    id_acesso INTEGER PRIMARY KEY,
    data_acesso DATETIME,
    duracao INTEGER,
    ip TEXT,
    id_cliente INTEGER REFERENCES cliente(id_cliente), 
    id_endereco INTEGER REFERENCES endereco(id_endereco),
    id_pagina INTEGER REFERENCES pagina(id_pagina),
    id_pagina_entrada INTEGER REFERENCES pagina(id_pagina),
    id_pagina_saida INTEGER REFERENCES pagina(id_pagina),
    id_navegador INTEGER REFERENCES navegador(id_navegador),
    id_dispositivo INTEGER REFERENCES dispositivo(id_dispositivo),
    id_resolucao INTEGER REFERENCES resolucao(id_resolucao)
);

CREATE TABLE funcao (
    id_funcao INTEGER PRIMARY KEY,
    descricao TEXT
);

CREATE TABLE interacao (
    id_interacao INTEGER PRIMARY KEY,
    scroll_x INTEGER,
    scroll_y INTEGER,
    id_acesso INTEGER REFERENCES acesso(id_acesso),
    id_funcao INTEGER REFERENCES funcao(id_funcao)
);