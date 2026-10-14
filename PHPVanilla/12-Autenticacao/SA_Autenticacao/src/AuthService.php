<?php
declare(strict_types=1);

// Classe para verificação de usuários através da autenticação
// Criação de sessão e cookies de navegador

final class AuthService {
    // atributo
    private const TEMPO_INATIVIDADE_SEG = 900; // 900 seg -> 15 min

    // criar funções static -> não precisa criar objeto -> funções executadas diretamente pela classe
    public static function iniciarSessaoSegura(): void {
        if(session_start() === PHP_SESSION_NONE) { // verifica se a sessão já existe
            // se não existir -> cria uma
            // cria os parâmetros do cookie
            session_set_cookie_params([
                "lifetime"  => 0,
                "path"      => "/",
                "httponly"      => true,
                "samesite"      => "Lax",
            ]);
            // inicia session
            session_start();
        }
    }
    // gravar os dados do usuário na sessão e gerar um identificador
    public static function autenticar(array $usuario): void {
        // iniciar a session
        self::iniciarSessaoSegura(); // criar
        session_regenerate_id(true);

        // gravando na superglobal as informações do usuário conectado
        $_SESSION["usuario_id"]     = (int) $usuario["id"];
        $_SESSION["usuario_nome"]   = (string) $usuario["nome"];
        $_SESSION["usuario_email"]  = (string) $usuario["email"];
        $_SESSION["usuario_perfil"] = (string) $usuario["perfil"];
        $_SESSION["ultimo_acesso"]  = time();

    }

    // verificação de tempo de inatividade
    public static function verificarExpiracao(): bool {
        self::iniciarSessaoSegura();
        // se não tiver sessão, inicia uma (direciona para login)
        if(!isset($_SESSION["ultimo_acesso"])) {
            return true;
        }
        // se já existir uma sessão iniciada, e passou do tempo de inatividade
        if((time()- $_SESSION["ultimo_acesso"]) > self::TEMPO_INATIVIDADE_SEG) {
            self::destruirSessao(); // deslogar o usuário
            return true; // retornar para tela de login
        }
        $_SESSION["ultimo_acesso"] = time();
        return false; // continua logado
    }

    // destruir a session -> função que permite deslogar o usuário e limpar os dados da sessão
    public static function destruirSessao(): void {
        self::iniciarSessaoSegura();
        // limpa os dados da sessão atual no servidor
        $_SESSION=[];

        // limpando os dados dos cookies da sessão
        if(ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), "", time()-42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // executa a função nativa de logout de sessão
        session_destroy();
    }
}