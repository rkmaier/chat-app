   

 ## Követelmények
 - PHP >= 8.3
 - MySQL/MariaDB
 - Composer

  ## Konfiguráció

   1. `.env fájl létrehozása a .env.example alapján`
   2. `.env fájlban adatbázis beállítások megadása`
   3. `.env.testing adatbázis beállítások megadása` 

  ## Telepítés
  1. `composer install`
  2. `npm install`
  3. `npm run dev`
  4. `php artisan key:generate && php artisan key:generate --env=testing`  
  5. `php artisan migrate` 
  6. `php artisan migrate --env=testing`  

 ## Feature tesztek futtatása
`php artisan test`

 ## API dokumentáció
  -  /docs/api
  
