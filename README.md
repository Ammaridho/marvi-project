## RV Admin

RV project is a small application that accept order, this is its administrative app. 


### After clone

    $ composer install
    $ php artisan key:generate
    $ php artisan migrate
    $ php artisan db:seed
    $ npm install
    $ npm run prod

For speedier frontend compilation you can run:

    $ npm run dev

For storage link in public folder:

    $ php artisan storage:link

create keys passport:

    $ php artisan passport:keys --force
    $ php artisan passport:client --personal --no-interaction

---
Lodi@2022
