<!-- O banco  precisa de um painel financeiro que projete a evolução de uma dívida de um cliente inadimplente ao longo de 12 meses. O sistema deve calcular os "Juros Compostos" mês a mês.

Regras de Negócio:
Classificação de Risco: O sistema deve avaliar a Categoria do Cliente ('A', 'B', 'C') utilizando a estrutura match e definir a taxa de juros:
Categoria 'A' ➔ Juros de 0.01 (1% ao mês)
Categoria 'B' ➔ Juros de 0.02 (2% ao mês)
Categoria 'C' ➔ Juros de 0.03 (3% ao mês)
Qualquer outra coisa (default) ➔ Juros de 0.05 (5% - Risco Máximo)
Projeção da Dívida: Você deve usar um laço for para gerar exatamente 12 meses de dívida.

Cálculo: Todo mês, o valor da dívida sofre um aumento. A fórmula de cada mês é: Juros do Mês = Dívida Atual * Taxa. O saldo atualizado passa a ser Dívida Atual + Juros do Mês.
A Regra da Anistia: Por causa de uma campanha do banco, no 6º mês não haverá cobrança de juros! Você deve usar o comando continue para identificar o mês 6, pular o cálculo matemático, e imprimir uma mensagem de isenção na tabela. -->

<?php
declare(strict_types=1);

$categoriaCliente = 'A';
$divida = 1000.00;

$taxa = match ($categoriaCliente) {
    'A' => 0.01,
    'B' => 0.02,
    'C' => 0.03,
    default => 0.05
};

echo "Projeção da Divida\n";
echo "Categoria do cliente: $categoriaCliente\n";
echo "Taxa de juros: " . ($taxa * 100) . "% ao mes\n";
echo "Divida inicial: R$ " . number_format($divida, 2, ',', '.') . "\n";

for ($mes = 1; $mes <= 12; $mes++) {

    if ($mes == 6) {
        echo "Mês $mes: Isenção de Juros\n";
        echo "Saldo: R$ " . number_format($divida, 2, ',', '.') . "\n";
        continue;
    }

    $juros = $divida * $taxa;
    $divida = $divida + $juros;

    echo "Mês $mes:\n";
    echo "Juros: R$ " . number_format($juros, 2, ',', '.') . "\n";
    echo "Saldo: R$ " . number_format($divida, 2, ',', '.') . "\n";
}
?>