<?php
declare(strict_types=1);

namespace App\Core;

// Classe de centralização de logs corporativos para persistência na raiz do projeto

final class Logger {
    // Registro de eventos de log para auditoria/erros e avisos
    private static function gravar(string $nivel, string $mensagem, array $contexto): void {
        // Gravar o arquivo na raiz do servidor
        $caminho = dirname(__DIR__, 2) . "/logs";
        if(!is_dir($caminho)) {
            mkdir($caminho, 0755, true);
        }
        $ip = $_SERVER["REMOTE_ADDR"] ?? "CLI"; // Pega o IP do usuário
        $dataHora = date("Y-m-d H:i:s"); // Pega data e hora
        $detalhe = !empty($contexto) ? " " .json_encode($contexto, JSON_UNESCAPED_UNICODE) : "";
        $linha = sprintf("[%s] [%s] [IP: %s] %s%s%s", $dataHora, $nivel, $ip, $mensagem, $detalhe, PHP_EOL);
        file_put_contents($caminho . "/app.log", $linha, FILE_APPEND | LOCK_EX);
    }

    // Criar os métodos para identificar os logs (auditoria, aviso, erro)
    // Registro evento informativo de auditoria
    public static function info(string $mensagem, array $contexto=[]): void {
        self::gravar("INFO", $mensagem, $contexto);
    }
    // Registro de aviso - Violação de Regra de Negócio
    public static function aviso(string $mensagem, array $contexto=[]): void {
        self::gravar("AVISO", $mensagem, $contexto);
    }
    // Registro de falha de erro - Execução crítica
    public static function erro(string $mensagem, array $contexto=[]): void {
        self::gravar("ERRO", $mensagem, $contexto);
    }

    // OBS: Métodos ou atributos "static" -> São executados ou chamados diretamente pela classe
    // Sem a necessidade de instanciar um objeto
    // Podemos fazer uma analogia a um objeto descartável
    // Serve apenas para uma única tarefa e depois é jogado fora
    // Evita ocupar espaço na memória com objetos que não serão mais usados
    
}