# API Gue

API para verificação de disponibilidade de nomes e sugestões.

## Endpoints

### GET /
Verifica disponibilidade de um nome

**Parâmetros:**
- `name` (string, obrigatório): Nome a verificar (mínimo 4 caracteres)

**Resposta:**
```json
{
  "name": "example",
  "exists": false,
  "suggestions": []
}
```

### GET /api
Mesmo comportamento do endpoint raiz

## Requisitos

- PHP >= 8.0
- cURL (para requisições HTTP)

## Instalação

```bash
composer install
```

## Deploy Vercel

Este projeto está configurado para deploy automático na Vercel.

1. Push do código para GitHub/GitLab
2. Conecte o repositório à Vercel
3. Vercel detectará `vercel.json` automaticamente
4. Deploy automático para cada push

## Variáveis de Ambiente

Crie um arquivo `.env.local` para desenvolvimento local:

```env
APP_ENV=local
```

## Desenvolvimento Local

```bash
# Com PHP built-in server
php -S localhost:8000

# Ou use XAMPP conforme já está configurado
```

## Estrutura do Projeto

```
├── index.php              # Entry point principal
├── api/
│   └── index.php          # Entry point da API
├── src/
│   ├── Gue/
│   │   └── GueClient.php
│   └── Name/
│       ├── NameAvailabilityService.php
│       └── NameSuggestionService.php
├── Utils/
│   └── StringNormalizer.php
├── public/
│   └── result.php
├── vercel.json            # Configuração Vercel
└── composer.json          # Dependências
```
