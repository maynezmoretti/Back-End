<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos de Laboratório
// Exercício 5: Medidor de Desempenho e Pool de Conexões

// Importa a classe responsável pela conexão Singleton.
require_once __DIR__ . '/ConexaoBanco.php';

// Define o caminho do arquivo de configuração.
const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

// Define a quantidade de testes realizados.
const TOTAL_TESTES = 50;

/**
 * Carrega as configurações do banco.
 */
function carregarConfiguracao(): array
{
    // Lê as configurações do arquivo database.ini.
    $config = parse_ini_file(ARQUIVO_CONFIG);

    // Verifica se o arquivo foi carregado corretamente.
    if ($config === false) {
        throw new RuntimeException(
            'Não foi possível carregar o arquivo database.ini.'
        );
    }

    return $config;
}

/**
 * Cria uma nova conexão PDO.
 */
function criarConexao(array $config): PDO
{
    // Monta a string DSN usando os dados do PostgreSQL.
    $dsn = "{$config['db_driver']}:"
        . "host={$config['db_host']};"
        . "port={$config['db_port']};"
        . "dbname={$config['db_name']}";

    // Cria uma nova conexão com o banco.
    return new PDO(
        $dsn,
        $config['db_user'],
        $config['db_pass'],
        [
            // Faz o PDO lançar exceções quando ocorrer um erro.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

            // Faz os resultados das consultas retornarem como arrays associativos.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

            // Desativa a emulação de prepared statements.
            PDO::ATTR_EMULATE_PREPARES => false,

            // Define o tempo máximo de espera pela conexão.
            PDO::ATTR_TIMEOUT => 5
        ]
    );
}

/**
 * Mede o desempenho de 50 conexões novas.
 */
function testarNovasConexoes(array $config): array
{
    // Inicia a contagem do tempo e da memória.
    $inicio = microtime(true);
    $memoriaInicial = memory_get_usage();

    // Cria uma nova conexão em cada repetição.
    for ($i = 0; $i < TOTAL_TESTES; $i++) {
        $conexao = criarConexao($config);
        $conexao = null;
    }

    // Retorna o resultado do teste.
    return criarResultado($inicio, $memoriaInicial);
}

/**
 * Mede o desempenho utilizando o Singleton.
 */
function testarSingleton(): array
{
    // Inicia a contagem do tempo e da memória.
    $inicio = microtime(true);
    $memoriaInicial = memory_get_usage();

    // Reutiliza a mesma conexão nas 50 chamadas.
    for ($i = 0; $i < TOTAL_TESTES; $i++) {
        $conexao = ConexaoBanco::obterConexao(ARQUIVO_CONFIG);
    }

    // Retorna o resultado do teste.
    return criarResultado($inicio, $memoriaInicial);
}

/**
 * Calcula o tempo e a memória utilizados.
 */
function criarResultado(float $inicio, int $memoriaInicial): array
{
    // Calcula quanto tempo e memória foram utilizados.
    return [
        'tempo' => microtime(true) - $inicio,
        'memoria' => memory_get_usage() - $memoriaInicial
    ];
}

/**
 * Formata os resultados para a tabela.
 */
function formatarResultado(array $resultado): string
{
    // Formata o tempo com seis casas decimais.
    $tempo = number_format($resultado['tempo'], 6, ',', '.');

    // Formata a quantidade de memória utilizada.
    $memoria = number_format($resultado['memoria'], 0, ',', '.');

    // Retorna as células da tabela.
    return "<td>{$tempo} s</td><td>{$memoria} bytes</td>";
}

/**
 * Exibe uma linha da tabela HTML.
 */
function exibirLinha(string $metodo, array $resultado): void
{
    // Inicia uma nova linha da tabela.
    echo '<tr>';

    // Exibe o nome do método utilizado.
    echo "<td>{$metodo}</td>";

    // Exibe o tempo e a memória utilizados.
    echo formatarResultado($resultado);

    // Finaliza a linha da tabela.
    echo '</tr>';
}

try {
    // Carrega as configurações do banco.
    $config = carregarConfiguracao();

    // Executa o teste criando novas conexões.
    $resultadoNovas = testarNovasConexoes($config);

    // Executa o teste reutilizando o Singleton.
    $resultadoSingleton = testarSingleton();

} catch (PDOException $e) {

    // Exibe uma mensagem segura caso ocorra erro de conexão.
    echo '<h2>Erro de conexão</h2>';
    echo '<p>Não foi possível realizar o benchmark.</p>';
    exit;

} catch (RuntimeException $e) {

    // Exibe uma mensagem caso exista erro na configuração.
    echo '<h2>Erro de configuração</h2>';
    echo '<p>Verifique o arquivo database.ini.</p>';
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Benchmark PDO</title>
</head>

<body>

    <h1>Benchmark de Conexões PDO</h1>

    <p>
        Foram realizados <?= TOTAL_TESTES ?> testes em cada método.
    </p>

    <table border="1" cellpadding="8" cellspacing="0">

        <thead>
            <tr>
                <th>Método</th>
                <th>Tempo</th>
                <th>Memória</th>
            </tr>
        </thead>

        <tbody>

            <?php

            // Exibe o resultado das 50 novas conexões.
            exibirLinha(
                '50 novas conexões com PDO',
                $resultadoNovas
            );

            // Exibe o resultado das chamadas utilizando Singleton.
            exibirLinha(
                '50 chamadas reutilizando Singleton',
                $resultadoSingleton
            );

            ?>

        </tbody>

    </table>

</body>

</html>