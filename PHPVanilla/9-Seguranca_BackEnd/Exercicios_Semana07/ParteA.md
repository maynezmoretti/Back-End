## LISTA DE EXERCÍCIOS: SEGURANÇA E HIGIENIZAÇÃO DE DADOS

- **Parte A: Exercícios Teóricos de Fixação**
---
> 1. **Conceituação OWASP:** O que significa a sigla XSS e por que ela é classificada como uma vulnerabilidade no lado do cliente (Client-Side) que deve ser prevenida pelo Back-End?

A sigla XSS significa Cross-Site Scripting. Porque ela é uma vulnerabilidade em que um atacante consegue inserir scripts maliciosos em uma página web, fazendo com que esses scripts sejam executados no navegador do usuário que visita o site. Ela é considerada uma vulnerabilidade Client-Side pois o script é executado no navegador, mas que deve ser prevenida pelo BackEnd, principalmente com a validação dos dados e escapamento de saída, como o `htmlspecialchars()`.

> 2. **Reflected vs Stored:** Qual é a diferença entre um ataque XSS Refletido e um XSS Gravado (Stored)? Qual dos dois apresenta maior potencial de estrago para uma empresa e por quê?

O ataque XSS Refletido é um tipo de ataque onde o código malicioso é enviado em uma requisição, como por exemplo, por um link ou formulário, e é refletido imediatamente na página, sem ser armazenado no servidor.

> 3. **Mecanismo de Escapamento:** Explique detalhadamente a transformação que a função `htmlspecialchars()` realiza nos caracteres `<` e `>`. Por que o navegador não executa o código após essa transformação?

A função `htmlspecialchars()` serve para converter caracteres especiais em entidades HTML. Ela converte esses caracteres (`<` e `>`) em `&lt;` e `&gt;`. Após essa transformação, o navegador interpreta o conteúdo como texto, e não como uma tag HTML.

> 4. **Flags de Proteção:** Qual é a função da flag `ENT_QUOTES` na chamada de `htmlspecialchars()`? O que pode acontecer se essa flag for omitida em um campo `<input value="...">`?

A flag `ENT_QUOTES` faz com que a função `htmlspecialchars()` converta aspas simples e duplas em entidades HTML. Se essa flag for omitida em um campo `<input value="...">`, as aspas duplas podem não ser escapadas, fazendo com que o conteúdo possa ser interpretado como código HTML.

> 5. **Anti-Alucinação PHP:** Por que não devemos utilizar o filtro `FILTER_SANITIZE_STRING` em projetos modernos desenvolvidos em PHP 8.3?

O `FILTER_SANITIZE_STRING` não deve ser usado em projetos modernos porque foi removido no PHP 8.3. Por isso, em versões atuais do PHP, ele não está mais disponível e pode causar erros.

> 6. **Validação de E-mail:** Qual é a diferença prática entre verificar um e-mail com `empty($email)` e verificar com `filter_var($email, FILTER_VALIDATE_EMAIL)`?

O `empty($email)` apenas verifica se o campo está vazio ou não. Já o `filter_var($email, FILTER_VALIDATE_EMAIL)` verifica se o conteúdo possui um formato válido de e-mail, como por exemplo, `exemplo@email.com`.

> 7. **Roubo de Sessão:** Como um atacante pode usar uma brecha XSS para capturar o cookie de sessão de um usuário logado?

Ele pode utilizar essa brecha para executar JavaScript no navegador da vítima e tentar acessar informações do cookie de sessão, caso ele não esteja protegido. Com esse cookie, poderia tentar se passar pelo usuário.

> 8. **Segurança em Camadas:** Por que sanitizar na entrada (*ex:* com `strip_tags`) não elimina a necessidade de codificar na saída com `htmlspecialchars()`?

Porque sanitizar na entrada não garante que todos os dados estejam seguros para serem exibidos. O `strip_tags()` remove algumas tags HTML, mas não substitui o escapamento. Já o `htmlspecialchars()` protege o conteúdo no momento da saída, impedindo que ele seja interpretado como código HTML.