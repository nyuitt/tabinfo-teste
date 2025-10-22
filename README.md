# TabInfo

Sistema completo de gerenciamento de usuários com API REST, dashboard web e aplicativo mobile.

## 📋 Visão Geral

Este projeto é um monorepo que contém:

- **Back-end**: API REST + Dashboard web em Laravel 11 com autenticação Sanctum
- **Mobile**: Aplicativo React Native + Expo + TypeScript que consome a API

### Arquitetura

```
tabinfo-teste/
├── back-end/          # Laravel  (API REST + Dashboard Blade)
├── mobile/            # Expo + React Native + TypeScript
└── README.md          # Este arquivo
```

O back-end Laravel expõe uma API REST documentada via Swagger e também fornece um dashboard web simples protegido por autenticação. O aplicativo mobile consome a API para todas as operações de usuário.

## ✨ Funcionalidades

### Back-end (Laravel)

**API REST:**
- Registro de usuários
- Login com geração de token Bearer (Sanctum)
- Recuperação de senha via e-mail
- Redefinição de senha
- Obter dados do usuário autenticado
- CRUD completo de usuários (apenas administradores)

**Dashboard Web:**
- Login com autenticação segura
- Dashboard protegida mostrando informações do usuário
- Logout

**Documentação:**
- Swagger/OpenAPI acessível em `/api/documentation`

### Mobile (Expo)

- Tela de login
- Tela de cadastro
- Tela de recuperação de senha
- Dashboard protegida com informações do usuário
- Gerenciamento de usuários (CRUD) - apenas para administradores
- Interceptor Axios com Bearer token automático
- Estados de loading e tratamento de erros

## 🛠️ Tecnologias

### Back-end
- PHP 8.2+
- Laravel 11
- Laravel Sanctum (autenticação API)
- l5-swagger (documentação OpenAPI)
- Blade (views web)
- MySQL

### Mobile
- React Native
- Expo
- TypeScript
- React Navigation
- Axios
- Expo Secure Store

## 📦 Pré-requisitos

- PHP >= 8.2
- Composer
- MySQL
- Node.js >= 18
- npm ou yarn
- Expo CLI (instalado globalmente): `npm install -g expo-cli`

## 🚀 Setup do Back-end

### 1. Instalar dependências

```bash
cd back-end
composer install
```

### 2. Configurar ambiente

Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e configure o banco de dados MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tabinfo
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 3. Gerar chave da aplicação

```bash
php artisan key:generate
```

### 4. Criar o banco de dados

Crie um banco de dados MySQL com o nome configurado no `.env`:

```sql
CREATE DATABASE tabinfo;
```

### 5. Executar migrations e seeders

```bash
php artisan migrate --seed
```

Isso criará as tabelas necessárias e populará o banco com usuários de teste:

**Administrador:**
- E-mail: `admin@tabinfo.com`
- Senha: `password`

**Usuários comuns:**
- `joao@tabinfo.com` / `password`
- `maria@tabinfo.com` / `password`
- `pedro@tabinfo.com` / `password`

### 6. Gerar documentação Swagger

```bash
php artisan l5-swagger:generate
```

### 7. Iniciar o servidor

```bash
php artisan serve
```

O servidor estará disponível em `http://localhost:8000`

### 8. Acessar o Swagger

Após iniciar o servidor, acesse a documentação da API em:

```
http://localhost:8000/api/documentation
```

### 9. Acessar o Dashboard Web

Para acessar o dashboard web, vá para:

```
http://localhost:8000/login
```

Use as credenciais do administrador ou de qualquer usuário de teste.

## 📱 Setup do Mobile

### 1. Instalar dependências

```bash
cd mobile
npm install
```

### 2. Configurar URL da API

Edite o arquivo `mobile/config/api.ts` e ajuste a `API_BASE_URL`:

```typescript
export const API_BASE_URL = 'http://SEU_IP_LOCAL:8000/api';
```

**Importante:**
- Para testar em dispositivo físico, use o IP da sua máquina na rede local (ex: `http://192.168.1.10:8000/api`)
- Para emulador Android, você pode usar `http://10.0.2.2:8000/api`
- Para emulador iOS, use `http://localhost:8000/api`

### 3. Iniciar o app

```bash
npm start
```

Isso abrirá o Expo DevTools no navegador. A partir daí você pode:

- Pressionar `a` para abrir no emulador Android
- Pressionar `i` para abrir no simulador iOS
- Escanear o QR code com o app Expo Go no seu dispositivo

### 4. Build para produção (opcional)

Para gerar um APK/AAB para Android:

```bash
npm run android
```

Para iOS:

```bash
npm run ios
```

## 📚 Rotas da API

### Autenticação (Públicas)

| Método | Rota | Descrição |
|--------|------|-----------|
| POST | `/api/auth/register` | Registrar novo usuário |
| POST | `/api/auth/login` | Login e obter token |
| POST | `/api/auth/forgot-password` | Solicitar recuperação de senha |
| POST | `/api/auth/reset-password` | Redefinir senha |

### Autenticadas (Bearer Token)

| Método | Rota | Descrição |
|--------|------|-----------|
| POST | `/api/auth/logout` | Fazer logout |
| GET | `/api/me` | Obter dados do usuário autenticado |

### Usuários (Admin apenas)

| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/api/users` | Listar todos os usuários |
| POST | `/api/users` | Criar novo usuário |
| GET | `/api/users/{id}` | Obter usuário específico |
| PUT | `/api/users/{id}` | Atualizar usuário |
| DELETE | `/api/users/{id}` | Deletar usuário |

**Para detalhes completos, consulte a documentação Swagger em `/api/documentation`**

## 🔐 Segurança e Autorização

- Todas as rotas de usuários (`/api/users/*`) são protegidas e requerem autenticação via token Bearer
- Apenas usuários com `is_admin = true` podem acessar as rotas de gerenciamento de usuários
- A autorização é controlada via `UserPolicy` do Laravel
- Um administrador não pode deletar a si mesmo
- Senhas são sempre armazenadas com hash bcrypt
- Tokens de autenticação são gerenciados pelo Laravel Sanctum

## 📁 Estrutura de Pastas

### Back-end

```
back-end/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── UserController.php
│   │   │   └── Web/
│   │   │       ├── AuthController.php
│   │   │       └── DashboardController.php
│   │   ├── Requests/
│   │   │   ├── Auth/
│   │   │   └── User/
│   │   └── Resources/
│   │       └── UserResource.php
│   ├── Models/
│   │   └── User.php
│   └── Policies/
│       └── UserPolicy.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       │   └── index.blade.php
│       └── layouts/
│           └── app.blade.php
└── routes/
    ├── api.php
    └── web.php
```

### Mobile

```
mobile/
├── app/
│   ├── (tabs)/
│   │   ├── _layout.tsx
│   │   ├── index.tsx
│   │   └── users.tsx
│   ├── _layout.tsx
│   ├── index.tsx
│   ├── register.tsx
│   ├── forgot-password.tsx
│   └── user-form.tsx
├── components/
│   └── ui/
│       ├── button.tsx
│       ├── input.tsx
│       └── container.tsx
├── config/
│   └── api.ts
├── context/
│   └── AuthContext.tsx
└── services/
    ├── api.ts
    ├── auth.ts
    └── users.ts
```

## 🧪 Como Testar

### Back-end

1. Inicie o servidor: `php artisan serve`
2. Acesse o Swagger: `http://localhost:8000/api/documentation`
3. Teste os endpoints diretamente pelo Swagger
4. Ou use Postman/Insomnia importando a documentação OpenAPI

### Mobile

1. Certifique-se de que o back-end está rodando
2. Configure a `API_BASE_URL` corretamente
3. Inicie o app: `npm start`
4. Teste o fluxo completo:
   - Faça login com `admin@exemplo.com` / `password`
   - Navegue até a aba "Usuários"
   - Teste criar, editar e excluir usuários
   - Faça logout e teste o registro de novo usuário



## 📝 Notas de Desenvolvimento

### Back-end

- Controllers são enxutos, delegando validação para FormRequests
- Respostas JSON padronizadas via API Resources
- Policies controlam autorização de acesso
- Migrations versionadas seguem convenções Laravel
- Seeders criam dados de teste reproduzíveis

### Mobile

- Context API para gerenciamento de estado de autenticação
- Axios com interceptors para injeção automática de token
- Navegação via Expo Router (file-based routing)
- Componentes de UI reutilizáveis
- TypeScript para type safety
- Secure Store para armazenamento seguro de tokens


Desenvolvido com ❤️ usando Laravel, React Native e TypeScript.
