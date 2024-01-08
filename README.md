# yanselmask/cment

## Description

`yanselmask/cment` is a content management system (CMS) based on FilamentPHP, designed to provide a flexible and user-friendly platform for managing and organizing digital content.

## Features

-   **FilamentPHP Integration**: Built on top of FilamentPHP, `yanselmask/cment` inherits the powerful features of the underlying framework, ensuring a robust and efficient foundation for your content management needs.

-   **User-Friendly Interface**: The CMS offers an intuitive and easy-to-use interface, allowing users to manage their content effortlessly.

## Installation

1. Install the package via git:

    ```shell
    git clone https://github.com/yanselmask/cment.git
    ```

2. Browse folder:

    ```shell
    cd ./cment
    ```

3. Rename the .env.example file:

    ```shell
    cp .env.example .env
    ```

4. Download the dependencies:

    ```shell
    composer install
    ```

5. Generate a key for the Laravel application:

    ```shell
    php artisan key:generate
    ```

6. Generate a symbolic link(optional):

    ```shell
    php artisan storage:link
    ```

7. Download node dependencies(optional):

    ```shell
    npm install && npm run dev ||  yarn && yarn dev
    ```

8. Done!

## Usage

**Cment** comes with several models and some configuration sections.
