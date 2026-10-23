## Parte A — Exercícios Teóricos de Fixação

### 1. Procedural vs. OO
*Quais são os três principais riscos técnicos de manter regras financeiras críticas implementadas puramente através de arrays associativos e scripts procedurais?*

Manter regras financeiras em arrays e scripts procedurais dificulta a organização do código, aumenta a chance de erros e torna a manutenção mais complicada. Além disso, pode permitir alterações indevidas nos dados da conta e dificultar a aplicação de regras de negócio. A programação orientada a objetos ajuda a organizar essas regras, proteger os dados e facilitar a reutilização do código.

### 2. Ciclo de Vida do Objeto
*O que ocorre na memória Heap do servidor quando a instrução `new ContaCorrente(...)` é executada? Qual é o papel do método `__construct()` nesse processo?*

Quando executamos `new ContaCorrente(...)`, um novo objeto é criado na memória do servidor. O método `__construct()` é executado automaticamente para inicializar o objeto, atribuindo valores aos seus atributos e preparando-o para ser utilizado no sistema.

### 3. A Pseudo-Variável `$this`
*Explique por que o comando `$this->saldo` é obrigatório para acessar um atributo dentro da classe, diferenciando-o de uma variável local `$saldo`.*

O comando `$this->saldo` acessa o atributo `saldo` pertencente ao objeto atual. Já a variável local `$saldo` existe apenas dentro do escopo em que foi declarada. Portanto, `$this` permite diferenciar os atributos do objeto das variáveis locais utilizadas nos métodos da classe.

```php
class Financeiro {
    // atributo
    private float $saldo;

    // método de acesso
    public function setSaldo(float $valor) {
        $saldo = $valor;
        $this->saldo += $saldo;
    }
}
financeiro->setSaldo(20.00)
```

### 4. Encapsulamento e Invariantes
*Por que um desenvolvedor sênior de back-end nunca deve criar um método `public function setSaldo(float $novoSaldo)` para uma conta bancária?*

Um método público `setSaldo()` permitiria alterar diretamente o saldo da conta, sem garantir que as regras financeiras fossem respeitadas. Isso poderia causar inconsistências, como modificar o saldo sem realizar um depósito ou uma retirada válida. O ideal é permitir alterações somente por meio de métodos que validem as operações financeiras.

### 5. Modificadores de Acesso
*Qual é a diferença prática entre os modificadores `private` e `protected` quando subclasses entram em cena através do `extends`?*

O modificador `private` permite acessar o atributo ou método somente dentro da própria classe em que foi declarado. Já o `protected` permite o acesso dentro da própria classe e também nas classes filhas que herdam dela por meio de `extends`.

### 6. Constructor Property Promotion
*Como o recurso de promoção de propriedades introduzido no PHP 8 reduz o boilerplate e melhora a legibilidade do código?*

A promoção de propriedades permite declarar e inicializar atributos diretamente nos parâmetros do construtor, utilizando modificadores como `public`, `private` ou `protected`. Isso reduz a quantidade de código repetido e deixa a classe mais organizada e fácil de entender.

### 7. Propriedades `readonly`
*Explique o mecanismo de segurança proporcionado pela palavra-chave `readonly` em atributos de classes de valor como Titular ou CPF.*

A palavra-chave `readonly` impede que uma propriedade seja alterada depois de receber seu valor inicial, respeitando as regras de inicialização do PHP. Isso ajuda a proteger informações que não devem mudar durante a execução do objeto, como um CPF.

### 8. Classes Abstratas
*Por que faz todo sentido no modelo bancário que a classe `ContaBancaria` seja declarada como `abstract` enquanto `ContaCorrente` e `ContaPoupanca` são classes concretas?*

A classe `ContaBancaria` é abstrata porque representa um modelo geral de conta, que pode possuir atributos e métodos compartilhados entre diferentes tipos de contas. Ela não pode ser instanciada diretamente. Já `ContaCorrente` e `ContaPoupanca` são classes concretas, pois representam tipos específicos de contas que podem ser utilizados para criar objetos.

### 9. Polimorfismo
*Como o método `transferir(float $valor, ContaBancaria $destino)` consegue operar transferências entre quaisquer tipos de contas filhas sem precisar saber qual é a classe exata da conta de destino?*

Isso acontece por meio do polimorfismo. Como `ContaCorrente` e `ContaPoupanca` herdam de `ContaBancaria`, ambas podem ser recebidas pelo parâmetro `$destino`. Assim, o método pode trabalhar com qualquer uma dessas contas usando os comportamentos definidos na classe base, sem precisar verificar a classe exata do objeto.

### 10. Exceções de Domínio
*Por que é uma péssima prática retornar `false` ou `null` quando uma operação de saque é rejeitada por falta de saldo?*

Retornar `false` ou `null` pode dificultar a identificação do motivo pelo qual o saque foi rejeitado. Utilizar uma exceção específica, como `SaldoInsuficienteException`, permite informar claramente o erro. Dessa forma, o código fica mais organizado e facilita o tratamento adequado dos erros financeiros.