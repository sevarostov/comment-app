## REST API for comment app

## Technical Requirements
[Git](https://git-scm.com)
[Docker](https://www.docker.com)
[Docker Compose](https://docs.docker.com/compose/)

## Settings & Installation

### 1. Cloning repo

   ```sh
   git clone git@github.com:sevarostov/comment-app.git
   ```

### 2. Copying env file

  ```sh
  scp .env.example .env
  ```

### 3. Building project with docker

  ```sh
  docker build -t php:latest --file ./docker/Dockerfile --target php ./docker
  docker compose up -d
  composer install
  ```

### 4. Running migrations

  ```sh
  docker exec php php artisan migrate
  ```

## 5. Seeding test data

  ```sh
  docker exec php php artisan db:seed DatabaseSeeder NewsSeeder VideoPostSeeder
  docker exec php php artisan db:seed CommentSeeder
  ```

