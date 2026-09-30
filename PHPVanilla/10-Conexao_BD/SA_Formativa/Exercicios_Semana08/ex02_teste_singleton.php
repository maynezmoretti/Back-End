<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos de Laboratório
// Exercício 2: Prova de Fogo do Singleton (Teste de Identidade de Objetos)

// Importa a classe responsável pela conexão com o banco de dados.
require_once __DIR__ . '/ConexaoBanco.php';

// Define o caminho do arquivo de configuração do banco.
const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

try {
    // Obtém a primeira conexão usando o Singleton.
    $conexao1 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    // Tenta obter uma segunda conexão usando o mesmo Singleton.
    $conexao2 = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    // Verifica se as duas variáveis apontam para o mesmo objeto.
    $mesmaInstancia = $conexao1 === $conexao2;

    // Exibe o título do teste.
    echo "Teste do Singleton\n";
    echo "==================\n";

    // Exibe o identificador do primeiro objeto.
    echo "ID da conexão 1: " . spl_object_id($conexao1) . "\n";

    // Exibe o identificador do segundo objeto.
    echo "ID da conexão 2: " . spl_object_id($conexao2) . "\n";

    // Verifica se as duas conexões são a mesma instância.
    if ($mesmaInstancia) {
        echo "Resultado: as duas variáveis apontam para o mesmo objeto.\n";
        echo "Singleton funcionando corretamente!\n";
    } else {
        // Informa caso tenham sido criados objetos diferentes.
        echo "Resultado: foram criados objetos diferentes.\n";
    }

} catch (PDOException $e) {

    // Exibe uma mensagem segura caso ocorra um erro na conexão.
    echo "Não foi possível realizar o teste de conexão.\n";
}