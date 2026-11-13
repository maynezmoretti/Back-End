<?php
declare(strict_types=1);

// Solicita uma senha ao usuário
$senha = readline("Digite uma senha: ");

// Gera o hash usando Argon2id
$hash = password_hash($senha, PASSWORD_ARGON2ID);

// Separa as partes do hash
$partes = explode('$', $hash);

// Mostra o resultado
echo "\nHASH GERADO:\n";
echo $hash . "\n\n";

// Identifica cada parte do hash
echo "Algoritmo: " . $partes[1] . "\n";
echo "Versão: " . $partes[2] . "\n";
echo "Custos: " . $partes[3] . "\n";
echo "Salt em Base64: " . $partes[4] . "\n";
echo "Hash final: " . $partes[5] . "\n";