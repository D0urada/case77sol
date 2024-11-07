# Case 77Sol

## Passo a passo para rodar o projeto

1. Clone o projeto:
    ```sh
    git clone https://github.com/D0urada/case77sol case77sol
    ```

2. Entre no diretório do projeto:
    ```sh
    cd case77sol/
    ```

3. Crie o arquivo `.env`:
    ```sh
    cp .env.example .env
    ```

4. Atualize as variáveis de ambiente no arquivo `.env`:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=case77sol
    DB_USERNAME=username
    DB_PASSWORD=userpass
    ```

5. Suba os containers do projeto:
    ```sh
    docker-compose up -d
    ```

6. Acesse o container:
    ```sh
    docker-compose exec app bash
    ```

7. Instale as dependências do projeto:
    ```sh
    composer install
    ```

8. Gere a chave do projeto Laravel:
    ```sh
    php artisan key:generate
    ```

9. Popule o banco de dados:
    ```sh
    php artisan migrate:refresh --seed
    ```

10. Instale as dependências do frontend:
    ```sh
    npm install
    ```

11. Gere a build ou abra o servidor do Vite:
    ```sh
    npm run build || npm run dev
    ```

12. Comando para rodar os testes automatizados (inicialmente comecei a implementá-los):
    ```sh
    php artisan test
    ```

13. Acesse o projeto:  
    [http://localhost:8000](http://localhost:8000)

14. Acesse o banco de dados:  
    [http://localhost:8080](http://localhost:8080)

15. Documentação:  
    [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

### Observações:

- A função de edição do formulário precisava de um tratamento no frontend, que não consegui concluir, para salvar os equipamentos corretamente e enviá-los para o backend.

- Para o restante, tentei seguir padrões com os quais já trabalhei no Laravel, como o uso de *repository* e *interface*. Pessoalmente, atualmente, gosto de utilizar o Blade para componentização e prefiro manter a modularização do frontend mais simples. Não vejo necessidade de usar Vue para um projeto mais simples.

- Também utilizei o Tailwind, que já vem no Laravel e gosto bastante, e a biblioteca open-source de componentes Flowbite.

- Aproveitei que gostod e retornar a maior parte do back como response, mesmo em uma aplicação sem separação de front e back, e apliquei oswagger a alguns retornos de CRUD que eram de response e não redirect ou view.
