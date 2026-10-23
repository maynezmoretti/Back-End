<?php
declare(strict_types=1);

// Abre a conexão com o banco de dados
function conectar(): PDO {
    return new PDO(
        "pgsql:host=localhost;dbname=almoxarifado_senai",
        "postgres",
        "postgres"
    );
}

// Realiza uma busca vulnerável usando o termo diretamente no SQL
function buscarVulneravel(string $termo): void {
    $pdo = conectar();
    $sql = "SELECT * FROM usuarios WHERE nome = '$termo'";

    echo "\nBusca vulnerável:\n";
    $stmt = $pdo->query($sql);

    // Exibe os nomes dos registros encontrados
    while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Registro encontrado: " . $resultado['nome'] . "\n";
    }
}

// Realiza uma busca segura usando parâmetro preparado
function buscarProtegido(string $termo): void {
    $pdo = conectar();
    $sql = "SELECT * FROM usuarios WHERE nome = :nome";

    echo "\nBusca protegida:\n";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $termo]);

    // Verifica se algum registro corresponde à busca
    if ($stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Registro encontrado.\n";
    } else {
        echo "Nenhum registro encontrado.\n";
    }
}

// Define o termo utilizado para testar as duas buscas
$termo = "' OR '1'='1";

// Executa a busca vulnerável e a busca protegida
buscarVulneravel($termo);
buscarProtegido($termo);