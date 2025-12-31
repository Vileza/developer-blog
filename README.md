# Developer Blog - Projeto de Estudo

## 📚 Sobre o Projeto

Este projeto foi criado com o objetivo de **aprendizado em engenharia de software e arquitetura de software**. As técnicas aplicadas são intencionalmente over-engineered, servindo exclusivamente para fins de estudo e experimentação.

> ⚠️ **Aviso**: Este projeto não reflete uma arquitetura recomendada para produção levando em consideração que é um projeto pequeno. O foco é explorar e aprender conceitos avançados de desenvolvimento de software.

---

## 🎯 Objetivos de Aprendizado

- **Microsserviços**: Arquitetura distribuída com serviços independentes e comunicação via API
- **Testes automatizados**: Estruturação dos testes automatizados para garantia de estabilidade da aplicação
- **Docker**: Containerização e orquestração de aplicações
- **ORM**: Modelagem e manipulação de banco de dados relacional
- **Apache**: Servidor web e configuração de hospedagem
- **Proxy Reverso**: Roteamento e balanceamento de requisições entre microsserviços
- **SOLID**: Princípios de design orientado a objetos
- **DRY** (Don't Repeat Yourself): Eliminação de código duplicado
- **Boas Práticas de Desenvolvimento**: Clean code, padrões de projeto e convenções

---

## 🏗️ Arquitetura do Sistema

O projeto segue uma arquitetura de **microsserviços**, onde cada serviço é responsável por um domínio específico da aplicação. Todos os serviços são independentes, possuem seu próprio banco de dados e se comunicam através de APIs REST.
A arquitetura implementa o conceito de API Gateway que permite centralizar o conteúdo da requisição e resposta em um único ponto, evitando a complexidade de múltiplas conexões a vários serviços no carregamento de uma página. Essa arquitetura permite otimizar 
a resposta já que não é necessario obter partes de uma entidade para construir a respostas.

### Visão Geral

```
┌─────────────────────────────────────────────────────────────────┐
│                        PROXY REVERSO                            │
│                    (Roteamento de Requisições)                  │
└───────────────────────────┬─────────────────────────────────────┘
                            |
                            ▼
   ┌──────────────────────────────────────────────────────────┐
   │                        API Gateway                       │
   │     (Serviço central para o agrupamento das respostas)   │
   └────────────────────────┬─────────────────────────────────┘
                            │
            ┌───────────────┼───────────────┐
            ▼               ▼               ▼
     ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
     │   API-AUTH  │ │  API-USER   │ │  API-BLOG   │
     │ Autenticação│ │  Usuários   │ │    Blog     │
     │  Laravel 12 │ │  Laravel 12 │ │  Laravel 12 │
     │   PHP 8.3+  │ │   PHP 8.3+  │ │   PHP 8.3+  │
     └──────┬──────┘ └──────┬──────┘ └──────┬──────┘
            │               │               │
            ▼               ▼               ▼
     ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
     │  Database   │ │  Database   │ │  Database   │
     │  auth_db    │ │  user_db    │ │  blog_db    │
     └─────────────┘ └─────────────┘ └─────────────┘
```

---

## 🔧 Microsserviços

### 1. API-AUTH (Serviço de Autenticação)

Responsável pela autenticação e autorização entre os microsserviços.

| Característica | Descrição |
|----------------|-----------|
| **Função** | Gerenciar tokens JWT, validar credenciais e autorizar comunicação entre serviços |
| **Endpoints** | `/auth/refresh`, `/auth/validate` |
| **Banco de Dados** | `auth_db` - Armazena tokens, sessões e logs de autenticação |

### 2. API-USER (Serviço de Usuários)

Responsável pelo gerenciamento completo de usuários da plataforma.

| Característica | Descrição |
|----------------|-----------|
| **Função** | CRUD de usuários, perfis, permissões e preferências |
| **Endpoints** | `/users`, `/users/{id}`, `/users/{id}/profile`, `/users/{id}/permissions` |
| **Banco de Dados** | `user_db` - Armazena dados de usuários, perfis e configurações |

### 3. API-BLOG (Serviço do Blog)

Responsável pelo gerenciamento de conteúdo do blog.

| Característica | Descrição |
|----------------|-----------|
| **Função** | CRUD de posts, categorias, tags e comentários |
| **Endpoints** | `/posts`, `/posts/{id}`, `/categories`, `/tags`, `/comments` |
| **Banco de Dados** | `blog_db` - Armazena posts, categorias, tags e comentários |

---

## 🔄 Fluxo de Comunicação

```
┌──────────┐     ┌───────────────┐     ┌─────────────┐
│ Page Web │───▶ │ Proxy Reverso │───▶│  API-AUTH   │
└──────────┘     └───────────────┘     └──────┬──────┘
                                              │
                                    Token JWT │ Validado
                                              ▼
                        ┌─────────────────────────────────────┐
                        │     Requisição autorizada para:     │
                        │  ┌───────────┐    ┌───────────┐     │
                        │  │ API-USER  │ ou │ API-BLOG  │     │
                        │  └───────────┘    └───────────┘     │
                        └─────────────────────────────────────┘
```

1. O leitor faz uma requisição ao **Proxy Reverso**
2. O Proxy encaminha para o **API-AUTH** para validação do token
3. Se válido, a requisição é encaminhada ao microsserviço de destino
4. O microsserviço processa e retorna a resposta

---

## 🛠️ Stack Tecnológica

| Tecnologia | Versão | Finalidade |
|------------|--------|------------|
| **PHP** | 8.3+ | Linguagem de programação |
| **Laravel** | 12+ | Framework PHP para APIs REST |
| **EloquentORM** | Latest | Estruturação de modelos e operações ao banco de dados |
| **PestPHP** | v4 | Framework de testes com foco na simplicidade |
| **Docker** | Latest | Containerização dos serviços |
| **Docker Compose** | Latest | Orquestração dos containers |
| **Apache** | 2.4+ | Servidor web |
| **MySQL/PostgreSQL** | Latest | Banco de dados relacional |
| **Apache** | Latest | Proxy reverso |
| **CI** | Latest | Integração contínua para execução dos testes automatizados

---

## 📁 Estrutura do Projeto

```
developer-blog/
|
├── docker-compose.yml
├── proxy/
│   └── nginx.conf
├── public_html/
│   └── services/
│       ├── api-auth/          # Microsserviço de Autenticação
│       │   ├── app/
│       │   ├── config/
│       │   ├── database/
│       │   ├── routes/
│       │   └── ...
│       ├── api-user/          # Microsserviço de Usuários
│       │   ├── app/
│       │   ├── config/
│       │   ├── database/
│       │   ├── routes/
│       │   └── ...
│       └── api-blog/          # Microsserviço do Blog
│           ├── app/
│           ├── config/
│           ├── database/
│           ├── routes/
│           └── ...
└── README.md
```

---

## 🚀 Como Executar

### Pré-requisitos

- Docker e Composer instalados
- Git

### Instalação

```bash
# Clone o repositório
git clone <url-do-repositorio>

# Entre no diretório
cd developer-blog/docker

# Construa os containers
docker compose build

# Iniciei os containers
docker compose up -d

# Instale as dependências de cada serviço
docker compose exec api-auth composer install
docker compose exec api-user composer install
docker compose exec api-blog composer install

# Execute as migrations
docker compose exec api-auth php artisan migrate
docker compose exec api-user php artisan migrate
docker compose exec api-blog php artisan migrate
```

---

## 📖 Princípios Aplicados

### SOLID

| Princípio | Descrição | Aplicação no Projeto |
|-----------|-----------|----------------------|
| **S** - Single Responsibility | Cada classe tem uma única responsabilidade | Controllers, Services, Repositories separados |
| **O** - Open/Closed | Aberto para extensão, fechado para modificação | Uso de interfaces e abstrações |
| **L** - Liskov Substitution | Subtipos substituíveis por seus tipos base | Implementação correta de interfaces |
| **I** - Interface Segregation | Interfaces específicas e coesas | Interfaces pequenas e focadas |
| **D** - Dependency Inversion | Depender de abstrações, não de implementações | Injeção de dependências via Service Container |

### DRY (Don't Repeat Yourself)

- Código reutilizável através de recursos e services
- Componentes compartilhados entre microsserviços
- Helpers e utilitários centralizados

### Outras Boas Práticas

- **Clean Code**: Código legível e bem documentado
- **Design Patterns**: Repository, Service Layer, Factory
- **API RESTful**: Endpoints semânticos e padronizados
- **Versionamento de API**: Preparado para múltiplas versões

---

## 📝 Licença

Projeto para fins educacionais.
