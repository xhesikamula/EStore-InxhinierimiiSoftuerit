# EStore

## Project Overview
EStore is a dynamic eCommerce shopping cart application built with PHP and MySQL. The platform delivers a smooth and intuitive online shopping experience for users, allowing them to browse products, add items to their cart, and complete purchases with ease. On the admin side, it provides robust tools for managing products, orders, inventory, and user accounts — all through a clean and functional interface. This project serves as a practical implementation of core eCommerce features and backend management.

## Features
### Functional Requirements
- **User Registration & Authentication**: Customers, suppliers, and admins can create accounts and log in securely.
- **Product Catalog**: Products are categorized with detailed descriptions, images, and prices.
- **Shopping Cart Functionality**: Users can add, modify, and remove items from their cart.
- **Order Processing & Payments**: Secure checkout process with multiple payment options.
- **Order Tracking**: Users can monitor the status of their orders.
- **Admin Dashboard**: Admins can manage users, products, and orders.

### Non-Functional Requirements
- **Performance**: The website loads quickly and operates efficiently.
- **Security**: User data and transactions are secured with encryption.
- **Usability**: The interface is user-friendly and accessible.
- **Responsiveness**: The site is optimized for desktop and mobile devices.
- **Compatibility**: The site supports multiple browsers and platforms.
- **Compliance**: Follows relevant legal and regulatory standards.

## Technical Details
- **Frontend**: HTML, CSS (Responsive Design)
- **Backend**: PHP
- **Database**: mySQL
- **Version Control**: Git & GitHub

## 🚀 Installation & Setup

1. **Clone the repository**  
   ```sh
   git clone https://github.com/xhesikamula/EStore-InxhinierimiiSoftuerit.git
   ```
2. Navigate to the project directory:
   ```sh
   cd EStore-InxhinierimiiSoftuerit
   ```
3. Install PHP dependencies
   ```sh
   composer install
   ```
4. Start the built-in PHP server
   ```sh
   php -S localhost:8000
   ```
5. Open your browser and go to:
   ```sh
   http://localhost:8000


⚙️ Configuration
Before running the app, open
classes/Database.php
and on the new mysqli(...) line, replace the empty password ('') with your own phpMyAdmin/MySQL password. For example:
$this->connection = new mysqli('127.0.0.1', 'root', 'YOUR_PMA_PASSWORD', 'estore', 3306);
Save the file, restart your PHP server if needed, and you’re all set!


   

## Usage
- **Users**: Browse products, add items to the cart, and complete purchases.
- **Admins**: Manage products, users, and orders from the admin panel.

## Diagrams & Documentation
- **Use Case Diagrams**
- **ER Diagram**
- **Sequence Diagrams**
- **System Architecture**

## Contributors
- **Elma Ejupi**
- **Xhesika Mula**


## References
- [Ecommerce4All](https://ecommerce4all-ks.com/module/regulation/laws/)
- [Software Engineering Essentials](https://books.google.al/books/about/Essentials_of_Software_Engineering.html)
- [EdrawMax - Microservices Architecture](https://www.edrawsoft.com/article/microservices-architecture-diagram.html)

---
### Notes
This project was developed as part of a university assignment for the **Software Engineering** course at the **University of Prishtina, Faculty of Mathematical-Natural Sciences, Department of Computer Science**.

