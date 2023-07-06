
### Laravel Wallet API: User Registration, Deposits, and Goodie Purchases

The project is an API-based application built using the Laravel framework. It allows users to register an account, which automatically opens a wallet for them. Users can deposit money into their wallet and use the available balance to purchase goodies. Each goodie costs 1 dollar. 

There are specific constraints for depositing money into the wallet. The minimum deposit amount is 3 dollars, while the maximum deposit amount is 100 dollars. Users can manage their wallet balance by depositing or withdrawing money as needed.

Overall, this Laravel-based project provides a user-friendly interface for registration, wallet management, and purchasing goodies using the funds available in the wallet.

## PostMan API Collection

[Postman API Collection](https://github.com/saurabhshukla-developer/laravel-wallet/blob/master/docs/postman_collection.json)

## Video Demo

[Video Demo Of API](https://github.com/saurabhshukla-developer/laravel-wallet/blob/master/docs/userwallet_video_demo.mov)

## Installation

To install this project, please follow the steps below:

- Clone the repository by running the following command in your terminal:

```bash
git clone https://github.com/saurabhshukla-developer/laravel-wallet.git
```

- Navigate to the root directory of the project and install the Laravel dependencies using Composer. Run the following command:

```bash
composer install
```

- Run Laravel Server

```bash
php artisan serve
```

- Create a copy of the `.env.example` file and rename it to `.env`. This file contains the configuration settings for your project.

-  Set up a database for the project and update the necessary database details in the `.env` file, including the database name, username, password, and host.

-  You're all set! Now you can use Postman or any other API testing tool to run the project's APIs and explore its functionality.

Please note that the installation process assumes you have PHP and Composer already installed on your machine. If not, please make sure to install them before proceeding.
## API Reference

#### Register a New User

```http
  POST /api/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required**. Your Name |
| `email` | `string` | **Required**. Your Email ID |
| `password` | `string` | **Required**. Your Password To Login |

- Sample Payload 

```
{
  "name": "Saurabh Shukla",
  "email": "saurabhshukla.developer@gmail.com",
  "password": "password123"
}
```

- Sample Response
```
{
    "message": "User registered successfully"
}
```

#### Login User

```http
  POST /api/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email` | `string` | **Required**. Your Email ID |
| `password` | `string` | **Required**. Your Password To Login |

- Sample Payload 

```
{
  "email": "saurabhshukla.developer@gmail.com",
  "password": "password123"
}
```

- Sample Response
```
{
    "token": "6|38ibSe4GBcVxwrqdgYQELeysEPoGY1mEhHeliAJF"
}
```

#### Deposite Balance

```http
  POST /api/deposit
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `deposit_amount` | `number till two decimal value` | **Required**. Deposite Amount In Dollar |

**Note** - Deposite amount should not be less than $3 and greater than $100.

- Sample Payload 

```
{
    "deposit_amount":10
}
```

- Sample Response
```
{
    "message": "Deposited $10 Successfully, Your wallet balance is $119.99"
}
```

#### Buy Cookie

```http
  POST /api/buy-cookie
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `quantity` | `numeric` | **Required**. Number Of Cookie You wanted to buy |

- Sample Payload 

```
{
    "quantity":5
}
```

- Sample Response
```
{
    "message": "Cookie(s) bought successfully"
}
```

#### Check wallet Balance

```http
  GET /api/check-balance
```

- Sample Response
```
{
    "message": "Your wallet balance is $109.99"
}
```


### Note
```
- Do not forgot to add 
Accept:application/json 
in the header to get proper response
- except login and registration all other api need authentication token. which you can pass in header as bearer token
```

