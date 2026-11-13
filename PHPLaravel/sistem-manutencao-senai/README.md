# Sistema de Manutenção do SENAI - TPM Industrial

- **Objetivo:** Consolidar os conceitos de Model, Controller e Blade.

---

## Cenário do Projeto

Na indústria, paradas não planejadas de máquinas críticas custam milhares de reais por minuto ou hora.

A aplicação deve gerenciar:

1. **Equipamentos Industriais:** Tag de patrimônio, setor fabril, criticidade (Alta, Média ou Baixa) e status operacional.

2. **Ordens de Serviço (O.S.):** Tipo de manutenção (Preventiva, Corretiva ou Preditiva), prioridade, técnico responsável, data limite e status (ABERTA, EM_ANDAMENTO ou CONCLUIDA).

3. **Painel de Indicadores (Dashboard):** Calcular, em tempo real, a quantidade de equipamentos em operação, as ordens de emergência e a taxa de conformidade da manutenção.

---

## Configuração do Ambiente de Trabalho e Desenvolvimento

- Configurar o `.env`:

1. `APP_KEY`
2. Informações da Base de Dados (Banco de Dados)

- Criar o Banco de Dados:

1. `CREATE DATABASE senai_manutencao;`

---

## Criação dos Models

> `php artisan make:model NomeDoModelo -m`

1. *Equipamento* (tag, nome, setor, criticidade, status).

2. *OrdemServico* (codigo, titulo, (int) equipamento_id, tipo, prioridade, status, tecnico, data_abertura, prazo_limite).

---

## Criação dos Controllers via Artisan

> `php artisan make:controller NomeDoController --resource`