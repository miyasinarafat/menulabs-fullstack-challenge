# Fullstack Challenge

## Demo
### API
<img width="1325" alt="image" src="https://user-images.githubusercontent.com/16781160/224520955-4ec73b10-ab79-4af1-8e5f-89d41d13c419.png">

### Frontend
![image](https://user-images.githubusercontent.com/16781160/224520992-ebc7e0b1-9ee7-4a8c-bc51-4777c33218fd.png)


## To run the local dev environment:

### API
- Navigate to `/api` folder
- Ensure version docker installed is active on host
- Copy .env.example: `cp .env.example .env`
- Start docker containers `docker compose up` (add `-d` to run detached)
- Connect to container to run commands: `docker exec -it fullstack-challenge-app-1 bash`
  - Make sure you are in the `/var/www/html` path
  - Install php dependencies: `composer install`
  - Setup app key: `php artisan key:generate`
  - Migrate database: `php artisan migrate` 
  - Seed database: `php artisan db:seed`
  - Run open weather command: `php artisan openweather:retrieve`
  - Run tests: `php artisan test`
- Visit api: `http://localhost`

### Frontend
- Navigate to `/frontend` folder
- Ensure nodejs v18 is active on host
- Install javascript dependencies: `npm install`
- Run frontend: `npm run dev`
- Visit frontend: `http://localhost:5173`
