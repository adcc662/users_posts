# Users Post API

This project is designed to provide a RESTful API for create and list users and their posts using tymon/jwt-auth for authentication.

## Technologies Used

- **Laravel**: A web application framework with expressive, elegant syntax. I believe development must be an enjoyable and creative experience to be truly fulfilling.
- **PostgresSQL**: A powerful, open-source object-relational database system.
- **Docker**: A platform for developing, shipping, and running applications in containers.

## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

- Docker

1. Clone the repository
   ```sh
   git clone git@github.com:adcc662/users_posts.git
   ```

2. Enter the project directory
   ```sh
   cd users_posts
   ```

3. Run the migrations and then start the server
   ```sh
   cp .env.example .env
   docker-compose up
   docker exec -it users_posts-php-1 chmod -R 777 storage/
   docker exec -it users_posts-php-1 php artisan config:cache
   docker exec -it users_posts-php-1 php artisan migrate
   ```

4. The API should now be available at `http://localhost:8080/`

## Usage
You can find the API documentation in the following Postman Collection file that you can import to your Postman app:
[Postman Collection](Blog-Laravel.postman_collection.json)

Note: You need to use Bearer Token when you register one user and then login to get the token. You have two tokens when you register a user, you copy the registration token and paste it in login.
