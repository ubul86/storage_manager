# Storage Manager PHP Native app

# Table of Contents

- [Minimum Requirements](#minimum-requirements)
- [Installation With Docker](#installation-with-docker)
- [Installation Without Docker](#installation-without-docker)
- [Testing and Analysis Tools](#testing-and-analysis-tools)
- [Running Tests](#running-tests)
- [Docker Installation](#docker-installation)
- [Docker Compose Installation](#docker-compose-installation)

## Minimum Requirements

- **With Docker:**
  - **Docker and Docker Compose**
- **Without Docker:**
  - **PHP**: 8.1 or higher
  - **Composer**: 2.0 or higher

## Docker Services

This project uses Docker to containerize the different components of the application. Below is a description of each service defined in the `docker-compose.yml` file:

- **nginx**: The Nginx service serves as a reverse proxy for the application, routing HTTP requests to the appropriate backend services.

- **php**: This service runs the PHP application using PHP 8.1. 

## Installation With Docker

First, need a fresh installation of Docker and Docker Compose

### 1. Clone the Project

Clone the repository to your local machine:

```bash
git clone https://github.com/ubul86/storage_manager.git
cd storage_manager
```

### 2. Copy Environment File And Set The ENV variables

Copy the .env.example file to .env

```bash
cp .env.example .env
```

### 3. Build The Containers

Go to the project root directory, where is the docker-compose.yml file and add the following command:

```bash
docker-compose up -d --build
```

### 4. Install Dependencies:

Install PHP dependencies using Composer:

```bash
docker exec -it {php_fpm_container_name} composer install
```

or
```bash
docker exec -it {php_fpm_container_name} bash
composer install
```

The application should now be accessible at http://localhost:{NGINX_PORT}.


## Installation Without Docker

### 1. Clone the Project

Clone the repository to your local machine:

```bash
git clone https://github.com/ubul86/storage_manager.git
cd storage_manager
```

### 2. Install Dependencies

Install PHP dependencies using Composer:

```bash
composer install
```

### 3. Start the Development Server

Run a PHP Development Server

```bash
php -S localhost:8080
```

The application should now be accessible at http://localhost:8080.

## Testing and Analysis Tools

### PHP CodeSniffer (PHPCS)

PHPCS is used to check coding standards and style violations.

```bash
composer lint
```

or

```bash
docker exec -it {php_fpm_container} composer lint
```

### PHPStan

PHPStan is used for static code analysis to find bugs and improve code quality.

Run PHPStan:

```bash
composer analyse
```

or

```bash
docker exec -it {php_fpm_container} composer analyse
```

## Running Tests

### PHPUnit

Unit tests are written using PHPUnit. 

- Run the tests:
```bash
composer test
```

or

```bash
docker exec -it {php_fpm_container} composer test
```

This will execute all tests in the tests directory and provide a summary of test results.

## Docker Installation

### Linux

- Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04
- For Linux Mint: https://computingforgeeks.com/install-docker-and-docker-compose-on-linux-mint-19/

### Windows

- https://docs.docker.com/desktop/windows/install/

## Docker Compose Installation

### Linux

https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04

### Windows
- Docker automatically installs Docker Compose.