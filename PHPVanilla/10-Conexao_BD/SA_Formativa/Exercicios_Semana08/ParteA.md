## LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA - CONEXÃO BANCO DE DADOS PDO

### Parte A: Exercícios Teóricos de Fixação

> 1. **Abstração de Dados:** O que é o ***PDO*** no PHP e por que ele é preferível em relação a extensões especializadas procedurais como o antigo pgsql em projetos corporativos?

***PDO*** *(PHP Data Objects)* é uma forma do PHP se conectar e trabalhar com bancos de dados. Ele é preferível pois permite trabalhar com diferentes bancos usando uma estrutura parecida.

> 2. **Ciclo do DSN:** Explique o que é a string **DSN** e detalhe a finalidade de cada um dos parâmetros configurados para o *PostgreSQL (host, port, dbname)*.

***DSN*** é uma string usada para informar ao *PDO* os dados necessários para encontrar e acessar o banco de dados. O `host` indica onde o banco está, o `port` indica a porta usada pelo PostgreSQL e o `dbname` indica o nome do banco que será acessado.

- **Exemplo:** `host=localhost;port=5432;dbname=meu_banco`.

> 3. **Padrão de Portas:** Qual é a porta padrão de escuta do *SGBD PostgreSQL (5432)* e como ela é referenciada dentro da string de conexão?

A porta padrão usada pelo PostgreSQL é a `5432`. Dentro da string de conexão, ela é referenciada usando o parâmetro `port`, como em `port=5432`.

> 4. **Flags de Integridade:** O que acontece quando definimos o atributo `PDO::ATTR_ERRMODE` com o valor `PDO::ERRMODE_EXCEPTION`? Qual seria o comportamento padrão caso essa flag não fosse definida?

Quando definimos `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`, o PDO passa a lançar uma `PDOException` quando acontece algum erro na conexão ou em uma operação com o banco. Se essa flag não for definida, o comportamento padrão é o `PDO::ERRMODE_SILENT`, em que o erro não é lançado automaticamente como uma exceção.

> 5. **Fetch Mode:** Qual é a vantagem de utilizar `PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC` para o consumo de memória RAM do servidor?

O `PDO::FETCH_ASSOC` faz com que os resultados da consulta sejam retornados como arrays associativos, usando o nome das colunas como índices. Isso evita que os mesmos dados sejam armazenados também com índices numéricos, ajudando a diminuir o uso de memória RAM, principalmente quando existem muitos registros.

> 6. **Padrão Singleton:** Por que abrir uma nova conexão com `new PDO()` a cada consulta executada no PostgreSQL pode esgotar o limite de `max_connections` do servidor?

Toda vez que usamos `new PDO()`, uma nova conexão com o banco é criada. Se o sistema fizer isso várias vezes, podem existir muitas conexões abertas ao mesmo tempo. Como o PostgreSQL possui um limite definido por `max_connections`, esse limite pode ser atingido e novas conexões podem ser recusadas.

> 7. **Encapsulamento do Singleton:** Por que o construtor da classe `ConexaoBanco` precisa ser declarado como `private` e quais métodos mágicos devem ser bloqueados para garantir a unicidade da instância?

O construtor da classe `ConexaoBanco` precisa ser declarado como `private` para impedir que outras partes do código criem novas instâncias usando `new`. Dessa forma, a própria classe controla a criação da conexão. Também podemos bloquear o `__clone()` para impedir cópias da instância e o `__wakeup()` para evitar que ela seja recriada através de ***desserialização***.

> 8. **Segurança de Credenciais:** Por que nunca devemos deixar o usuário e senha do banco de dados salvos de forma estática *(hardcoded)* dentro dos scripts PHP do projeto?

Não devemos deixar o usuário e a senha do banco escritos diretamente no código porque essas informações podem acabar sendo expostas, principalmente quando o projeto é enviado para um repositório como o GitHub.

> 9. **Tratamento de Exceções & LGPD:** Por que a exibição direta de `$e->getMessage()` de uma `PDOException` na tela do navegador é considerada uma falha grave de segurança *(Information Disclosure)*?

Mostrar diretamente `$e->getMessage()` no navegador pode revelar informações internas do sistema, como dados do banco, endereço do servidor ou detalhes de uma consulta SQL.