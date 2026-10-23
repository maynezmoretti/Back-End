# SENAI SUPLY MVC - Especificação Inicial de Requisitos

## 1. Identificação
- **Projeto:** Senai Suply MVC
- Versão 1.0
- **Estado:** Proposta inicial, sujeita a alterações
- **Responsável:** Equipe de Desenvolvimento - I1D46B

## 2. Objetivos
Desenvolver uma aplicação web didática para consultar o catálogo de insumos industriais e acompanhar a quantidade em estoque, aplicando arquitetura MVC artesanal com PHP, Composer, PDO e PostgreSQL.

## 3. Escopo
Este projeto exibirá um painel de estoque, lista de insumos, permitirá cadastrar novos itens e apresentar uma tela de login com autenticação de usuário.

### 3.1 Partes interessadas e usuários
- **Almoxarife:** Consultar o catálogo e cadastrar insumos
- **Gestor:** Acompanhar as quantidades agregadas no painel
- **Equipe de Desenvolvimento:** Implementar e validar os requisitos do sistema

### 3.2 Ambientes e Dependências
- PHP 8.3 ou superior, Composer, Extensão PDO para PostgreSQL
- Banco de Dados PostgreSQL com o script `schema.sql`
- Servidor web configurado
- Navegador com suporte a HTML 5

## 4. Requisitos do Sistema