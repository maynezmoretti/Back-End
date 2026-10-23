<?php
declare(strict_types=1);

// Importa os arquivos necessários para a conexão e o acesso ao banco
require_once __DIR__ . "/src/ConexaoBanco.php";
require_once __DIR__ . "/src/AlmoxarifadoDAO.php";

// Caminho do arquivo de configuração do banco de dados
const CONFIG_PATH = __DIR__ . "/config/database.ini";

// Classe responsável pelo cadastro e pela consulta das peças industriais
final class ex01_cli_ferramentas
{
    // Guarda a conexão com o banco de dados
    private PDO $pdo;

    // Recebe a conexão ao criar o objeto
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Insere uma nova peça no banco de dados
    public function cadastrar(array $dados): bool
    {
        $sql = "INSERT INTO pecas_industriais
                (codigo_sku, descricao, categoria, quantidade, preco_unitario)
                VALUES (:codigo_sku, :descricao, :categoria, :quantidade, :preco_unitario)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":codigo_sku" => trim($dados["codigo_sku"]),
            ":descricao" => trim($dados["descricao"]),
            ":categoria" => trim($dados["categoria"]),
            ":quantidade" => (int) $dados["quantidade"],
            ":preco_unitario" => (float) $dados["preco_unitario"]
        ]);
    }

    // Retorna todas as peças cadastradas
    public function buscarAtivo(): array
    {
        $sql = "SELECT * FROM pecas_industriais";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Obtém a conexão com o banco de dados
$pdo = ConexaoBanco::obterConexao(CONFIG_PATH);

// Cria o objeto responsável pelas operações com as peças
$ferramentas = new ex01_cli_ferramentas($pdo);

// Inicializa a opção do menu
$opcao = 0;

// Exibe o menu até que o usuário escolha sair
while ($opcao != 3) {
    echo "\n===== MENU DE PEÇAS INDUSTRIAIS =====\n";
    echo "1 - Cadastrar peça industrial\n";
    echo "2 - Listar peças industriais\n";
    echo "3 - Sair\n";

    $opcao = (int) readline("Escolha uma opção: ");

    // Executa o cadastro de uma peça
    if ($opcao == 1) {
        $dados = [];

        $dados["codigo_sku"] = readline("Código SKU: ");
        $dados["descricao"] = readline("Descrição: ");
        $dados["categoria"] = readline("Categoria: ");
        $dados["quantidade"] = readline("Quantidade: ");
        $dados["preco_unitario"] = readline("Preço unitário: ");

        if ($ferramentas->cadastrar($dados)) {
            echo "Peça cadastrada com sucesso!\n";
        } else {
            echo "Erro ao cadastrar peça!\n";
        }

    // Consulta e exibe as peças cadastradas
    } elseif ($opcao == 2) {
        $resultado = $ferramentas->buscarAtivo();

        // Mostra os dados de cada peça encontrada
        foreach ($resultado as $peca) {
            echo "\nCódigo SKU: " . $peca["codigo_sku"] . "\n";
            echo "Descrição: " . $peca["descricao"] . "\n";
            echo "Categoria: " . $peca["categoria"] . "\n";
            echo "Quantidade: " . $peca["quantidade"] . "\n";
            echo "Preço: R$ " . $peca["preco_unitario"] . "\n";
        }

        // Avisa quando não existem peças cadastradas
        if (count($resultado) == 0) {
            echo "Nenhuma peça encontrada.\n";
        }

    // Finaliza o programa
    } elseif ($opcao == 3) {
        echo "Encerrando o programa...\n";

    // Avisa quando a opção escolhida não é válida
    } else {
        echo "Opção inválida! Tente novamente.\n";
    }
}