<?php 
declare(strict_types=1); 
 
// Aplicação de página única utilizando as variáveis superglobais
// ($_GET, $_POST, $_SERVER) junto com formulários HTML de método GET e POST 
 
// Dados simulados para aplicação 
 
$produtos = [ 
    ['nome' => 'Teclado USB', 'categoria' => 'Eletrônicos', 'preco' => 80.00], 
    ['nome' => 'Mouse sem fio', 'categoria' => 'Eletrônicos', 'preco' => 65.00], 
    ['nome' => 'Caderno', 'categoria' => 'Papelaria', 'preco' => 25.00], 
    ['nome' => 'Caneta azul', 'categoria' => 'Papelaria', 'preco' => 3.50], 
    ['nome' => 'Monitor 24 polegadas', 'categoria' => 'Eletrônicos', 'preco' => 899.90], 
]; 
 
// Declaração de variáveis 
 
$mensagemSucesso = "";
$erros = [];
$cadastros = [];

$nome = "";
$email = "";
 
// Criando o processo de GET
// Buscar na lista de produtos e retornar uma lista filtrada
 
// Busca pelo nome 
$buscaProduto = trim((string) ($_GET["produto"] ?? "")); 
 
// Recebe o valor do input preco_maximo 
$precoMaximoTexto = trim((string) ($_GET["preco_maximo"] ?? "")); 
 
// Copiando a lista de produtos para produtos filtrados 
$produtosFiltrado = $produtos; 
 
// Criar o mecanismo de filtragem para produtos 
if($buscaProduto !== "" || $precoMaximoTexto !== ""){ 

    $produtosFiltrado = array_filter(
        $produtos, 
        function (array $produto) use ($buscaProduto, $precoMaximoTexto): bool { 
            
            $nomeStatus = true; 
            $precoStatus = true; 
 
            // Verificação se no nome do produto contém o termo de busca 
            if($buscaProduto !== ""){ 
                $nomeStatus = str_contains(
                    strtolower($produto["nome"]), 
                    strtolower($buscaProduto)
                ); 
            } 
 
            // Verificar o preço de um produto e filtrar
            // se o produto for menor que o preço máximo determinado 
            if($precoMaximoTexto !== ""){ 
                $precoMaximo = filter_var(
                    $precoMaximoTexto, 
                    FILTER_VALIDATE_FLOAT
                ); 

                $precoStatus = $precoMaximo !== false 
                    && $produto["preco"] <= $precoMaximo; 
            } 
 
            return $nomeStatus && $precoStatus; 
        }
    ); 
 
} 
 
// Processamento do Método POST
// Permitir o cadastro fake de um cliente
 
// Verifica o status da SuperGlobal $_SERVER
if($_SERVER["REQUEST_METHOD"] === "POST") { 

    // Recuperar os dados do formulário 
    $nome = trim((string) ($_POST["nome"] ?? "")); 
    $email = trim((string) ($_POST["email"] ?? "")); 
 
    // Validação de dados ao lado do servidor 
 
    // Enviar uma mensagem de erro se o nome
    // for menor que 3 caracteres 
    if(strlen($nome) < 3){ 
        $erros["nome"] = "Informe um nome de pelo menos 3 caracteres"; 
    } 
 
    // Validar email do usuário 
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ 
        $erros["email"] = "Informe um email válido"; 
    } 
 
    // Se não existir erros, o cadastro será realizado 
    if($erros === []){ 

        $mensagemSucesso = "Cadastro realizado com sucesso!";

        $usuario = [
            "nome" => $nome,
            "email" => $email
        ];

        array_push($cadastros, $usuario);
    } 
 
} 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de GET e POST no PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Exemplo prático: GET e POST</h1>

        <section>
            <h2>Utilização de filtro pela URL (GET)</h2>

            <form action="index.php" method="GET">
                <label for="produto">Nome do produto</label>
                <input type="text" name="produto" id="produto" placeholder="Buscar produto">

                <label for="preco_maximo">Preço máximo</label>
                <input type="number" name="preco_maximo" id="preco_maximo" step="0.01" placeholder="100">

                <button type="submit">Pesquisar</button>
            </form>

            <h2>Lista de Produtos Filtrados</h2>
            <p>Observem que os dados da pesquisa aparecem na URL</p>

            <?php if ($produtosFiltrado === []): ?>
                <p class="vazio">Nenhum produto encontrado.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtosFiltrado as $produto): ?>
                            <tr>
                                <td><?= $produto['nome'] ?></td>
                                <td><?= $produto['categoria'] ?></td>
                                <td>
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>

        </section>

        <section>
            <h2>Cadastro de alunos com POST</h2>
            <p>Os dados serão enviados no corpo (body) da requisição e não aparecem na URL</p>

            <?php if($mensagemSucesso !== ""):?>
                <div class="sucesso">
                    <?=  $nome ?><br>
                    <?=  $email ?>
                </div>

                <?php endif; ?>

                <form action="index.php" method="POST">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" placeholder="Digite seu nome">
                    <?php if(isset($erros["nome"])): ?>
                        <div class="erro">
                            <?= $erros["nome"] ?>
                        </div>
                    <?php endif; ?>

                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Digite seu email">
                    <?php if(isset($erros["email"])): ?>
                        <div class="erro">
                            <?= $erros["email"] ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit">Cadastrar</button>
                </form>
        </section>
    </main>
</body>
</html>