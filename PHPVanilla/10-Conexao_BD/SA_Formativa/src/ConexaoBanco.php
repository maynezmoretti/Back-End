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
?>