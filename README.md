# API de Importação - Alpes One

Este projeto é uma aplicação **Laravel 12** que consome dados da **API Alpes One**, armazena em um banco de dados local (MySQL) e expõe esses dados através de uma **API REST**.  
Também possui um comando **Artisan** e agendamento automático para importação periódica dos dados.

---

## 📌 Funcionalidades

- Importa dados da API Alpes One via comando Artisan.
- Salva e atualiza os registros no banco de dados.
- Exposição de endpoints REST para consulta dos dados.
- Agendamento automático via **Scheduler** (cron).
- Estrutura pronta para deploy em **Docker**.

--- 

## ⚙️ Tecnologias

- [Laravel 12](https://laravel.com/)
- [PHP 8.2+](https://www.php.net/)
- [MySQL](https://www.mysql.com/)
- [Docker](https://www.docker.com/)
- [Cron](https://wiki.debian.org/cron)

---

## 🚀 Como rodar o projeto

### 1. Clonar o repositório
```bash
git clone https://github.com/Guilhermefariah/alpes-api
cd alpes-api
```

### 2. Configurar variáveis de ambiente
Copie o arquivo .env.example para .env:
```bash
cp .env.example .env
```
### 3. Subir os containers com Docker
```bash
docker-compose up -d --build
```
### 4. Instalar dependências
```bash
docker exec -it alpes-api-app composer install
```
### Rodar migrations
```bash
docker exec -it alpes-api-app php artisan migrate
```
### 🛠️ Comandos Artisan
Rodar a importação manualmente:
```bash
docker exec -it alpes-api-app php artisan alpes:import
```
Rodar as tasks agendadas:
```bash
docker exec -it alpes-api-app php artisan schedule:run
```
### ⏱️ Agendamento automático (Scheduler)
O cron já está configurado no container.
Ele executa o comando do Laravel a cada minuto:
```bash
* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1
```
### 📡 Endpoints da API
* `GET http://localhost:8000/api/items` → Lista todos os itens importados.

* `GET http://localhost:8000/api/items/1` → Exibe detalhes de um item específico.

Exemplo de resposta de um item (dados fictícios):
``` bash
{
  "id": 1,
  "code": "123456",
  "name": "Veículo Exemplo",
  "description": "Descrição resumida do veículo para fins de teste.",
  "price": "99999.00",
  "color": "Branco",
  "fuel": "Gasolina",
  "year_model": "2025",
  "year_build": "2025",
  "photos": [
    "https://via.placeholder.com/400x300.png?text=Foto+1",
    "https://via.placeholder.com/400x300.png?text=Foto+2"
  ],
  "sold": 0,
  "created_at": "2025-08-25T17:37:26.000000Z",
  "updated_at": "2025-08-25T20:20:35.000000Z"
}
```

### ✅ Testes
Rodar os testes automatizados:
```bash
docker exec -it alpes-api-app php artisan test
```