## Parte A – Questões Teóricas de Fixação

### 1. Evolução Arquitetural
*Quais foram os principais aprendizados técnicos obtidos na construção do MVC artesanal da Semana 12 que permitiram que você compreendesse o Laravel 11 com facilidade?*

Na construção do MVC artesanal, aprendi a separar o código em Model, View e Controller, organizar arquivos e trabalhar com rotas. Isso facilitou entender como o Laravel funciona, pois ele utiliza esses mesmos conceitos de forma mais organizada.

### 2. A Nova Arquitetura do Laravel 11
*O que mudou na estrutura de inicialização do Laravel 11 em relação às versões anteriores (Laravel 9 e 10)? Onde fica o novo ponto central de configuração?*

O Laravel 11 simplificou a estrutura do projeto, reduzindo a quantidade de arquivos de configuração. O novo ponto central de configuração fica no arquivo `bootstrap/app.php`.

### 3. Padrão 12-Factor App
*Por que é uma violação grave de segurança gravar senhas de banco de dados diretamente dentro do arquivo `config/database.php` em vez de utilizar o arquivo `.env`?*

Gravar senhas diretamente no arquivo de configuração é perigoso porque essas informações podem acabar expostas no código. O arquivo `.env` permite guardar esses dados separados do projeto.

### 4. O Papel da APP_KEY
*Qual é o risco técnico de alterar a `APP_KEY` de uma aplicação que já está em produção há meses com usuários reais cadastrados?*

Alterar a APP_KEY pode fazer com que dados criptografados anteriormente não possam mais ser acessados, como sessões e informações protegidas dos usuários.

### 5. Isolamento de Diretórios
*Por que um servidor web de produção (Nginx/Apache) deve apontar rigorosamente para a pasta `public/` e nunca para a raiz do projeto Laravel?*

O servidor deve apontar para a pasta `public/` porque ela contém os arquivos que podem ser acessados pelos visitantes. Isso protege arquivos internos do projeto, como configurações, senhas e códigos.

### 6. Artisan CLI
*Qual é a diferença prática entre executar um script PHP procedural com `php arquivo.php` e executar comandos através do `php artisan`?*

O comando `php arquivo.php` executa diretamente um arquivo PHP. Já o `php artisan` permite executar comandos próprios do Laravel, como criar controllers, migrar tabelas e iniciar o servidor.

### 7. O Arquivo .env.example
*Por que manter o arquivo `.env.example` sempre atualizado é indispensável para o sucesso de equipes de desenvolvimento que utilizam Git?*

Ele serve como modelo para configurar o ambiente de outros desenvolvedores. Mantê-lo atualizado facilita a instalação do projeto e evita que informações importantes de configuração fiquem faltando.

### 8. Motor de Templates Blade
*Qual é a diferença entre a diretiva Blade `{{ $variavel }}` e a diretiva `{!! $variavel !!}` em termos de proteção contra ataques Cross-Site Scripting (XSS)?*

A diretiva `{{ $variavel }}` protege contra ataques XSS, pois transforma caracteres especiais em texto. Já `{!! $variavel !!}` exibe o conteúdo sem essa proteção, podendo permitir a execução de códigos maliciosos.

### 9. Responsabilidade do Controller
*Em uma aplicação profissional com Laravel, por que um método de Controller deve ser curto (≤ 20 linhas) e não deve conter consultas SQL cruas ou regras de negócio extensas?*

O Controller deve ter métodos curtos e organizados para facilitar a leitura e a manutenção. As regras de negócio e consultas devem ficar em locais apropriados, evitando que ele fique sobrecarregado.

### 10. A Ferramenta Tinker
*Para que serve o comando `php artisan tinker` e em quais situações ele economiza tempo do desenvolvedor durante testes de laboratório?*

O comando `php artisan tinker` permite testar códigos PHP e interagir com a aplicação Laravel diretamente pelo terminal. Ele economiza tempo porque permite testar consultas e criar ou consultar registros sem precisar montar telas ou rotas.