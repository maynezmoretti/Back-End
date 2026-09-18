## LISTA DE EXERCÍCIOS: FUNÇÕES EM PHP

Resolva primeiro os exercícios teóricos para verificar sua compreensão. Depois, crie arquivos PHP separados para os exercícios práticos e teste diferentes valores de entrada.

### Parte A: Exercícios Teóricos

**1. Conceito de função:** Explique com suas palavras o que é uma função e cite duas vantagens de dividir um programa em funções.

**2. Princípio DRY:** Por que repetir o mesmo bloco de código em várias partes do sistema pode causar problemas de manutenção? Como uma função ajuda a evitar essa repetição?

**3. Parâmetros e retorno:** Explique a diferença entre um parâmetro e um valor retornado por uma função. Use a função abaixo como exemplo:
```php
function calcularTotal(float $preco, int $quantidade): float {
    return $preco * $quantidade;
}
```

**4. Tipagem:** Identifique o tipo de cada elemento na declaração `function cadastrar(string $nome, int $idade): bool`.

**5. `void` e `return`:** Qual é a diferença entre uma função que retorna `string` e uma função que retorna `void`? Dê um exemplo de uso para cada uma.

**6. Escopo:** Por que a função abaixo não consegue acessar `$cliente` diretamente? Explique duas formas de corrigir o código e indique qual é a mais recomendada.
```php
$cliente = "Mariana";

function exibirCliente(): string {
    return $cliente;
}
```

**7. Referência:** O que muda quando um parâmetro é declarado como `float &$valor`? Explique a diferença entre alterar uma cópia e alterar a variável original.

**8. Funções nativas:** Escolha cinco funções da tabela deste material e descreva: categoria, finalidade, parâmetros principais e valor retornado.

**9. Previsão de saída:** Qual será o resultado exibido pelo código abaixo? Explique o motivo.
```php
function aplicarDesconto(float $preco): float {
    return $preco * 0.90;
}

$valor = 100.00;
echo aplicarDesconto($valor);
echo $valor;
```
**10. Documentação:** Pesquise na documentação oficial do PHP a função `strlen()` e anote sua sintaxe, o parâmetro recebido e o tipo de retorno.

---
### Respostas

- **Exercício 1:** Uma função é um bloco de código criado para realizar uma determinada tarefa. Ela pode receber *parâmetros*, processar informações e, quando necessário, devolver um resultado por meio do *retorno* (`return`).
---

- **Exercício 2:** Pois, se o mesmo código estiver repetido em vários arquivos, será necessário alterar o código em todos eles quando houver alguma mudança, aumentando a possibilidade de erros e dificultando a manutenção. Uma função ajuda a evitar essa repetição, pois permite criar o código uma vez e reutilizá-lo várias vezes no sistema, facilitando as alterações e reduzindo a chance de erros.
---

- **Exercício 3:** Um *parâmetro* é a informação que a função recebe para poder realizar um cálculo. Um *valor retornado por uma função (`return`)* é o resultado que a função devolve depois de realizar o cálculo.
```php
function calcularTotal(float $preco, int $quantidade): float {
    return $preco * $quantidade; // $preco e $quantidade são parâmetros, enquanto o return é, por exemplo, 10.50 * 3 = 31.50
}
```
---
- **Exercício 4:** `function cadastrar(string $nome, int $idade): bool`

> ***Função:*** `cadastrar`

> ***Parâmetro 1:*** `$nome` (string)

> ***Parâmetro 2:*** `$idade` (int)

> ***Retorno:*** `bool` (true ou false)
---

- **Exercício 5:** Uma função que retorna `string` retorna um texto como resultado. Já uma função que retorna `void` não retorna nenhum valor.

> **Exemplo de `string`:** uma função que retorna o nome de uma pessoa (ex: "Mayne").

> **Exemplo de `void`:** uma função que apenas exibe uma mensagem na tela, sem devolver um resultado.
---

- **Exercício 6:** A função não consegue acessar `$cliente` diretamente porque `$cliente` foi criada fora da função, no **escopo global**.
```php
$cliente = "Mariana";

function exibirCliente(): string {
    return $cliente;
}
```
Duas formas de corrigir:
```php
$cliente = "Mariana";

function exibirCliente(): string {
    global $cliente;
    return $cliente;
}
```
```php
$cliente = "Mariana";

function exibirCliente(string $cliente): string {
    return $cliente;
}

echo exibirCliente($cliente);
```
> A segunda forma, usando **parâmetro**, é a mais recomendada!
---

- **Exercício 7:** Quando um parâmetro é declarado como `float &$valor`, ele é passado **por referência**, ou seja, a função pode alterar diretamente a variável original. Sem o `&`, o parâmetro recebe apenas uma **cópia** do valor, então qualquer alteração feita dentro da função não modifica a variável original. Com o `&`, as alterações feitas no parâmetro também são refletidas na variável original.
---

- **Exercício 8:**
> `strlen()`:
- **Categoria:** Strings.
- **Finalidade:** Retorna a quantidade de caracteres de um texto.
- **Parâmetro principal:** o texto que será contado.
- **Valor retornado:** um número inteiro com a quantidade de caracteres.

> `count()`:
- **Categoria:** Arrays.
- **Finalidade:** Conta a quantidade de itens de um array.
- **Parâmetro principal:** o array que será contado.
- **Valor retornado:** um número inteiro com a quantidade de itens.

> `round()`:
- **Categoria:** Números.
- **Finalidade:** Arredonda um número para a quantidade de casas decimais informada.
- **Parâmetros principais:** o número e, opcionalmente, a quantidade de casas decimais.
- **Valor retornado:** o número arredondado.

> `is_numeric()`:
- **Categoria:** Validação.
- **Finalidade:** Verifica se um valor é um número ou uma string numérica.
- **Parâmetro principal:** o valor que será verificado.
- **Valor retornado:** true se for numérico e false caso contrário.

> `date()`:
- **Categoria:** Data e hora.
- **Finalidade:** Formata uma data ou hora de acordo com uma máscara.
- **Parâmetro principal:** a máscara de formatação.
- **Valor retornado:** uma string contendo a data ou hora formatada.
---

- **Exercício 9:** O resultado será `90100`. Isso acontece porque a função aplica um desconto de 10% sobre R$100,00, retornando R$90,00. Porém, como o parâmetro `$preco` não é passado por referência (`&`), a variável original `$valor` não é alterada e continua valendo R$100,00. Como os dois `echo` estão juntos, os valores aparecem como `90100`.
---

- **Exercício 10:** A função `strlen()` possui a sintaxe `strlen(string $string): int`. Ela recebe como parâmetro uma string e retorna um valor inteiro (`int`) que representa a quantidade de bytes da string.