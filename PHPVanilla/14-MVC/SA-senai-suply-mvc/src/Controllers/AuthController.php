<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Logger;
use App\Models\Usuario;

final class AuthController extends Controller {

    // Método para renderizar o formulário de login
    public function formularioLogin(): void {
        $this->renderizar("auth/login", [
            "titulo"    => "Login Corporativo - SENAI Suply",
            "csrfToken" => $this->obterCsrfToken()
        ]);
    }

    // Método de login -> Quando eu aperto o botão enviar
    public function login(): void {
        if(!$this->validarCsrfToken($_POST["csrf_token"] ?? null)) {
            $this->renderizar("auth/login", ["titulo" => "Login",
            "erro" => "Sessão expirada. Tente novamente."]);
            return;
        }

        // Pegar as informações do usuário que está fazendo o login
        $email = trim($_POST["email"] ?? "");
        $senha = (string)($_POST["senha"] ?? "");

        // Buscar as informações do usuário
        $usuario = Usuario::buscarPorEmail($email);
        if($usuario && $senha === $usuario["senha_hash"]) {
            session_regenerate_id(true);
            $_SESSION["usuario_id"] = (int) $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            $_SESSION["usuario_perfil"] = $usuario["perfil"];
            
            // Criar um log para o sistema
            Logger::info("Login corporativo bem-sucedido",
            ['usuario_id' => $usuario['id'], 'perfil' => $usuario['perfil']]);

            // Redireciona do login -> index
            $this->redirecionar("/");
        }

        // Se houver erro na verificação de senha ou email
        Logger::aviso("Falha na tentativa de login corporativo", ['email' => $email]);
        $this->renderizar('auth/login', ['titulo' => 'Login', 'erro' => 'Credenciais incorretas.', 'csrfToken' => $this->obterCsrfToken()]);
    }

    // Método de logout
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $usuarioId = $_SESSION['usuario_id'] ?? null;
        Logger::info("Logout efetuado pelo operador", ['usuario_id' => $usuarioId]);
        $_SESSION = [];
        session_destroy();
        $this->redirecionar('/login');
    }
}