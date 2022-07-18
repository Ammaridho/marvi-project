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


make sure relation all relation table:
exmp. merchant.id=1  product.merchant_id=1

---
Lodi@2022
