## Parte A – Questões Teóricas de Fixação

### 1. Semântica RESTful
*Por que uma ação de exclusão de dados nunca deve ser implementada através de uma requisição HTTP do tipo GET? Explique o risco associado a robôs de busca.*

O método GET deve ser usado apenas para consultar dados. Se fosse usado para excluir informações, robôs de busca poderiam acessar o link automaticamente e acabar apagando dados sem querer.

### 2. Idempotência
*O que significa o conceito de idempotência no protocolo HTTP e por que o método PUT é considerado idempotente enquanto o POST não é?*

Idempotência significa que uma requisição pode ser executada várias vezes sem alterar o resultado final depois da primeira execução.

O PUT é idempotente porque atualizar o mesmo dado várias vezes mantém o mesmo resultado. Já o POST pode criar vários registros iguais a cada envio.

### 3. Resource Controllers
*Quais são as 7 ações canônicas geradas pelo comando `php artisan make:controller --resource` e qual é a responsabilidade de cada uma?*

As 7 ações canônicas são:

- **index:** lista todos os registros.
- **create:** exibe o formulário de cadastro.
- **store:** salva um novo registro.
- **show:** exibe os detalhes de um registro.
- **edit:** exibe o formulário de edição.
- **update:** atualiza um registro existente.
- **destroy:** exclui um registro.

### 4. Injeção de Dependências
*Como o Service Container do Laravel entrega automaticamente uma instância de Request ao método do controller sem que tenhamos que instanciá-la com `new Request()`?*

O Laravel utiliza o Service Container para identificar o que o método precisa e entregar automaticamente uma instância de Request. Assim, não precisamos criar o objeto manualmente usando `new Request()`.

### 5. Method Spoofing
*Por que os navegadores web não conseguem enviar requisições nativas de PUT e DELETE através de formulários HTML convencionais? Como o Laravel contorna essa limitação?*

Os formulários HTML convencionais aceitam apenas os métodos GET e POST. Para contornar isso, o Laravel utiliza o `@method`, que permite simular métodos como PUT e DELETE dentro do formulário.

> Exemplo:

```php
@method('DELETE')
```

### 6. Ataques CSRF
*O que é um ataque do tipo Cross-Site Request Forgery e como a diretiva Blade `@csrf` impede que sites maliciosos forjem requisições em nome do usuário?*

É um ataque em que um site malicioso tenta fazer o usuário executar uma ação em outro site sem sua autorização.

O `@csrf` gera um token de segurança que o Laravel verifica para confirmar se a requisição veio de um formulário válido.

### 7. Constraints de Rota
*Para que servem métodos de restrição como `whereNumber('id')` ou `whereAlphaNumeric('codigo')` e qual código de status HTTP o Laravel retorna quando o formato é violado?*

Servem para limitar os valores que podem ser recebidos em uma rota, como aceitar apenas números no ID ou letras e números em um código.

Quando o formato não corresponde à restrição, o Laravel retorna o erro HTTP **404 (Not Found)**.

### 8. Rotas Nomeadas
*Cite duas vantagens corporativas de utilizar a função auxiliar `route('clientes.show', $id)` nas views em vez de escrever strings estáticas como `"/clientes/{$id}"`.*

Duas vantagens são:

- Facilitam a manutenção, pois podemos alterar a URL sem precisar modificar todos os arquivos.
- Evitam erros de digitação e deixam o código mais organizado.

### 9. Single Responsibility no Controller
*Por que a validação de formulários com `$request->validate()` ou Form Requests deve ser mantida enxuta dentro do controller para respeitar o limite de 20 linhas por função?*

A validação deve ser simples e objetiva para que o controller não fique sobrecarregado. Isso facilita a leitura, a manutenção e a reutilização do código, deixando cada função responsável por uma tarefa.

### 10. A Ferramenta `route:list`
*Como o comando `php artisan route:list` auxilia equipes multidisciplinares a documentar e auditar os endpoints disponíveis em uma API ou aplicação web?*

O comando `php artisan route:list` mostra todas as rotas cadastradas na aplicação, incluindo métodos HTTP, endereços e controllers responsáveis.

Isso ajuda a equipe a consultar, organizar e verificar os endpoints disponíveis, facilitando a documentação e a identificação de possíveis problemas.