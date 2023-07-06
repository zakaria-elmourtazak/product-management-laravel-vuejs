# Product Management Web Application

This is a web application built using Laravel and Vue.js that allows users to store and manage their products effectively.

## Features

1. **User Authentication and Authorization:** Users can create an account, log in, and manage their products securely. Authorization ensures that only authorized users can perform specific actions.

2. **Product Management:** Users can easily add, edit, and delete products with various details such as name, description, and size. This functionality enables users to keep track of their inventory efficiently.

3. **Product Listing with Search and Pagination:** The application provides a user-friendly interface to display a list of products. Users can search for specific products using keywords and navigate through the list with pagination functionality.

4. **Basic Validation:** The application implements basic form validation to ensure that required product fields are filled out. This helps maintain data integrity and provides a smooth user experience.

5. **Product Filtering:** Users have the ability to filter products based on specific criteria such as name, type, or any other relevant attributes. This feature allows users to quickly find products that meet their specific requirements.

## Getting Started

To run the application locally, follow these steps:

1. Clone the repository:
 `git clone https://github.com/your-username/product-management.git`
2. Install dependencies:
`cd product-management`
`composer install`
`npm install`
3. Configure the environment:
- Rename the `.env.example` file to `.env`.
- Set up your database configuration in the `.env` file.
4. Generate the application key:
 `php artisan key:generate`
5. Migrate the database and run seeders:
 `php artisan migrate --seed`
This will create the necessary tables in the database and populate them with sample data using seeders.

6. Compile the assets:
 `npm run dev`
7. Start the development server:
 `php artisan serve`
8. Access the application in your browser at `http://localhost:8000`.

## Dependencies

The following dependencies were used in this project:

- Laravel (version 8)
- Vue.js (version 3)
