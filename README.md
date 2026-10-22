# 📋 Gestão de Tarefas - Projeto Laravel

Sistema simples de **gerenciamento de tarefas** com CRUD e autenticação básica usando Laravel.

---

## 🚀 Como acessar o projeto

1. **Clonar o repositório**

```bash
git clone https://github.com/project-avp1/gestao-tarefas.git
cd gestao-tarefas
```

2. **Entrar em uma branch existente**

```bash
git fetch --all
# Listar branches disponíveis
git branch -a
# Entrar em branch existente
git checkout nome-da-branch
```

3. **Instalar dependências PHP e JS**

```bash
composer install
npm install
```

4. **Copiar .env e gerar chave**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Migrar banco de dados**

```bash
php artisan migrate
```

6. **Rodar servidor local**

```bash
php artisan serve
# acesse http://127.0.0.1:8000
```

