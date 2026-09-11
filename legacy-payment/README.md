# Legacy payment code (reference only)

These files are copied from the old `Leads-sale` project's Cashfree payment integration. They are **not wired up** to the new site — kept here for reference until we decide how/whether to reintegrate a store/checkout flow.

They depend on code that isn't in this project yet:
- `functions.php` — session/login helpers (`require_login()`), cart helpers (`get_cart_items()`)
- a database connection (`$pdo`) and cart/order tables
- `config.php` constants `CASHFREE_APP_ID` and `CASHFREE_SECRET_KEY`

**Do not commit real API keys.** The old repo had live production Cashfree/Razorpay secret keys hardcoded in `config.php` and pushed to GitHub — those keys should be rotated in the Cashfree/Razorpay dashboards. When we reconnect payments, keys go in a gitignored `.env`/`config.local.php`, never hardcoded.
