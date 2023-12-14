# Laravel Web3 App

## Introduction
Welcome to the **Laravel Web3 App**! This simple laravel web3 allows you to send ERC20 token named tauseeds Token [TTN](https://sepolia.etherscan.io/token/0xdfd8be0510b140ab9c19f97154df12be445fee2f) to any auth User....
![Screenshot 2023-12-14 123759](https://github.com/tauseedzaman/laravel-web3/assets/64689921/732a113e-38fb-4dba-95d8-9c056042e5e8)

## Getting Started

### Prerequisites
To run this Laravel app, you need to have the following software installed on your machine:
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [MetaMask](https://metamask.io/)

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/tauseedzaman/laravel-web3.git
   ```
2. Change into the project directory:
    ```bash
    cd laravel-web3
    ```

3. Install PHP dependencies:
    ```bash
    composer install
    ```
4. Install JavaScript dependencies:
    ```bash
    npm install && npm run dev
    ```
5. Create a copy of the .env.example file and rename it to .env. Update the database and other configurations as needed.
6. Generate an application key:
    ```bash
    php artisan key:generate
    ```
7. Migrate the database:
    ```bash
    php artisan migrate
    ```
8. Configure the node-app/server.js accordingly

9. Serve the application:
    
    1. Run laravel Application
    
    ```bash
    php artisan serve
    ```

    2. Run the node API
    ```bash
    node node-app\server.js
    ```

10. Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser to view the app.

## Contributing
If you would like to contribute to this project feel free to do so...

## License
This project is licensed under the MIT License.

## Finally
Give a Start⭐ if you liked it ✌✌
