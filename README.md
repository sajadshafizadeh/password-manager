
### Installation & Getting started steps:

1. Download the project
2. Run `composer install`
3. Make a databased named "password_manager" manually
4. Setup the database credentials inside the `.env` file
5. Run `php artisan migrate`
6. Run `php artisan db:seed`
7. Run `php artisan key:generate`
8. Run `php artisan serve --port=8080`

Now, it would be available through: http://localhost=8080


Default user:
- Username: `test@test.com`
- Password: `1234560!`
- 
You can use the above user's credentials in the Login API to get a token for calling other APIs.