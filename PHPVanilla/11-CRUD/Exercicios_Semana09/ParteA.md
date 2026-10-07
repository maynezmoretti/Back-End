## Parte A: Exercícios Teóricos de Fixação

### 1. Definição de CRUD
> O que significa o acrônimo **CRUD** e qual é a correspondência direta de cada uma de suas letras com as instruções SQL no PostgreSQL?

CRUD significa **Create, Read, Update e Delete**. São as quatro operações básicas que podemos fazer em um banco de dados. O **Create** é usado para adicionar dados e corresponde ao `INSERT`, o **Read** serve para consultar dados e corresponde ao `SELECT`, o **Update** altera dados e corresponde ao `UPDATE`, e o **Delete** exclui dados e corresponde ao `DELETE`.

### 2. Anatomia do SQL Injection
> Explique com suas próprias palavras como um atacante consegue alterar a lógica de uma consulta quando o código utiliza concatenação de strings com `$_GET` ou `$_POST`.

O SQL Injection acontece quando o sistema pega um valor enviado pelo usuário, como por `$_GET` ou `$_POST`, e coloca diretamente dentro de uma consulta SQL usando concatenação. O problema é que o usuário pode digitar algo que altere a estrutura da consulta. Dessa forma, o banco pode interpretar o que foi digitado como parte do comando SQL, e não apenas como um dado.

### 3. Mecanismo das Prepared Statements
> Por que o envio de uma consulta em duas etapas (`prepare` e depois `execute`) impede que um texto digitado pelo usuário seja executado como instrução SQL pelo banco?

As Prepared Statements separam a consulta SQL dos dados enviados pelo usuário. Primeiro usamos o `prepare()` para preparar a consulta com marcadores, como `:sku`, e depois usamos o `execute()` para passar os valores. Assim, o que o usuário digitou é tratado como um valor e não como um comando SQL, evitando que ele consiga alterar a estrutura da consulta.

### 4. Marcadores Nomeados
> Qual é a vantagem de utilizar marcadores nomeados como `:sku` e `:preco` em vez de pontos de interrogação posicionais (`?`) em instruções SQL complexas?

Os marcadores nomeados, como `:sku` e `:preco`, deixam o código mais fácil de entender, principalmente quando a consulta tem vários parâmetros. Pelo nome do marcador já conseguimos saber qual valor será usado em cada lugar. Usando vários `?`, pode ser mais fácil se confundir com a ordem dos valores.

### 5. Diferença entre Bindings
> Explique a diferença de comportamento entre os métodos `$stmt->bindValue()` e `$stmt->bindParam()`.

O `bindValue()` pega o valor da variável naquele momento e vincula esse valor ao parâmetro. Já o `bindParam()` trabalha com a própria variável, usando uma referência. Isso significa que, se o valor da variável mudar antes do `execute()`, o novo valor poderá ser usado na execução da consulta.

### 6. Tipagem no PDO
> Qual é o risco de omitir o tipo de dado (***ex:*** `PDO::PARAM_INT`) ao vincular uma variável que deveria ser estritamente numérica em uma cláusula `LIMIT`?

Quando um valor deveria ser um número inteiro, como em uma cláusula `LIMIT`, é importante informar o tipo para o PDO. Podemos usar `PDO::PARAM_INT` para deixar claro que aquele valor deve ser tratado como inteiro. Isso ajuda a evitar problemas de tipagem e deixa o código mais seguro e previsível.

```php
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
```

### 7. Padrão DAO
> Qual é o benefício do padrão **Data Access Object (DAO)** em termos de manutenibilidade de software e do princípio de responsabilidade única *(SOLID)*?

O DAO serve para separar a parte do código que acessa o banco de dados do restante da aplicação. Por exemplo, o `AlmoxarifadoDAO` pode ficar responsável pelas consultas e alterações relacionadas ao almoxarifado. Isso deixa o projeto mais organizado e facilita a manutenção, além de seguir o princípio da Responsabilidade Única (SRP), já que cada classe fica responsável por uma função específica.

### 8. Operações de UPDATE
> Por que a ausência de uma cláusula `WHERE` em um comando `UPDATE` é considerada um incidente gravíssimo em ambientes de produção?

Um `UPDATE` sem uma cláusula `WHERE` é muito perigoso porque a alteração será feita em todos os registros da tabela. Por exemplo, se executarmos o comando abaixo, o preço de todos os produtos será alterado para 100. Em um ambiente de produção, isso pode causar uma alteração enorme nos dados e ser difícil de corrigir caso não exista um backup.

```sql
UPDATE produtos
SET preco = 100;
```

### 9. Impacto da LGPD
> De acordo com a *Lei Geral de Proteção de Dados (LGPD)*, quais são as penalidades e impactos que uma organização pode sofrer caso ocorra vazamento de dados de clientes por falha de SQL Injection?

Se acontecer um vazamento de dados pessoais por causa de uma falha de segurança, como um SQL Injection, a empresa pode sofrer consequências previstas pela LGPD. Dependendo do caso, podem acontecer advertências, multas de até 2% do faturamento da empresa no Brasil, limitadas a R$ 50 milhões por infração, além de multa diária, publicização da infração e bloqueio ou eliminação dos dados envolvidos. Além dessas penalidades, a empresa também pode ter prejuízos financeiros e perder a confiança dos clientes.