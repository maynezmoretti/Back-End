<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

// Criar a Classe responsável por fornecer uma instancia única de conexão usando PDO com o Banco de Dados (Singleton)

final class ConexaoBanco{
    // Atributos => são as características do objeto
    private static ?PDO $instancia = null; // Muda de acordo com a conexão. Inicialmente é nulo, mas depois pode mudar para conectado

    // Métodos (ações que o objeto pode fazer)

    // Construtor
    private function __construct(){} // Construtor vazio e privado (técnica do Singleton)

    // Para garantia de segurança // Bloqueio de Clonagem // Desserialização
    private function __clone(): void {}
    public function __wakeup(): void {throw new \Exception("Desserialização não permitida no Singleton");}

    // Fazer a técnica de obterConexao PDO
    public static function obterConexao(string $caminhoConfig):PDO {
        // Vou criar uma nova conexão se não existir outra
        if(self::$instancia === null){
            // Vou criar uma conexão
            $config = self::carregarArquivoConfig($caminhoConfig);
            self::$instancia = self::estabelecerConexao($config);
        }
        return self::$instancia;
    }

    // Lê e valida os parâmetros do arquivo de configuração, dados envelopados .ini ou .env
    private static function carregarArquivoConfig(string $caminho):array{
        if(!file_exists($caminho)){
            throw new \RuntimeException("Arquivo de configuração não encontrado em : {$caminho}");
        }
        $dados = parse_ini_file($caminho, true);
        if($dados === false || !isset($dados["database"])){
            throw new \RuntimeException("Seção [database] ausente no arquivo de configuração");
        }
        return $dados["database"];
    }

    // Criar a instancia nativa do PDO aplicando as flags de Segurança do PDO
    private static function estabelecerConexao(array $cfg): PDO{
        $dsn = sprintf(
            "%s:host=%s;port=%s;dbname=%s",
            $cfg["db_driver"],
            $cfg["db_host"],
            $cfg["db_port"],
            $cfg["db_name"],
        );
        // Colocar a Flag do PDO
        $opcoes = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5
        ];

        return new PDO($dsn, $cfg["db_user"], $cfg["db_pass"], $opcoes);
    }

}
?>