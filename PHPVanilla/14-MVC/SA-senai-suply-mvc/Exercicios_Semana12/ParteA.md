# LISTA DE EXERCÍCIOS DE FIXAÇÃO E PRÁTICA — MVC

### Parte A — Questões Teóricas de Fixação

### 1. O Colapso do Código Espaguete
*Explique por que manter consultas SQL, regras de validação e marcação HTML no mesmo arquivo inviabiliza a manutenção e a escalabilidade de um sistema corporativo.*

Manter consultas SQL, validações e HTML no mesmo arquivo deixa o código desorganizado e dificulta a manutenção. Quando precisamos fazer alguma alteração, fica mais difícil encontrar os problemas e entender o funcionamento do sistema. O MVC resolve isso separando cada responsabilidade, deixando o projeto mais organizado e fácil de atualizar.

### 2. A Tríade MVC
*Qual é a função específica de cada um dos três componentes do padrão MVC (Model, View, Controller)? Qual deles deve conter as regras de negócio?*

O MVC é dividido em três partes: Model, View e Controller. O Model trabalha com os dados e as regras de negócio, a View é responsável pela parte visual do sistema e o Controller recebe as requisições e faz a comunicação entre o Model e a View. Cada parte possui uma função específica, evitando que todo o código fique misturado.

### 3. O Papel do Composer
*Diferencie o papel do arquivo `composer.json` do arquivo `composer.lock`. Por que a pasta `vendor/` nunca deve ser versionada no Git?*

O `composer.json` guarda as informações do projeto e as dependências que precisam ser instaladas. Já o `composer.lock` registra as versões exatas dessas dependências, garantindo que o projeto utilize as mesmas versões em diferentes computadores. A pasta `vendor/` não deve ser enviada para o Git porque contém as bibliotecas instaladas pelo Composer e pode ser criada novamente usando o comando `composer install`.

### 4. A Especificação PSR-4
*Como o Autoloader PSR-4 consegue localizar o arquivo `src/Controllers/ProdutoController.php` a partir do namespace `App\Controllers\ProdutoController`?*

O PSR-4 permite que o PHP encontre e carregue as classes automaticamente por meio dos namespaces. Por exemplo, ao utilizar `App\Controllers\ProdutoController`, o Autoloader identifica o caminho da classe e procura o arquivo correspondente na pasta configurada no Composer. Isso evita precisar fazer vários `require` ou `include` manualmente.

### 5. Front Controller
*Qual é a principal vantagem de segurança ao centralizar todas as requisições em `public/index.php` e isolar os arquivos-fonte do projeto fora da raiz pública da web?*

O Front Controller centraliza as requisições do sistema em um único arquivo, geralmente o `public/index.php`. Isso aumenta a segurança porque evita que os usuários acessem diretamente arquivos internos, como Controllers, Models e configurações. Assim, somente os arquivos que precisam ser públicos ficam disponíveis na web.

### 6. Roteador HTTP
*Como o objeto Roteador diferencia uma requisição `GET /produtos` de uma requisição `POST /produtos?`*

O Roteador identifica o método HTTP e a URL de cada requisição para saber qual ação deve executar. Por exemplo, `GET /produtos` pode ser utilizado para listar os produtos, enquanto `POST /produtos` pode ser utilizado para cadastrar um novo produto. Mesmo utilizando o mesmo endereço, cada método executa uma função diferente.

### 7. Injeção de Dados na View
*Como a função nativa `extract()` atua no método `renderizar()` do Controller para disponibilizar variáveis para as Views?*

A função `extract()` transforma as informações de um array em variáveis que podem ser utilizadas na View. No método `renderizar()` do Controller, ela facilita o envio dos dados para as páginas, permitindo que as informações sejam exibidas no HTML de forma mais simples.

### 8. Segurança contra XSS nas Views
*Por que todas as saídas dinâmicas exibidas em tabelas e formulários devem ser envolvidas com `htmlspecialchars()`?*

A função `htmlspecialchars()` converte caracteres especiais em entidades HTML, evitando que códigos inseridos por usuários sejam interpretados pelo navegador. Isso ajuda a proteger o sistema contra ataques XSS, impedindo que conteúdos maliciosos sejam executados quando aparecem em páginas, tabelas ou formulários.

### 9. Single Responsibility no Controller
*Por que um Controller nunca deve conter comandos SQL com strings concatenadas ou conexões diretas via `new PDO()`?*

O Controller não deve ter consultas SQL nem criar conexões diretamente com o banco de dados, pois sua função é receber as requisições e controlar o funcionamento do sistema. As operações com o banco devem ficar em classes responsáveis por essa tarefa, como Models ou DAOs. Essa separação deixa o código mais organizado e facilita futuras alterações.

### 10. Transição para o Framework Laravel
*Identifique quais conceitos aprendidos neste MVC artesanal são exatamente os mesmos utilizados pelo Laravel 11.*

O Laravel utiliza vários conceitos que aprendemos no MVC artesanal, como a separação entre Model, View e Controller, o sistema de rotas, o Composer e o Autoloader PSR-4. Também utiliza Controllers para organizar as requisições e Models para trabalhar com os dados. Dessa forma, aprender a montar um MVC manualmente ajuda a entender melhor como os frameworks funcionam na prática.