<?php
declare(strict_types=1);

// Parte B: Exercícios Práticos de Laboratório
// Exercício 4: Auditoria de Logs com Níveis de Severidade

/**
 * Registra uma mensagem no arquivo de log.
 */
function registrarLog(string $nivel, string $mensagem): void
{
    // Define os níveis de log que podem ser utilizados.
    $niveisPermitidos = ['INFO', 'WARNING', 'ERROR'];

    // Verifica se o nível informado é válido.
    if (!in_array($nivel, $niveisPermitidos, true)) {
        throw new InvalidArgumentException('Nível de log inválido.');
    }

    // Define a pasta onde os arquivos de log serão armazenados.
    $pastaLogs = __DIR__ . '/logs';

    // Cria a pasta caso ela ainda não exista.
    if (!is_dir($pastaLogs)) {
        mkdir($pastaLogs, 0775, true);
    }

    // Obtém a data e o horário atuais.
    $data = date('Y-m-d H:i:s');

    // Monta a linha que será gravada no arquivo.
    $linha = "[{$data}] [{$nivel}] {$mensagem}" . PHP_EOL;

    // Adiciona a mensagem ao final do arquivo de log.
    file_put_contents(
        $pastaLogs . '/sistema.log',
        $linha,
        FILE_APPEND | LOCK_EX
    );
}

// Importa a classe responsável pela conexão com o banco.
require_once __DIR__ . '/ConexaoBanco.php';

// Define o caminho do arquivo de configuração.
const ARQUIVO_CONFIG = __DIR__ . '/config/database.ini';

try {
    // Tenta realizar a conexão com o PostgreSQL.
    ConexaoBanco::obterConexao(ARQUIVO_CONFIG);

    // Registra no log que a conexão foi realizada com sucesso.
    registrarLog(
        'INFO',
        'Conexão com PostgreSQL realizada com sucesso.'
    );

    // Exibe uma mensagem de sucesso no terminal.
    echo "Conexão realizada com sucesso.\n";

} catch (PDOException $e) {

    // Registra o erro ocorrido no arquivo de log.
    registrarLog('ERROR', $e->getMessage());

    // Exibe uma mensagem segura para o usuário.
    echo "Não foi possível conectar ao banco de dados.\n";
}