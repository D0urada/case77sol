# Case 77Sol

## Passo a passo para rodar o projeto
Clone o projeto
```sh
git clone https://github.com/D0urada/case77sol case77sol
```
```sh
cd case77sol/
```


Crie o Arquivo .env
```sh
cp .env.example .env
```


Atualize essas variáveis de ambiente no arquivo .env
```dosini

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=case77sol
DB_USERNAME=username
DB_PASSWORD=userpass

```


Suba os containers do projeto
```sh
docker-compose up -d
```


Acesse o container
```sh
docker-compose exec app bash
```


Instale as dependências do projeto
```sh
composer install
```


Gere a key do projeto Laravel
```sh
php artisan key:generate
```


Popule o banco
```sh
php artisan migrate:refresh --seed
```


Instale as dependências do frontend projeto
```sh
npm install
```

Instale gere a build ou abra o servidor do vite
```sh
npm run build || npm run dev
```


Acesse o projeto
[http://localhost:8000](http://localhost:8000)

Acesse o banco
[http://localhost:8080](http://localhost:8080)
