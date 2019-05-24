## EShop Laravel
Shop created on Laravel 5.8 
Creating orders is available only to registered users, the guest can only browse the catalog.
The admin has full access to the admin panel, only the order list is available to the order manager.

## Installation

```
composer install
Import database
Fill .env config values (app, db, mail, facebook, twitter)
Change permissions to storage folder
php artisan config:cache
composer dump-autoload
```

## Admin panel
Admin test values
```
login test2@mail.ru
password 12345678
```


```
{site url}/admin/ # Admin index page

{site url}/admin/order # Show all orders
{site url}/admin/order/edit/{orderId} # Update an existing order

{site url}/admin/user # Show all users
{site url}/admin/user/add/ # Create a new user
{site url}/admin/user/edit/{userId} # Update an existing user
{site url}/admin/user/delete/{userId} # Delete user

{site url}/admin/category # Show all categories
{site url}/admin/category/add/ # Create a new category
{site url}/admin/category/edit/{categoryId} # Update an existing category
{site url}/admin/category/delete/{categoryId} # Delete category

{site url}/admin/product # Show all products
{site url}/admin/product/add/ # Create a new product
{site url}/admin/product/edit/{productId} # Update an existing product
{site url}/admin/product/delete/{productId} # Delete product

```