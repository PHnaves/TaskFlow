# TaskFlow

Sistema de gerenciamento de tarefas desenvolvido para a disciplina de Engenharia de Software (CDC2.NA). Permite cadastrar, visualizar, editar, excluir e concluir tarefas, com organização do desenvolvimento em Kanban, modelagem UML, versionamento semântico, testes automatizados e integração contínua.

Documento de planejamento completo (introdução, objetivos, escopo, diagramas, metodologia, CI, versionamento e evidências): [`docs/entregaveis/TaskFlow-Documentacao.docx`](docs/entregaveis/TaskFlow-Documentacao.docx).

## Stack

| Tecnologia | Uso |
|---|---|
| PHP / Laravel 12 | Back-end, padrão MVC |
| Blade | Views |
| Tailwind CSS | Estilização |
| PostgreSQL | Banco de dados |
| PHPUnit | Testes automatizados |
| GitHub Actions | CI |

## Diagramas

- [Diagrama de Casos de Uso](docs/uml/casos-de-uso.png) ([fonte Mermaid](docs/uml/casos-de-uso.mmd))
- [Diagrama de Classes](docs/uml/diagrama-de-classes.png) ([fonte Mermaid](docs/uml/diagrama-de-classes.mmd))

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
# configure as credenciais do PostgreSQL no .env
php artisan migrate
npm install
npm run dev     # em outro terminal
php artisan serve
```

Testes:

```bash
php artisan test
```

Também há suporte a Docker (`docker-compose.yml` / `Dockerfile`) para subir a aplicação e o PostgreSQL sem instalar as dependências localmente.

## Fluxo de trabalho

- **Kanban**: GitHub Projects, colunas `To Do` → `In Progress` → `Done`.
- **Commits**: convenção semântica — veja a tabela abaixo.
- **CI**: todo push/PR roda o pipeline em `.github/workflows/ci.yml` (dependências, banco de testes, migrations, PHPUnit, Pint).

| Tipo | Finalidade |
|---|---|
| `feat` | Implementação de funcionalidades |
| `fix` | Correção de problemas |
| `test` | Criação ou alteração de testes |
| `docs` | Alterações na documentação |
| `ci` | Configuração de integração contínua |
| `chore` | Configurações e tarefas auxiliares |