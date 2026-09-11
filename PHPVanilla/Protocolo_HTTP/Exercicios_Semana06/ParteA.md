## LISTA DE EXERCÍCIOS: PROCESSAMENTO HTTP E FORMULÁRIOS 

- **Parte A: Exercícios Teóricos de Fixação**
---
> 1. **Diferença Estrutural:** Explique a diferença física entre onde os dados são anexados em uma requisição GET e em uma requisição POST.

Na requisição `GET` os dados são anexados à URL, como parâmetros.
Já na requisição `POST` os dados são anexados dentro do body (o corpo da requisição), *normalmente* em um `json`.

**Exemplo:** *pagina.php?nome=Joao&idade=20*

> 2. **Segurança e Privacidade:** Por que senhas de usuário nunca devem ser enviadas via método GET? Cite pelo menos dois locais onde essa senha ficaria gravada de forma insegura.

Porque essas senhas ficam visíveis na URL. Elas podem ficar gravadas de forma insegura no histórico do navegador e em logs do servidor, por exemplo.

> 3. **Coalescência Nula:** Por que a instrução `$nome = $_POST['nome'];` dispara um Warning na primeira vez que a página é carregada no navegador? Como o operador `??` resolve isso?

Porque na primeira vez que a página é carregada, ainda não existe esse valor, pois o formulário ainda não foi enviado. O operador `??` verifica se o valor existe e não é nulo. Caso ele não exista ou seja nulo, é atribuído um outro valor para evitar o Warning no script.

> 4. **Idempotência:** O que significa dizer que uma requisição GET é idempotente? Por que atualizar ou deletar dados no banco usando links GET é uma má prática de segurança?

Significa que essa requisição pode ser realizada várias vezes sem alterar o resultado dos dados no servidor. Esta é uma má prática, pois um simples acesso ao link, por exemplo, pode alterar ou apagar dados sem intenção.

> 5. **Validação Client vs Server:** Um desenvolvedor júnior afirma que o formulário dele é 100% seguro porque colocou `required` e `type="email"` em todas as tags HTML. Explique por que essa afirmação é falsa.

Ela é falsa, pois somente isso não basta. Essas validações são feitas no navegador e podem ser ignoradas. É preciso sempre fazer as validações dos dados também no código do servidor.

> 6. **XSS e Sanitização:** Qual é o risco de exibir dados vindos de um `$_POST` diretamente na tela sem utilizar `htmlspecialchars()`?

Sem essa função, os caracteres especiais não são convertidos em entidades correspondentes em HTML, o que pode causar uma interpretação indevida pelo navegador (o navegador pode interpretar o conteúdo como código). Isso pode causar uma vulnerabilidade de segurança. Dessa forma, ela é utilizada para prevenir ataques XSS.

> 7. **Sticky Forms:** O que é a técnica de *Sticky Forms* e qual é o seu impacto na experiência do usuário (UX)?

A técnica *Sticky Forms* imprime de volta no atributo `value` do input os dados que o usuário acaba de digitar caso ocorra um erro de validação de dados. Seu impacto na UX é *positivo*, pois evita que o usuário precise preencher o formulário novamente, tornando o processo mais rápido e prático.

> 8. **DevTools:** Como você utilizaria a aba Network do navegador para comprovar que um formulário foi enviado via POST e não via GET?

Eu utilizaria a aba Network do navegador para visualizar a requisição feita pelo formulário. Ao enviar o formulário, eu procuraria pela requisição e verificaria o campo *request method*. Se estiver escrito `POST`, significa que os dados foram enviados pelo método `POST` e não pelo método `GET`.