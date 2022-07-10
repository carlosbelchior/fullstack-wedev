# API WEDEV - BELCHIOR
Software WeDev - Por Carlos Belchior.

## Tecnologias
As tecnologias abaixo descritas foram utilizadas para desenvolver esse projeto
The following technologies are being used to make this project work.

- *Laravel 9.x*
- *Vue.js 3.x*  
- *Vuex 4.x*  
- *MySQL (or MariaDB)*

## Módulos
Os módulos do projeto são:
- Clientes (CRUD)
- Produtos (CRUD)
- Pedidos (CRUD)

## Configuração do projeto
Este é basicamente um projeto laravel. Para executar se faz necessário seguir os requisitos do framework. É EXTREMAMENTE recomendado que use docker para executar esta aplicação. Você pode instalr o Docker seguindo as instruções do link a seguir para [obter o docker](https://docs.docker.com/engine/install/).

As próximas sessões irão fornecer instruções de como configurar e executar a aplicação em um container Docker.

### Iniciando
Para configurar seu container docker execute o comando abaixo:

```bash
docker-compose up --build -d
```

Após criado o container docker acesse o serviço do PHP com o comando abaixo:
```bash
docker-compose exec php /bin/bash
```

O container docker será executado com imagens nginx, mysql e PHP.

#### Arquivos de configuração
Faça uma cópia do arquivo `.env.example`para `.env` e informe as variaveis de configuração conforme informado na documentação do Laravel no link a [seguir](https://laravel.com/docs/9.x/configuration).

Para testes locais use a seguinte configuração no .env:
```bash
APP_URL=http://localhost:8080
```

IMPORTANTE: As configurações de acesso padrões do banco de dados são:
- host: mysql
- database: default
- user: root
- password: admin

#### Instalando dependencias
Execute os comandos abaixo para instalar todas as dependencias do projeto:
```bash
composer install 
```
```bash
npm install 
```

#### Gerar chave laravel

```bash
php artisan key:generate 
```

#### Executando as migrations
Entre no seu serviço PHP e execute as migrations para configurar seu banco de dados:

```bash
php artisan migrate
```

#### Executando as seeds
Entre no seu serviço PHP e execute as seeds para criar dados de teste em seu banco de dados:

```bash
php artisan db:seed
```

#### Executando testes
Entre no seu serviço PHP e execute o comando abaixo para executar os testes do Laravel:

```bash
php artisan test
```

#### Executando testes
Entre no seu serviço PHP e execute o comando abaixo para executar os testes do Laravel:

```bash
php artisan test
```

#### Rodando o sistema (testes locais)
Execute o comando abaixo direto no terminal do seu sistema, dentro da pasta do projeto

```bash
npm run dev
```

#### Parar a aplicação
Para parar de executar a aplicação, execute o comando abaixo:

```bash
docker-compose down -v
```

## End-points

### Cliente:

Para buscar os clientes:
```json
Method: GET
URL: /api/clientes/todos
```


Para criar um novo cliente:
```json
Method: POST
URL: /api/clientes/inserir
Data body:
- 'nome' => 'required|min:3',
- 'cpf' => 'required|unique:clientes|cpf',
- 'email' => 'nullable|email|unique:clientes'
```


Para atualizar o cliente:
```json
Method: POST
URL: /api/clientes/atualizar/ID_DO_CLIENTE
Data body:
- 'nome' => 'required|min:3',
- 'cpf' => 'required|unique:clientes|cpf',
- 'email' => 'nullable|email|unique:clientes'
```

Para buscar um cliente especifico:
```json
Method: GET
URL: /api/clientes/encontrar/ID_DO_CLIENTE
```


Para excluir um cliente:
```json
Method: GET
URL: /api/clientes/exclusao/ID_DO_CLIENTE
```




### Produto:

Para buscar os produtos:
```json
Method: GET
URL: /api/produtos/todos
```


Para criar um novo produto:
```json
Method: POST
URL: /api/produtos/inserir
Data body:
- 'nome' => 'required|min:3',
- 'cod_barras' => 'required|unique:produtos|min:20|max:20',
- 'valor_unitario' => 'required|numeric'
```


Para atualizar o produto:
```json
Method: POST
URL: /api/produtos/atualizar/ID_DO_PRODUTO
Data body:
- 'nome' => 'required|min:3',
- 'cod_barras' => 'required|unique:produtos|min:20|max:20',
- 'valor_unitario' => 'required|numeric'
```

Para buscar um produto especifico:
```json
Method: GET
URL: /api/produtos/encontrar/ID_DO_PRODUTO
```


Para excluir um cliente:
```json
Method: GET
URL: /api/produtos/exclusao/ID_DO_PRODUTO
```


### Pedido:

Para buscar os pedidos:
```json
Method: GET
URL: /api/pedidos/todos
```


Para criar um novo pedido:
```json
Method: POST
URL: /api/pedidos/inserir
Data body:
- 'cliente_id' => 'required|integer',
- 'data_pedido' => 'required|date',
- 'produtos_pedido' => 'required|array|min:1',
- 'status' => 'required|integer|between:1,3'
```


Para atualizar o pedido:
```json
Method: POST
URL: /api/pedidos/atualizar/ID_DO_PEDIDO
Data body:
- 'cliente_id' => 'required|integer',
- 'data_pedido' => 'required|date',
- 'produtos_pedido' => 'required|array|min:1',
- 'status' => 'required|integer|between:1,3'
```

Exemplo de formato JSON para cadastro de pedido:
```json
{
    "cliente_id": 1,
    "data_pedido": "2022-07-09",
    "status": 1,
    "produtos_pedido": [
        {
            "pivot": 
            {
                "pedido_id": 3,
                "produto_id": 4,
                "quantidade": 3
            }
        },
        {
            "pivot": 
            {
                "pedido_id": 3,
                "produto_id": 5,
                "quantidade": 1
            }
        },
        {
            "pivot": 
            {
                "pedido_id": 3,
                "produto_id": 8,
                "quantidade": 9
            }
        }
    ]
}
```

Para buscar um pedido especifico:
```json
Method: GET
URL: /api/pedidos/encontrar/ID_DO_PEDIDO
```


Para excluir um cliente:
```json
Method: GET
URL: /api/pedidos/exclusao/ID_DO_PEDIDO
```
