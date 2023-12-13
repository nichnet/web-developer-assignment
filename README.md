# Web Dev Assignment
![Demo](https://github.com/nichnet/web-developer-assignment/blob/main/images/screenshot.png)

## Requirements 
Ensure that [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) are installed on your system. 

If you wish to install [Docker Desktop](https://docs.docker.com/desktop/) instead, then Compose will already be bundled with it.

## Setup
- Clone the repository
- Start the containers by running `docker-compose up -d` in the project root
- Install the composer packages by running `docker-compose exec laravel composer install`
- Populate the database with the required tables by running the migrations command `docker exec -it assignment01-laravel php artisan migrate`
- Access the Laravel instance on `http://localhost` (If there is a "Permission denied" error, run `docker-compose exec laravel chown -R www-data storage`)

### Persistent Database
If you want to make sure that the data in the database persists even if the database container is deleted, add a file named `docker-compose.override.yml` in the project root with the following contents:
```yml
version: "3.7"

services:
  mysql:
    volumes:
    - mysql:/var/lib/mysql

volumes:
  mysql:
```
Then run the following command: 
`docker-compose stop \ && docker-compose rm -f mysql \ && docker-compose up -d`

## Testing
Run the unit tests by running `docker exec -it assignment01-laravel php ./vendor/bin/phpunit tests`

Tests include:
- Add a book
- Delete a book
- Update a book
- Sorting by title or author
- Searching for a book or title
- Exporting as CSV or XML

## Features
- Add, edit, and delete a book from the list
-	Sort by title or author
-	Search for a book by title or author
-	Export the the following in CSV and XML
    - A list with Title and Author
    - A list with only Titles
    - A list with only Authors

## Hosting Architecture
I am hosting the demo on AWS. An ideal architecture diagram would be as follows:
![AWS Architecture](https://github.com/nichnet/web-developer-assignment/blob/main/images/architecture.png)
