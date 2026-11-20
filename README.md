# Logistech - Gerenciador Logístico

## Sobre o projeto
O **Logistech** é uma aplicação web desenvolvida para a Atividade Prática Orientada (APO) da disciplina **Fundamentos de Programação para Internet** (UNIPAR EAD).

O sistema permite gerenciar produtos, endereços (origem e destino), transportadores e fretes com relacionamento **1 para muitos** (um transportador levando vários produtos em um mesmo frete), além de gerar relatórios diários para download.

## Tecnologias utilizadas
- **Backend:** PHP 8+ (PDO)
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5 e JavaScript
- **Ambiente Local:** XAMPP (Apache + MySQL)
- **Versionamento:** Git e GitHub

## Funcionalidades
- Dashboard com indicadores em tempo real (produtos, transportadores, fretes e pendências)
- Cadastro, listagem, edição e exclusão de **Produtos**
- Cadastro, listagem, edição e exclusão de **Endereços**
- Cadastro, listagem, edição e exclusão de **Transportadores**
- Geração de **Fretes** com adição dinâmica de múltiplos produtos via JavaScript
- Consulta de **Relatório de Fretes por Data** com exportação em `.CSV`

## Como executar localmente
1. Instale o **XAMPP** e inicie os módulos **Apache** e **MySQL**.
2. Copie a pasta `logistech` para `C:\xampp\htdocs\`.
3. Acesse `http://localhost/phpmyadmin`, crie o banco `logistech` e execute o script SQL das tabelas.
4. Confira os dados de acesso em `config/database.php`.
5. Acesse no navegador: `http://localhost/logistech`.

## Autor
Valdeir Maceió