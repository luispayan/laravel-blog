## Getting started

```bash
# Clone this repository
git clone git@github.com:luispayan/laravel-blog.git

# Go into the repo
cd laravel-blog

# Create your .env file from template
cp .env.template .env

# Install Laravel Dependencies
composer install

# Install Javascript Dependencies
npm install | yarn install

# Run migrations : You need to have already created the database in mysql
php artisan migrate

# Compile assets for dev
npm run watch | yarn watch

# Run Laravel server
php artisan serve

Then you can navigate to localhost:8000 to see the blog post
```

## Testing

Run unit test with following command:

```bash
./vendor/phpunit/phpunit/phpunit
```

## Usage

You have available the following params to Comments API

```bash
take -> An integer with the amount of comments that you need want to get
skip -> An integer with the amount of comments that will be skiped
sort -> A string, asc for ascending and desc for descending
```