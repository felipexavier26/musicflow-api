# API de Gerenciamento de Músicas

Este projeto é uma API para gerenciamento de músicas, com funcionalidades para sugestão, listagem e manipulação de músicas, desenvolvida com Laravel. A API permite o gerenciamento de músicas por meio de requisições RESTful e a comunicação com o banco de dados MySQL. A API é segura e inclui autenticação para acesso aos recursos protegidos.

---

## Tecnologias Utilizadas

- **Laravel**: Framework PHP para construção do backend e da API RESTful.
- **MySQL**: Banco de dados para armazenamento de informações.
- **JWT (JSON Web Tokens)**: Utilizado para autenticação e segurança da API.
- **GuzzleHTTP**: Cliente HTTP para fazer requisições externas, como obter informações de vídeos do YouTube.
---

## Funcionalidades Principais

### API RESTful
- **Endpoints principais**:
  - **GET /musicas**: Retorna a lista de músicas cadastradas.
  - **GET /musicas/{id}**: Retorna os detalhes de uma música específica.
  - **POST /musicas**: Adiciona uma nova música à lista, dado um link do YouTube.
  - **PUT /musicas/{id}**: Atualiza as informações de uma música específica.
  - **DELETE /musicas/{id}**: Remove uma música do banco de dados.

- **Exemplo de resposta da API**:
    ```json
    {
        "id": 4,
        "titulo": "Tristeza do Jeca",
        "visualizacoes": 245879,
        "youtube_id": "tRQ2PWlCcZk",
        "thumb": "https://img.youtube.com/vi/tRQ2PWlCcZk/hqdefault.jpg",
        "created_at": "2025-01-08T03:14:02.000000Z",
        "updated_at": "2025-01-08T03:14:02.000000Z",
        "url": null,
        "status": "Pendente"
    }
    ```

- **Operações CRUD**: A API permite a criação, leitura, atualização e exclusão (CRUD) de músicas, baseando-se em informações obtidas do YouTube.

---

## Instruções de Instalação e Execução

### Requisitos

- **PHP**: >= 8.0
- **Composer**: Para gerenciar as dependências do Laravel.
- **MySQL**: Banco de dados configurado e acessível.
- **Node.js e npm**: Para instalar dependências de pacotes JavaScript, se necessário (caso use algum frontend ou outras dependências JavaScript).


### Requisitos
- **PHP**: >= 8.0
- **Composer**: Para gerenciar as dependências do Laravel.
- **Node.js e npm**: Para o frontend React.
- **MySQL**: Banco de dados configurado e acessível.

### Passos

1. **Clone o Repositório**:
   ```bash
   git clone https://github.com/felipexavier26/musicflow-api.git
   cd musicflow


### Passos
2. **Configuração do Backend**:
   ```bash

   - Instale as dependências do Laravel
   composer install

   - Copie o arquivo de exemplo de configuração
   cp .env.example .env

3. **Configuração do Banco de Dados: No arquivo .env, configure os parâmetros do banco de dados:**:   
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=


4. **Execute as migrações e seeders**:
   ```bash
    php artisan migrate --seed

5. **Geração de Chave da Aplicação**:
   ```bash
    php artisan key:generate


6. **Inicie o Servidor de Desenvolviment**:
    ```bash
    php artisan serve

7. **Acesse a API**:
    ```bash
    Abra o navegador ou use uma ferramenta como o Postman para acessar os endpoints da API em http://127.0.0.1:8000/api/musicas.
