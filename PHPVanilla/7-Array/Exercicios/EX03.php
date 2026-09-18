<?php
declare(strict_types=1);

//Exercício 3: Folha de Pagamento do RH

$funcionarios = [
    ["id" => 1, "nome" => "Ana Souza", "cargo" => "Dev Front-End", "salario" => 4500.00],
    ["id" => 2, "nome" => "Bruno Costa", "cargo" => "Dev Back-End", "salario" => 5200.00],
    ["id" => 3, "nome" => "Carla Dias", "cargo" => "Tech Lead", "salario" => 8900.00],
    ["id" => 4, "nome" => "Daniel Silva", "cargo" => "Estagiário", "salario" => 1500.00]
];

$totalFolha = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Folha de Pagamento</title>
</head>

<body>

    <h1>Folha de Pagamento</h1>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cargo</th>
            <th>Salário</th>
        </tr>

        <?php foreach ($funcionarios as $funcionario): ?>

            <tr>

                <td>
                    <?php echo $funcionario["id"]; ?>
                </td>

                <td>
                    <?php echo $funcionario["nome"]; ?>
                </td>

                <td>
                    <?php echo $funcionario["cargo"]; ?>
                </td>

                <td>
                    R$ <?php echo number_format($funcionario["salario"], 2, ",", "."); ?>
                </td>

            </tr>

            <?php
            $totalFolha += $funcionario["salario"];
            ?>

        <?php endforeach; ?>

    </table>

    <h2>
        Total da Folha:
        R$ <?php echo number_format($totalFolha, 2, ",", "."); ?>
    </h2>

</body>

</html>

}
?>