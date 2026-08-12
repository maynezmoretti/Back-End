<?php declare(strict_types=1); // isso blinda o sistema contra misturas acidentais de tipos de dados
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudo de Variáveis</title>
</head>
<body>
    <h3>Estudo de Variáveis</h3>
    <?php
    // Sintaxe de Variáveis em PHP
    // Variáveis são representadas pelo símbolo "$", seguido do nome da Variável
    // exemplo:
    $nome = "Mayne"; // Variável do tipo String
    $idade = 16; // Variável do tipo Number (int)
    $status = true; // Variável do tipo Boolean
    $altura = 1.61; // Variável do tipo Number (float)
    $email = null; // Variável do tipo Null
    // $endereço; não é possível declarar uma Variável sem atribuir um valor a ela (não existe 'Undefined' em PHP)
    
    // exibir as Variáveis na tela
    echo "Nome: $nome <br>";
    echo "Idade: $idade <br>";
    echo "Status: $status <br>";
    echo "Altura: $altura <br>";
    echo "Email: $email <br>";

    echo "<br> <h3>Constantes</h3> <br>";
    // Constantes são representadas pela palavra "const" ou "define" seguida do nome da Constante
    // exemplos de Constantes:
    const PI = 3.14; // Constante do tipo Number (float)
    const EMPRESA = "Google"; // Constante do tipo String
    define("SITE", "www.google.com"); // Constante do tipo String
    // uma boa prática é utilizar letras maiúsculas para nomear Constantes, para as diferenciar das Variáveis

    // exibir as Constantes na tela
    echo "Valor de PI:  PI <br>";
    echo "Nome da Empresa: EMPRESA <br>";
    echo "Site: SITE <br>";

    // tentar alterar o valor de uma Constante irá gerar um erro, pois Constantes não podem ser alteradas
    // PI = 3.14159; // isso é um erro!

    // redeclarar uma Constante também irá gerar um erro
    // const SITE = "www.google.com.br"; // isso também é um erro!

    // Regra de Ouro: Sempre coloque a instrução 'declare(strict_types=1);' no início do seu código PHP, isso blinda o seu sistema contra misturas acidentais de tipos de dados. 
    
    // Utilização de TEXTO (Concatenação VS Interpolação)
    // Concatenação -> juntar duas ou mais 'String' utilizando o operador "." (ponto)
    // exemplo de Concatenação:
    echo "Olá, " . $nome . "! Seja bem-vindo ao nosso site! <br>";

    // Interpolação -> utilização de variáveis dentro de um texto, utilizando aspas duplas
    // exemplo de Interpolação:
    echo "$nome, tem $idade anos e sua altura é $altura metros. <br>";  // forma mais correta de misturar textos e variáveis
    

    ?>

</body>
</html>