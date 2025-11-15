# Invoices App

Invoices App is a simple and efficient web application designed for managing invoices in an organized way. The system allows you to manage clients, products, and carts, enabling you to add products to a cart and generate invoices easily. It provides a clear interface for creating, viewing, updating, and deleting invoices, all built with Laravel to ensure strong performance, clean structure, and easy scalability.

## tecnices
- Authentication: register, login, logout
- Validation: email and password
- Password Security: hashed passwords
- Email Verification: using Gmail
- Clients Management: CRUD operations on invoices, carts, and products
- Multiple Clients: a user can create and manage multiple clients
- User Scope: users can only access invoices, carts, and clients they created
- Soft Delete: safely remove records without permanent deletion
- PDF Generation: export invoices as PDF by use jsPDF

## Install

To install follow these steps

``` 
git clone https://github.com/Eng-Ahmed-Mostafa/invoices.git
cd invoices
composer install
npm install && npm run dev
php artisan key:generate
cp .env.example .env
php artisan migrate
```

You should copy the following variables into your `.env` file to enable mail services:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

To run app 

```
php artisan serve
```
