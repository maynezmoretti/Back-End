# Situação de Aprendizagem Formativa - Criação de um CRUD com PDO e Proteção contra SQL Injection

## Passo 1 - Montagem das Estruturas de Diretórios e Arquivos da Aplicação

```text
SA_CRUD/
|__ config/
|    |__ database.ini        <- Credencias Protegidas de acesso ao Banco de Dados
|__ logs/
|    |__database.log         <- Time de Desenvolvimento recebe os logs de Falhas do Sistema
|__ src/
|    |__ConexaoBanco.php     <- Classe Singleton de conexão com PDO
|    |__AlmoxarifadoDAO.php  <- Camada de acesso a dados (CRUD com Prepared Statement)
|__ index.php                <- Controlador e interface visual
|__ schema.sql               <- Script do Banco de Dados
|__ .gitignore               <- Arquivos fora do versionamento
|__ README.md                <- Documentação do Projeto
```
---
## Passo 2 - Criar a Estrutura do Banco de Dados (`schema.sql`)

```sql
--Criação do banco
CREATE DATABASE almoxarifado_senai WITH ENCODING 'UTF8';

-- Criação da tabela de peças industriais do almoxarifado
CREATE TABLE IF NOT EXISTS pecas_industriais (
    id SERIAL PRIMARY KEY,
    codigo_sku VARCHAR(20) NOT NULL UNIQUE,
    descricao VARCHAR(100) NOT NULL,
    categoria VARCHAR(40) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0 CHECK (quantidade >= 0),
    preco_unitario NUMERIC(10,2) NOT NULL CHECK (preco_unitario > 0),
    data_cadastro TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Carga inicial de dados para homologação
INSERT INTO pecas_industriais (codigo_sku, descricao, categoria, quantidade, preco_unitario) 
VALUES 
('ROL-SKF-6205', 'Rolamento Rigido de Esferas SKF 6205', 'Mecanica', 45, 89.90),
('COR-V-A42', 'Correia Industrial em V Perfil A-42', 'Transmissao', 120, 24.50),
('DISJ-TER-32A', 'Disjuntor Termomagnetico Tripolar 32A', 'Eletrica', 18, 145.00),
('VALV-SOL-24V', 'Valvula Solenoide Pneumatica 5/2 Vias 24V', 'Pneumatica', 8, 310.00)
ON CONFLICT (codigo_sku) DO NOTHING;
```
---
## Passo 3 - Arquivo de Configuração de Banco de Dados (`config/database.ini`)

Configurar as credenciais no `.ini`.

```ini
[database]
db_driver   = pgsql
db_host     = 192.168.10.97
db_port     = 5432
db_name     = almoxarifado_senai
db_user     = postgres
db_pass     = 250318
```
---
## Passo 4 - Classe Singleton de Conexão com Banco de Dados (`src/ConexaoBanco.php`)

```php
<?php
declare(strict_types=1);

// criando uma classe responsável por realizar a conexão com o banco
// essa classe será uma singleton (permitirá instanciar apenas um objeto por vez)

final class ConexaoBanco {
    // atributos
    // armazenar a conexão aberta com o banco de dados
    private static ?PDO $instancia = null;

    // métodos
    // toda classe precisa de um construtor (o construtor é um método que permite a criação de objetos)
    // em classes do tipo singleton, o construtor é private
    private function __construct(){}

    // métodos de segurança anti-clonagem e anti-serialização (desserialização)
    private function __clone(): void{}
    private function __wakeup(): void{
        // criando uma Exception()
        throw new \Exception("Desserialização não permitida para Singleton");
    }

    // método para obter a conexão (precisa ser público e estático)
    public static function obterConexao(string $caminhoConfig): PDO {
        // verificar se já não existe uma conexão
        if(self::$instancia === null){ // se a conexão não existir, eu crio uma
            $config = self::carregarArquivoConfig($caminhoConfig);
            self::$instancia = self::estabelecerConexao($config);
        } // caso já exista, retorna a conexão existente
        return self::$instancia;
    }
    
    // criar método para carregar arquivo do .ini
    private static function carregarArquivoConfig(string $caminho): array {
        if(!file_exists($caminho)){ // se o arquivo não existir
            throw new \RuntimeException("Arquivo de configuração não encontrado em {$caminho}");
        } // caso o arquivo exista
        $dados = parse_ini_file($caminho, true);
        if($dados === false || !isset($dados["database"])){
            throw new \RuntimeException("Seção [database] ausente no arquivo de configuração");
        } // se tudo estiver certo
        return $dados["database"];
    }

    // criar método para estabelecer a conexão com o banco
    private static function estabelecerConexao(array $cfg): PDO {
        // montar o endereço de conexão (pgsql:host=127.0.0.1;port=5432;biblioteca_escola)
        $dsn = sprintf(
            "%s:host=%s;port=%s;dbname=%s",
            $cfg["db_driver"],
            $cfg["db_host"],
            $cfg["db_port"],
            $cfg["db_name"]
        );

        // montar as flags de segurança do PDO
        $opcoes = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5
        ];
        return new PDO($dsn, $cfg["db_user"], $cfg["db_pass"], $opcoes);
    }
}
```
---
## Passo 5 - Criar o Arquivo `.gitignore`

```git
config/database.ini
logs/database.log
```
---
## Passo 6 - Construção da Camada DAO (`src/AlmoxarifadoDAO.php`)

Esta classe vai encapsular as 4 operações **(CRUD)** utilizando *Prepared Statement*.

