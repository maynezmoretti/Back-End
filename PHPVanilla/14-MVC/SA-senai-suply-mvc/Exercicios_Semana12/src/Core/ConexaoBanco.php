<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

class ConexaoBanco
{
    private static ?PDO $instancia = null;

    private function __construct()
    {
    }

    public static function obterConexao(): PDO
    {
        if (self::$instancia === null) {
            self::$instancia = self::conectar();
        }

        return self::$instancia;
    }

    private static function conectar(): PDO
    {
        $config = parse_ini_file(
            dirname(__DIR__, 2) . '/config/database.ini',
            true
        );

        $dados = $config['database'];

        $dsn = "pgsql:host={$dados['host']};port={$dados['port']};";
        $dsn .= "dbname={$dados['dbname']}";

        return new PDO($dsn, $dados['user'], $dados['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
}
