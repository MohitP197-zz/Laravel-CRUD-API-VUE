This is the Laravel 5.7.27 API CRUD application. 

There are no view files in this project. I built this application using Postman.

To run the project:

a. Clone the project into your local directory.

b. Create a new .env file inside your project folder and copy the content of .env.example to the newly created .env file.

c. Create a database in MySql and edit the database name from Homestead tp your database name.

d. Run composer install to install the dependencies.

e. Run composer update to update the dependencies.

f. Run php artisan key:generate to generate the unique key for your application.

g. Add Schema::defaultStringLength('191'); to your boot function inside app>Providers>AppServiceProviders and also include the Schema in      the top part.

h. Run php artisan serve to run the system locally.
