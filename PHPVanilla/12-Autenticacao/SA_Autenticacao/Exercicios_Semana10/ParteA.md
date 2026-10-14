## Parte A — Exercícios Teóricos de Fixação

### 1. Protocolo Stateless
> O que significa afirmar que o protocolo HTTP é *"stateless"* e por que o mecanismo de cookies/sessões é necessário para aplicações modernas?

O HTTP é chamado de *stateless* porque não guarda automaticamente as informações das requisições anteriores. Por isso, usamos cookies e sessões para manter informações do usuário, como o login, enquanto ele navega pelo sistema.

### 2. Cookies vs. Sessões
> Qual é a diferença entre os dados armazenados em um cookie e os dados mantidos no array superglobal `$_SESSION`? Qual dos dois apresenta maior segurança para informações confidenciais?

Os cookies ficam armazenados no navegador do usuário, enquanto os dados de `$_SESSION` ficam no servidor. As sessões são mais seguras para guardar informações confidenciais, pois esses dados não ficam diretamente armazenados no navegador.

### 3. A Flag HttpOnly
> Explique detalhadamente como a configuração `httponly => true` impede o sequestro de sessão *(Session Hijacking)* mesmo se a aplicação possuir uma vulnerabilidade de *Cross-Site Scripting (XSS)*.

A configuração `httponly => true` impede que o JavaScript acesse diretamente o cookie da sessão. Isso dificulta que um invasor roube o identificador da sessão por meio de um ataque XSS. Porém, essa configuração não elimina todas as possibilidades de ataque.

### 4. A Flag SameSite
> Qual é a finalidade do atributo `SameSite=Lax` em cookies e contra qual tipo de ataque corporativo ele atua?

O atributo `SameSite=Lax` ajuda a impedir que os cookies sejam enviados em algumas requisições iniciadas por outros sites. Ele ajuda a proteger o sistema contra ataques CSRF, nos quais um invasor tenta fazer o usuário executar ações sem sua intenção.

### 5. Ataque de Fixação de Sessão
> O que é o ataque de *Session Fixation* e por que é mandatório executar `session_regenerate_id(true)` imediatamente após o login do usuário?

O *Session Fixation* acontece quando um invasor tenta fazer o usuário utilizar um identificador de sessão que ele já conhece. Por isso, usamos `session_regenerate_id(true)` depois do login, para gerar um novo identificador e excluir o anterior, dificultando esse tipo de ataque.

### 6. MD5 e Rainbow Tables
> Por que é considerado negligência técnica armazenar senhas com algoritmos rápidos como *MD5* ou *SHA256*? Como as *Rainbow Tables* operam contra esses hashes?

MD5 e SHA-256 não são recomendados para armazenar senhas porque são algoritmos rápidos, permitindo testar muitas combinações em pouco tempo. As *Rainbow Tables* são tabelas pré-calculadas que ajudam a encontrar senhas a partir de seus hashes. Por isso, é melhor usar algoritmos próprios para senhas, como Argon2id ou Bcrypt.

### 7. O Papel do Salt
> O que é o *Salt criptográfico* e por que ele garante que dois usuários com a mesma senha possuam hashes completamente distintos no banco de dados?

O *salt* é um valor aleatório utilizado na geração do hash da senha. Ele faz com que usuários com a mesma senha possam ter hashes diferentes, dificultando a descoberta das senhas por meio de tabelas pré-calculadas. No PHP, o `password_hash()` gera e utiliza esse valor automaticamente.

### 8. Argon2id vs. Bcrypt
> Por que o algoritmo *Argon2id* é considerado superior ao *Bcrypt* na proteção contra ataques de força bruta realizados por placas de vídeo (GPUs) e circuitos ASIC?

O Argon2id é uma boa opção para proteger senhas porque utiliza memória e processamento durante a geração do hash, dificultando ataques de força bruta com GPUs e circuitos ASIC. O Bcrypt também é seguro quando configurado corretamente, mas não possui o mesmo recurso de custo de memória do Argon2id.

### 9. Timing Attacks
> Por que a verificação de senhas deve ser feita com `password_verify()` em vez do operador de comparação comum `===`?

A função `password_verify()` é utilizada para conferir se uma senha corresponde ao hash armazenado no banco de dados. Ela foi criada para essa finalidade e realiza a verificação de forma resistente a ataques de temporização. Já o operador `===` apenas compara valores e não deve ser usado para substituir essa função na verificação de senhas.