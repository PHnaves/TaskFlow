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

### Local (PHP 8.2+)

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

```bash
php artisan test
```

### Docker (recomendado)

```bash
docker compose up -d
docker exec taskflow-app composer install
docker exec taskflow-app php artisan migrate
```

A aplicação fica em `http://localhost:8000` e o Vite (hot reload) em `http://localhost:5173`.

**Banco de testes:** os testes rodam contra PostgreSQL, igual à aplicação — nunca contra SQLite. Para isolar os testes do banco de desenvolvimento, o container `db` cria automaticamente (via `docker/initdb/`) um segundo banco, `taskflow_testing`, na mesma instância do Postgres; o `RefreshDatabase` migra/limpa apenas esse banco, nunca o `taskflow` de dev.

Como o `docker-compose.yml` define `APP_ENV`/`DB_CONNECTION`/`DB_DATABASE` como variáveis de ambiente reais do container (prioridade sobre o `<env>` do `phpunit.xml`, que o PHPUnit não sobrescreve por padrão), rode os testes via `docker exec` apontando explicitamente para o banco de testes:

```bash
docker exec \
  -e APP_ENV=testing -e DB_CONNECTION=pgsql -e DB_DATABASE=taskflow_testing \
  -e SESSION_DRIVER=array -e CACHE_STORE=array -e QUEUE_CONNECTION=sync -e MAIL_MAILER=array \
  taskflow-app php artisan test
```

Se o volume do `db` já existia antes dessa mudança (container criado anteriormente), crie o banco manualmente uma vez:

```bash
docker exec taskflow-db psql -U taskflow -d taskflow -c "CREATE DATABASE taskflow_testing OWNER taskflow;"
```

A CI no GitHub Actions (`.github/workflows/ci.yml`) sobe um serviço Postgres dedicado e roda os testes da mesma forma — sem SQLite em nenhum ambiente.

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