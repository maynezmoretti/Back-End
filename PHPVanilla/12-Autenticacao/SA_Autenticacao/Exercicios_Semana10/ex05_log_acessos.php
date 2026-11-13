<?php
declare(strict_types=1);

require_once 'includes/bootstrap.php';
require_once 'guard.php';

// Protege a página para administradores
verificarPermissao('ADMIN');

// Busca os últimos registros de acesso
$registros = $usuarioDAO->ultimosAcessos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Auditoria de acessos</title>
</head>
<body>

    <h1>Registro de acessos</h1>

    <!-- Tabela com os registros do banco -->
    <table border="1">
        <tr>
            <th>E-mail</th>
            <th>IP</th>
            <th>Navegador</th>
            <th>Sucesso</th>
            <th>Data e hora</th>
        </tr>

        <?php foreach ($registros as $registro): ?>
            <tr>
                <td><?= htmlspecialchars($registro['email']) ?></td>
                <td><?= htmlspecialchars($registro['ip']) ?></td>
                <td><?= htmlspecialchars($registro['user_agent']) ?></td>
                <td><?= $registro['sucesso'] ? 'Sim' : 'Não' ?></td>
                <td><?= htmlspecialchars($registro['data_hora']) ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

    <br>

    <a href="logout.php">Sair</a>

</body>
</html>