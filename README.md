# 🌿 Liverpool Community Cleanup Project

<p align="center">
  <img src="public/images/logo.svg" width="200" alt="Liverpool Cleanup Logo">
</p>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-v12.10.2-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel Version"></a>
  <a href="https://www.php.net"><img src="https://img.shields.io/badge/PHP-v8.3.9-777BB4?style=for-the-badge&logo=php" alt="PHP Version"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind-v3.0-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind"></a>
  <a href="https://stripe.com"><img src="https://img.shields.io/badge/Payments-Stripe-635BFF?style=for-the-badge&logo=stripe" alt="Stripe"></a>
</p>

## 🌊 About Liverpool Community Cleanup

Liverpool Community Cleanup is a web platform designed to connect volunteers, organize cleanup events, and collect donations to support environmental efforts in Liverpool. Our mission is to create cleaner, healthier neighborhoods and protect Liverpool's beautiful waterways and green spaces.

### ✨ Key Features

- **Interactive Cleanup Map**: Find and register for cleanup events in your neighborhood
- **Organizer Dashboard**: Create and manage cleanup initiatives
- **Volunteer Profiles**: Track your impact and contribution history
- **Secure Donation System**: Support the cause through one-time or recurring donations
- **Resource Management**: Track supplies and equipment for community cleanup efforts

## 📋 Requirements

- PHP 8.3+
- Composer 2.0+
- MySQL 8.0+ or PostgreSQL 15+
- Node.js & NPM for frontend assets
- Stripe account for payment processing

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/liverpool-cleanup.git
   cd liverpool-cleanup
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install frontend dependencies**
   ```bash
   npm install
   npm run dev
   ```

4. **Setup environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database in the .env file**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=liverpool_cleanup
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Configure Stripe keys in the .env file**
   ```
   STRIPE_KEY=your_publishable_key
   STRIPE_SECRET=your_secret_key
   ```

7. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## 📱 Usage

### 🌍 For Community Members

1. **Find Cleanup Events**
   Browse the interactive map to find cleanup events in your area

2. **Register for Events**
   Sign up to participate in upcoming cleanup initiatives

3. **Donate**
   Support our efforts with one-time or recurring donations that help fund supplies

### 👑 For Organizers

1. **Create Cleanup Events**
   Define location, date, time, and required resources

2. **Manage Volunteers**
   Track participant signups and send updates

3. **Track Supplies**
   Manage inventory and request additional resources

## 🧪 Testing

Run the automated tests with:

```bash
php artisan test
```

## 🛣️ Roadmap

- Mobile app development
- Gamification features for volunteers
- Integration with local council waste management
- Business sponsorship portal
- Environmental impact metrics

## 🤝 Contributing

Contributions are welcome! Please check out our [contribution guidelines](CONTRIBUTING.md) first.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/amazing-feature`)
3. Commit your Changes (`git commit -m 'Add some amazing feature'`)
4. Push to the Branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## ⚖️ License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 📞 Contact

Project Coordinator - [email@example.com](mailto:email@example.com)

Project Link: [https://github.com/yourusername/liverpool-cleanup](https://github.com/yourusername/liverpool-cleanup)

---

Built with ❤️ for a cleaner Liverpool
