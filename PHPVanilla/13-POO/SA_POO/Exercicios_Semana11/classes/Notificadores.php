<?php
declare(strict_types=1);

// Define o padrão de todos os notificadores
interface NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool;
}

// Notificação por e-mail
class NotificadorEmail implements NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool
    {
        if ($titular->getEmail() === '') {
            return false;
        }

        echo "[E-mail] {$titular->getEmail()}: $mensagem" . PHP_EOL;
        return true;
    }
}

// Notificação por SMS
class NotificadorSMS implements NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool
    {
        if ($titular->getTelefone() === '') {
            return false;
        }

        echo "[SMS] {$titular->getTelefone()}: $mensagem" . PHP_EOL;
        return true;
    }
}

// Notificação por WhatsApp
class NotificadorWhatsApp implements NotificadorInterface
{
    public function notificar(Titular $titular, string $mensagem): bool
    {
        if ($titular->getTelefone() === '') {
            return false;
        }

        echo "[WhatsApp] {$titular->getTelefone()}: $mensagem" . PHP_EOL;
        return true;
    }
}