# Documentação - Lista de Exercícios - Tinnova

Dependências Utilizadas:
- Laravel 10 - https://laravel.com/docs/10.x
- PHPUnit - https://laravel.com/docs/12.x/testing

## Instalação do projeto e dependências
Primeiramente, você deve clonar o repositório no seu ambiente local usando o comando:
- `$ git clone https://github.com/raborzoni/exercicios-tinnova.git`
- `$ cd exercicios-tinnova`

Após o clone, instale as dependências do projeto com o comando:
- `$ composer install`

Copie o arquivo .env.example para .env com o comando:
- `$ cp .env.example .env`

Gere uma nova key do Laravel para o seu projeto:
- `$ php artisan key:generate`

## Startar o Sistema
Apois todas as configurações acima, inicie o sistema com o comando:
- `$ php artisan serve`

## Rotas
### Exercício 1
- `GET /votos` - Calcula os votos pré-determinados de acordo com a questão.

### Exercício 2
- `GET /bubble-sort` - Ordena as posições com os números determinados na questão.

### Exercício 3
- `GET /fatorial/testes` - Faz os testes com os números básicos, de acordo com o exercício.
- `GET /fatorial/{numero}` - Faz os testes com o número que você determinar.

### Exercício 4
- `GET /multiplos/teste` - Soma os múltiplos de acordo com números básicos, de acordo com o exercício.
- `GET /multiplos/{numero}` - Faz os testes com o número que você determinar.