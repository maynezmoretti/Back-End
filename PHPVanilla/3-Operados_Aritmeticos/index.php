<?php
// 1. Blindagem de operações entre variáveis de tipos diferentes
declare(strict_types=1);

// Criar um cálculo de Holerite em PHP

// 2. Declaração das Constantes
const TAXA_INSS = 0.08; // 8% = 8/100
const DESCONTO_VT = 150.00;

// 3. Declarar as Variáveis
// Dados do funcionário
$nomeFuncionario = "Mayne Moretti";
$salarioBase = 3200.00;
$horasExtras = 10; // 10h extras no mês

// Declaração de Variáveis usando o lowerCamelCase
// Regra -> Primeira palavra apenas com letras minúsculas e nas demais usa-se letra maiúscula na primeira letra.
// Exemplo: $hojeEstaUmDiaBonito

// 4. Cálculos do Salário
// Valor da hora extra (1.6 da hora normal)
$valorHoraExtra = $salarioBase/220 * 1.6;

// -> Crie uma Variável $totalHorasExtras
$totalHorasExtras = $valorHoraExtra * $horasExtras;
// -> Crie uma Variável $salarioBruto
$salarioBruto = $salarioBase + $totalHorasExtras;
// -> Crie uma Variável $descontoInss
$descontoInss = $salarioBruto * TAXA_INSS;
// -> Crie uma Variável $salarioLiquido
$salarioLiquido = ($salarioBruto - $descontoInss) - DESCONTO_VT;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holerite <?php echo $nomeFuncionario ?></title>
    <!-- Folha de Estilização CSS -->
     <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Demonstrativo de Pagamento</h2>
    <!-- Saída de Dados misturando PHP e HTML em uma tabela -->
     <table>
        <tr>
            <th>Colaborador(a)</th>
            <td><?php echo $nomeFuncionario; ?></td>
        </tr>
        <tr>
            <th>Salário Base</th>
            <td>R$ <?php echo number_format($salarioBase, 2, ",", "."); ?></td>
            <!-- Usando uma função chamada number_format (formata a saída de números) -->
        </tr>
        <!-- Fazer as demais linhas da tabela utilizando as Variáveis criadas -->
         <tr>
            <th>Horas Extras</th>
            <td><?php echo $horasExtras; ?></td>
         </tr>
            <tr>
                <th>Valor da Hora Extra</th>
                <td><?php echo number_format($valorHoraExtra, 2, ",", "."); ?></td>
            </tr>
            <tr>
                <th>Total de Horas Extras</th>
                <td><?php echo number_format($totalHorasExtras, 2, ",", "."); ?></td>
            </tr>
              <tr>
                <th>Salário Bruto</th>
                <td><?php echo number_format($salarioBruto, 2, ",", "."); ?></td>
             </tr>
              <tr>
                <th>Desconto INSS</th>
                <td><?php echo number_format($descontoInss, 2, ",", "."); ?></td>
            </tr>
             <tr>
                <th>Salário Líquido</th>
                <td><?php echo number_format($salarioLiquido, 2, ",", "."); ?></td>
            </tr>
         </tr>
     </table>

</body>
</html>