<?php
declare(strict_types=1);

//Exercício 2: Perfil do Usuário

$usuario = [
    "nome" => "Carlos Eduardo",
    "idade" => 28,
    "cidade" => "Americana",
    "estado" => "SP",
    "premium" => true
];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
</head>

<body>

    <div>

        <h1>
            <?php echo $usuario["nome"]; ?>

            <?php
            if ($usuario["premium"] == true) {
                echo " ⭐";
            }
            ?>
        </h1>

        <p>Idade: <?php echo $usuario["idade"]; ?></p>

        <p>
            Cidade:
            <?php echo $usuario["cidade"]; ?>
            -
            <?php echo $usuario["estado"]; ?>
        </p>

    </div>

</body>

</html>