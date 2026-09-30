<?php

declare(strict_types=1);

// Classe responsável por controlar a conexão única com o banco.
class ConexaoBanco
{
    // Armazena a única instância da conexão PDO.
    private static ?PDO $instancia = null;

    // Impede que a classe seja instanciada diretamente.
    private function __construct()
    {
    }

    // Impede que a conexão seja clonada.
    private function __clone()
    {
    }

    // Impede que a conexão seja recriada através de desserialização.
    public function __wakeup()
    {
        throw new Exception(
            'Não é permitido desserializar a conexão.'
        );
    }

    /**
     * Retorna a conexão única com o banco.
     */
    public static function obterConexao(string $arquivoConfig): PDO
    {
        // Cria a conexão somente se ela ainda não existir.
        if (self::$instancia === null) {
            self::$instancia = self::criarConexao($arquivoConfig);
        }

        // Retorna a mesma conexão nas próximas chamadas.
        return self::$instancia;
    }

    /**
     * Cria uma nova conexão PDO.
     */
    private static function criarConexao(string $arquivoConfig): PDO
    {
        // Carrega as configurações do arquivo INI.
        $config = self::carregarConfig($arquivoConfig);

        // Monta a string de conexão do PostgreSQL.
        $dsn = self::montarDsn($config);

        // Cria a conexão usando as configurações definidas.
        return new PDO(
            $dsn,
            $config['db_user'],
            $config['db_pass'],
            [
                // Faz o PDO lançar exceções quando ocorrer um erro.
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                // Retorna os resultados como arrays associativos.
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                // Desativa a emulação de prepared statements.
                PDO::ATTR_EMULATE_PREPARES => false,

                // Define o tempo máximo de espera pela conexão.
                PDO::ATTR_TIMEOUT => 5
            ]
        );
    }

    /**
     * Carrega as configurações do arquivo INI.
     */
    private static function carregarConfig(string $arquivo): array
    {
        // Lê o arquivo de configuração.
        $config = parse_ini_file($arquivo);

        // Verifica se o arquivo foi lido corretamente.
        if ($config === false) {
            throw new RuntimeException(
                'Não foi possível ler o arquivo de configuração.'
            );
        }

        // Retorna as configurações carregadas.
        return $config;
    }

    /**
     * Monta a string DSN para o PostgreSQL.
     */
    private static function montarDsn(array $config): string
    {
        // Define o driver, servidor, porta e banco utilizados.
        return "pgsql:host={$config['db_host']};"
            . "port={$config['db_port']};"
            . "dbname={$config['db_name']}";
    }
}