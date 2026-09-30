<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos de Laboratório
// Exercício 1: Verificador de Portas e Diagnóstico de Conexão CLI

// Importa a classe responsável pela conexão com o banco de dados.
require_once __DIR__ . '/ConexaoBanco.php';

// Define o caminho do arquivo com as configurações do banco.
const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

try {
    // Obtém a conexão com o PostgreSQL usando o Singleton.
    $conexao = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    // Consulta a versão do PostgreSQL para confirmar a conexão.
    $versao = $conexao->query('SELECT version()')->fetchColumn();

    // Exibe as informações de conexão no terminal.
    echo "====================================\n";
    echo " DIAGNÓSTICO DO POSTGRESQL\n";
    echo "====================================\n";
    echo "Porta: 5432\n";
    echo "Status: CONEXÃO REALIZADA COM SUCESSO!\n";
    echo "PostgreSQL: {$versao}\n";

} catch (PDOException $e) {

    // Exibe uma mensagem segura caso a conexão apresente algum erro.
    echo "====================================\n";
    echo " ERRO DE CONEXÃO\n";
    echo "====================================\n";
    echo "Não foi possível acessar o PostgreSQL.\n";
    echo "Verifique o servidor, a porta e o banco.\n";
}