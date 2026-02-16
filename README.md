# QuickProject - Premium Lead Selling Marketplace

QuickProject is a modern, high-performance PHP/MySQL marketplace where curated business leads are sold to developers and agencies. It features a robust dual-payment system, a secure wallet for developers, and a real-time lead delivery architecture.

## 🚀 Key Features

- **Dual Payment System**: Choose between paying via **Razorpay** (UPI, Cards, Netbanking) or using your **Wallet Balance**.
- **Wallet Infrastructure**: Developers can maintain a balance, top up funds, and purchase leads with one-click deductions.
- **Lead Protection**: Lead contact details are cryptographically blurred until a purchase is successfully verified.
- **Admin Command Center**: Complete lead management, transaction tracking, and user oversight.
- **Responsive & Premium UI**: A modern, mobile-first design built with clean CSS and dynamic PHP.

## 🛠️ Technology Stack

- **Backend**: PHP 8.x
- **Database**: MySQL (MariaDB)
- **Payment Gateway**: Razorpay API Integration
- **Frontend**: HTML5, Vanilla CSS3, JavaScript (ES6+)
- **Server**: Optimized for XAMPP/Apache environments

## 📦 Installation & Setup

1. **Clone the repository**:

   ```bash
   git clone https://github.com/rohitk2004/Leads-sale.git
   ```

2. **Database Configuration**:
   - Create a database in phpMyAdmin (e.g., `lead_marketplace`).
   - Import the `database.sql` file provided in the repository.
   - Update `db.php` or `config.php` with your database credentials.

3. **Payment Setup**:
   - Access `config.php`.
   - Insert your Razorpay `KEY_ID` and `KEY_SECRET` from the [Razorpay Dashboard](https://dashboard.razorpay.com).

4. **Environment Check**:
   - Ensure the server has `PDO` and `cURL` extensions enabled in `php.ini`.

## 📂 Project Structure

- `/admin`: Management dashboard for lead curators.
- `/cart.php`: Multi-item lead selection and review.
- `/checkout.php`: Consolidated payment gateway selection.
- `/functions.php`: Core business logic and purchase handlers.
- `/razorpay_checkout_*.php`: Secure payment verification handlers.

## 🛡️ Security Features

- **Session Hardening**: Persistent login sessions with role-based access control.
- **Transaction Logging**: Every wallet deduction and Razorpay payment is recorded for audit trails.
- **Lead Isolation**: Sold leads remain exclusive to the purchaser to maintain high lead quality.

---

_Built with ❤️ for the Developer Community._
