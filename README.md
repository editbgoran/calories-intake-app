Instructions on how to install the project locally:

Clone the repository:

git clone https://github.com/editbgoran/calories-intake-app.git

Switch to the repo folder:

cd calories-intake-app

Install all the dependencies using composer:

composer install

Create .env file, copy content from .env.example and paste it to .env,then make the required configuration changes in the .env file

Generate a new application key

php artisan key:generate

Run the database migrations (Set the database connection in .env before migrating)

php artisan migrate

Start the local development server

php artisan serve

Run the database seeder and you're done

php artisan db:seed
It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

php artisan migrate:refresh
