-- exibir fk de uma table
--use INFORMATION_SCHEMA;

--select TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,
--REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME from KEY_COLUMN_USAGE where
--REFERENCED_TABLE_NAME = 'nomeDaTabelaPai';



CREATE TABLE documento(
cd_documento INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
nm_documento VARCHAR( 20 )
)

CREATE TABLE tipoPessoa(
cd_tipo_pessoa INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
nm_pessoa VARCHAR( 30 )
)

CREATE TABLE multa(
cd_ait INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
dt_infracao DATE NOT NULL ,
hr_infracao VARCHAR( 5 ) NOT NULL ,
dt_vencimento_infracao DATE NOT NULL ,
nm_agente VARCHAR( 30 ) NOT NULL ,
ds_infracao VARCHAR( 100 ) NOT NULL ,
dt_pagamento_multa DATE
)


CREATE TABLE infracao(
cd_infracao INT NOT NULL AUTO_INCREMENT,
cd_ait INT,
nm_infracao VARCHAR( 20 ) NOT NULL ,
ds_infracao VARCHAR( 100 ) NOT NULL ,
qt_pontuacao INT NOT NULL ,
dt_data DATE NOT NULL ,
hr_hora VARCHAR( 5 ) NOT NULL ,
dt_vencimento DATE NOT NULL ,
vl_infracao DOUBLE NOT NULL ,
PRIMARY KEY ( cd_infracao, cd_ait ) ,
CHECK (
vl_infracao >0
),
CONSTRAINT fkcd_ait FOREIGN KEY ( cd_ait ) REFERENCES multa( cd_ait )
)

CREATE TABLE tipoVeiculo(
cd_modalidade INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nm_modalidade VARCHAR( 30 )
)

CREATE TABLE processo(

cd_processo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,

aa_processo DATE NOT NULL ,

dt_relato_denuncia DATE NOT NULL,
dt_apresentacao_defesa DATE ,
dt_apresentacao_relatorio DATE ,
dt_inicio_julgamento DATE ,
dt_julgado ,
ds_resultado VARCHAR( 30 ) ,
dt_notificacao DATE  ,
ds_observacoes_processos VARCHAR( 100 ),
cd_recurso INT ,
aa_recurso DATE ,
dt_transito_julgado DATE  ,
dt_inicio_julgamento_recurso DATE ,
dt_julgado_recurso ,
ds_resultado_recurso VARCHAR( 30 ) ,
dt_notificacao_recurso DATE  ,
dt_arquivo_deprot DATE ,
ds_observacao_recurso VARCHAR( 100 )
)

CREATE TABLE associacao(
cd_associacao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nm_razao_social VARCHAR( 40 ) NOT NULL ,
nm_logradouro VARCHAR( 30 ) NOT NULL ,
nm_local VARCHAR( 20 ) NOT NULL ,
ds_numero INT NOT NULL ,
ds_complemento VARCHAR( 15 ) ,
cd_cep INT NOT NULL ,
nm_bairro VARCHAR( 10 ) NOT NULL ,
nm_municipio VARCHAR( 15 ) NOT NULL ,
nm_UFCHAR( 2 ) NOT NULL ,
cd_telefone VARCHAR( 13 ) NOT NULL ,
nm_email VARCHAR( 25 ) NOT NULL ,
nm_linha VARCHAR( 15 ) NOT NULL ,
CONSTRAINT cnm_UF CHECK (
nm_UF IN (
'AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PR','PB','PA'
'PE','PI','RJ','RN','RS','RO','RR','SC','SE','SP','TO'
)
)
)

