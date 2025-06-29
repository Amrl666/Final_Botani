<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Botani Final

A Laravel-based e-commerce platform for agricultural products.

## Features

### Product Management
- **Dynamic Product Units**: Products now support various units (kg, gram, buah, ikat, pack, box, pcs)
- **Flexible Ordering**: Products can be ordered with custom minimum increments (e.g., 0.5 kg, 1 piece)
- **Stock Management**: Real-time stock tracking with unit-specific quantities
- **Featured Products**: Highlight special products on the homepage

### Order System
- **WhatsApp Integration**: Direct order placement via WhatsApp
- **Cart Management**: Add, update, and remove items from cart
- **Order History**: Track order status and history
- **Multiple Product Orders**: Order multiple products in a single transaction

### User Management
- **Authentication**: User registration and login
- **Profile Management**: Update user information and preferences
- **Order Tracking**: View order history and status

## Database Changes

### New Product Fields
- `unit`: Product unit (kg, gram, buah, ikat, pack, box, pcs)
- `min_increment`: Minimum quantity that can be ordered

### Migration
Run the following commands to apply database changes:

```bash
php artisan migrate
php artisan db:seed --class=UpdateProductsWithUnitsSeeder
```

## Product Units Supported

| Unit | Description | Example Use |
|------|-------------|-------------|
| kg | Kilogram | Rice, vegetables by weight |
| gram | Gram | Spices, small quantities |
| buah | Piece/Fruit | Individual fruits |
| ikat | Bundle | Vegetables tied together |
| pack | Pack | Packaged items |
| box | Box | Bulk items in boxes |
| pcs | Pieces | Individual items |

## Ordering Rules

- **Minimum Increment**: Each product has a minimum increment (e.g., 0.5 kg, 1 piece)
- **Quantity Validation**: Orders must be in multiples of the minimum increment
- **Stock Validation**: Cannot order more than available stock
- **Unit Display**: All prices and quantities display with appropriate units

## API Endpoints

### Products
- `GET /products` - List all products
- `POST /products` - Create new product
- `PUT /products/{id}` - Update product
- `DELETE /products/{id}` - Delete product

### Orders
- `POST /orders` - Create new order
- `GET /orders` - List orders (admin)
- `PUT /orders/{id}` - Update order status

### Cart
- `POST /cart/add` - Add item to cart
- `PUT /cart/{id}` - Update cart item
- `DELETE /cart/{id}` - Remove cart item
- `POST /cart/clear` - Clear cart

## Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Copy environment file: `cp .env.example .env`
4. Generate application key: `php artisan key:generate`
5. Configure database in `.env`
6. Run migrations: `php artisan migrate`
7. Seed database: `php artisan db:seed`
8. Start development server: `php artisan serve`

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.
