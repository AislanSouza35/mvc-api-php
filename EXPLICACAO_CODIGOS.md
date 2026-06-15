# Explicacao dos codigos - API-ALUNOS-MVC

## 1. Visao geral do projeto

Este projeto e uma API simples em PHP, organizada no padrao MVC:

- **Model**: acessa e manipula dados no banco.
- **View**: nao ha interface grafica aqui, pois e uma API JSON.
- **Controller**: recebe as acoes da requisicao e chama o Model.
- **Entrada principal (Front Controller)**: `index.php` centraliza as rotas por acao.

O objetivo da API e gerenciar alunos (listar, cadastrar, editar, excluir).

---

## 2. Fluxo geral da requisicao

1. O cliente chama `index.php` com `?acao=...`.
2. O `index.php` define cabecalhos CORS e JSON.
3. O `index.php` cria `AlunoController`.
4. O `index.php` le o corpo JSON (`php://input`).
5. Dependendo da acao, chama um metodo do controller.
6. O controller valida dados basicos.
7. O controller chama o model (`Aluno`).
8. O model executa SQL via PDO.
9. A API retorna JSON de sucesso, erro ou lista de alunos.

---

## 3. Explicacao por arquivo

## 3.1 `index.php`

Arquivo de entrada da API.

### O que ele faz

- Define cabecalhos HTTP:
  - `Access-Control-Allow-Origin: *`: permite requisicoes de qualquer origem.
  - `Access-Control-Allow-Headers: Content-Type`: libera envio de JSON no header.
  - `Access-Control-Allow-Methods: GET, POST, PUT, DELETE`: informa metodos permitidos.
  - `Content-Type: application/json`: padroniza resposta em JSON.
- Carrega o controller com `require_once`.
- Cria instancia de `AlunoController`.
- Le a acao pela query string (`$_GET["acao"]`).
- Le os dados JSON do corpo (`php://input`) e converte para array.
- Encaminha para o metodo correto:
  - `listar`
  - `cadastrar`
  - `editar`
  - `excluir`
- Se a acao for invalida, retorna:
  - `{ "erro": "Ação inválida" }`

### Papel na arquitetura

Funciona como um roteador simples baseado em parametro `acao`.

---

## 3.2 `config/conexao.php`

Arquivo responsavel pela conexao com o banco MySQL usando PDO.

### O que ele faz

- Define a classe `Conexao`.
- Metodo estatico `conectar()`:
  - Configura host, banco, usuario e senha.
  - Cria o objeto PDO com charset UTF-8.
  - Ativa excecoes em erros de SQL (`PDO::ERRMODE_EXCEPTION`).
  - Retorna a conexao pronta para uso.
- Em caso de falha:
  - Retorna JSON com a mensagem de erro.
  - Interrompe a execucao com `exit`.

### Papel na arquitetura

Centraliza o acesso ao banco, evitando repetir configuracao de conexao.

---

## 3.3 `models/Aluno.php`

Model da entidade Aluno. Aqui ficam as operacoes de banco de dados.

### O que ele faz

- Importa a conexao (`config/conexao.php`).
- No construtor, abre conexao com `Conexao::conectar()`.
- Implementa metodos CRUD:

1. `listar()`
- Executa `SELECT * FROM alunos ORDER BY id DESC`.
- Retorna todos os registros em array associativo.

2. `cadastrar($nome, $email)`
- Executa `INSERT INTO alunos (nome, email)`.
- Usa `prepare` + `bindValue` (mais seguro que concatenacao de string).
- Retorna resultado do `execute()`.

3. `editar($id, $nome, $email)`
- Executa `UPDATE alunos SET ... WHERE id = :id`.
- Usa parametros nomeados com `bindValue`.
- Retorna resultado do `execute()`.

4. `excluir($id)`
- Executa `DELETE FROM alunos WHERE id = :id`.
- Usa `prepare` + `bindValue`.
- Retorna resultado do `execute()`.

### Papel na arquitetura

Concentra toda regra de persistencia dos alunos.

---

## 3.4 `controllers/Alunocontroller.php`

Controller que recebe dados da entrada e coordena o uso do Model.

### O que ele faz

- Importa o model (`models/Aluno.php`).
- Cria a propriedade privada `$aluno`.
- No construtor, instancia o model.
- Implementa as acoes da API:

1. `listar()`
- Chama `$this->aluno->listar()`.
- Retorna os dados em JSON.

2. `cadastrar($dados)`
- Extrai `nome` e `email` do corpo JSON.
- Valida campos obrigatorios.
- Se faltar dado, retorna erro em JSON.
- Se estiver valido, chama o model para inserir.
- Retorna mensagem de sucesso.

3. `editar($dados)`
- Extrai `id`, `nome`, `email`.
- Valida obrigatoriedade dos 3 campos.
- Em caso de falta, retorna erro JSON.
- Chama model para atualizar.
- Retorna sucesso.

4. `excluir($dados)`
- Extrai `id`.
- Valida obrigatoriedade.
- Chama model para excluir.
- Retorna sucesso.

### Papel na arquitetura

Faz a ponte entre entrada HTTP (`index.php`) e acesso ao banco (`Aluno.php`), aplicando validacoes simples.

---

## 4. Endpoints (baseados em `acao`)

A URL base e `index.php?acao=...`.

1. Listar alunos
- Metodo sugerido: `GET`
- URL: `index.php?acao=listar`
- Body: nao precisa

2. Cadastrar aluno
- Metodo sugerido: `POST`
- URL: `index.php?acao=cadastrar`
- Body JSON:
  ```json
  {
    "nome": "Maria",
    "email": "maria@email.com"
  }
  ```

3. Editar aluno
- Metodo sugerido: `PUT`
- URL: `index.php?acao=editar`
- Body JSON:
  ```json
  {
    "id": 1,
    "nome": "Maria Souza",
    "email": "maria.souza@email.com"
  }
  ```

4. Excluir aluno
- Metodo sugerido: `DELETE`
- URL: `index.php?acao=excluir`
- Body JSON:
  ```json
  {
    "id": 1
  }
  ```

---

## 5. Estrutura da tabela esperada

O model usa a tabela `alunos`, com colunas:

- `id` (normalmente inteiro auto incremento)
- `nome` (texto)
- `email` (texto)

---

## 6. Pontos de melhoria futuros (opcional)

- Padronizar codigos HTTP (200, 201, 400, 404, 500).
- Validar formato de email antes de salvar.
- Tratar excecoes SQL no Model/Controller para respostas mais claras.
- Separar rotas por metodo HTTP em vez de `acao` por query string.
- Proteger credenciais com variaveis de ambiente.
- Corrigir padrao de nome de arquivo/classe para evitar problemas em Linux:
  - Classe: `AlunoController`
  - Arquivo: `AlunoController.php`

---

## 7. Resumo

- `index.php`: entrada da API e roteamento por `acao`.
- `config/conexao.php`: conexao unica com o MySQL.
- `models/Aluno.php`: CRUD da tabela `alunos`.
- `controllers/Alunocontroller.php`: validacao basica e orquestracao das acoes.

Com isso, o projeto entrega uma API MVC enxuta para cadastro e manutencao de alunos em JSON.
