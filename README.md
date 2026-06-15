# mvc-api-php

API REST em PHP com arquitetura MVC.

## Descrição

Este projeto é uma base para construção de uma API utilizando PHP seguindo o padrão **MVC (Model-View-Controller)**. A proposta é organizar o código de forma simples e escalável, separando responsabilidades entre camadas.

## Estrutura do projeto

```text
.
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
├── public/
├── routes/
├── config/
└── README.md
```

> A estrutura acima pode variar conforme a evolução do projeto.

## Requisitos

- PHP 8.0 ou superior
- Composer
- Servidor local, como Apache, Nginx ou o servidor embutido do PHP

## Instalação

1. Clone este repositório:

```bash
git clone https://github.com/AislanSouza35/mvc-api-php.git
cd mvc-api-php
```

2. Instale as dependências:

```bash
composer install
```

## Executando o projeto

Se estiver utilizando o servidor embutido do PHP:

```bash
php -S localhost:8000 -t public
```

A aplicação ficará disponível em `http://localhost:8000`.

## Organização MVC

- **Models**: responsáveis pelas regras de negócio e acesso a dados.
- **Views**: camada de apresentação, quando aplicável.
- **Controllers**: recebem as requisições, processam regras e retornam respostas.

## Rotas

As rotas da aplicação devem ser definidas em um arquivo ou diretório dedicado, como `routes/`.

Exemplo conceitual:

```php
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
```

## Respostas da API

Como se trata de uma API, as respostas normalmente são retornadas em **JSON**.

Exemplo:

```json
{
  "success": true,
  "message": "API funcionando corretamente"
}
```

## Próximos passos

- Configurar sistema de rotas
- Criar controllers base
- Implementar conexão com banco de dados
- Adicionar validação de requisições
- Padronizar respostas JSON
- Criar autenticação para a API

## Contribuição

Sinta-se à vontade para abrir issues e enviar pull requests com melhorias.

## Licença

Defina aqui a licença do projeto, caso deseje disponibilizá-lo publicamente.
