AutoLux - Final Backend Assignment (PHP)
=======================================

Student: Jordan
PHP repository: https://github.com/ShirokiHana/AutoLux
Node.js API repository: https://github.com/ShirokiHana/Node

1. Overview
-----------

AutoLux is a web application for an automotive parts warehouse. PHP renders
the management pages and handles customers, the parts catalogue, stock and
sales. A separate Node.js HTTP API manages suppliers and supplier orders.

This is an educational project for local demonstration. Payment forms
validate example details only: no payment gateway is contacted and no real
payments are processed. Use fictional information when trying the application.

2. Implemented features
-----------------------

- Database-backed parts catalogue with pagination, brand or part-type
  filtering, and a maximum-price filter.
- Customer selection through a dropdown and registration of new customers.
- Sales cart containing part information and quantities.
- VISA, MasterCard and MB WAY payment selection, each with its own form
  and validation.
- Transactional sales creation and stock deduction.
- Sales history, order details and installation-status updates.
- Customer listing, editing and deletion, with deletion restricted when
  a customer has recorded sales.
- Supplier listing and creation through the Node.js API.
- Supplier-specific restock carts, order submission through the API,
  local stock updates and supplier-order status synchronization.

3. Architecture and data source
-------------------------------

PHP -> autolux_db (MySQL):
  Customers, parts/stock, sales, payment methods and supplier-order sync records.

PHP -> Node.js HTTP API -> supplier_db (MySQL):
  Suppliers, their parts catalogue, supplier orders and order items.

The data source is the supplied MySQL demonstration data in autolux_db and
supplier_db. The A/B/C classification mentioned in the assignment brief is
awaiting clarification from the teacher.

Matching parts in both databases share the same part_id and represent the
same product. Keep these identifiers aligned when changing the sample data.

4. Requirements
---------------

- PHP 8.5 or later: the code uses the pipe operator (|>).
- PHP extensions: PDO, pdo_mysql and cURL; PHP sessions must be enabled.
- Composer.
- A running MySQL server and a MySQL account allowed to create/import the
  demonstration databases.
- Node.js and NPM for the companion API. Development used Node.js 22.
- Git and a browser with JavaScript and cookies enabled.

The terminal commands below use a macOS/Linux shell. On Windows, use the
equivalent file-copy commands or copy the environment files manually.

5. Download and install
-----------------------

Clone both repositories into the same parent directory:

  git clone https://github.com/ShirokiHana/AutoLux.git
  git clone https://github.com/ShirokiHana/Node.git

Install the PHP dependencies:

  cd AutoLux
  composer install
  cp db.env.example db.env

Install the Node.js dependencies in a second terminal, from the Node folder:

  npm install
  cp db.env.example db.env

Both repositories are required for the complete application.

6. Import the demonstration databases
-------------------------------------

The exports include table definitions and sample data:

  AutoLux/schema/autolux_db.sql
  Node/schema/supplier_db.sql

They do not create or select the database automatically. With MySQL running,
execute the following from the PHP repository's root directory (AutoLux).
Replace root with your MySQL username if different; -p prompts for its password.
If the account has no password, press Enter at the prompt.

  mysql -h 127.0.0.1 -P 3306 -u root -p -e "CREATE DATABASE IF NOT EXISTS autolux_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE DATABASE IF NOT EXISTS supplier_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
  mysql -h 127.0.0.1 -P 3306 -u root -p autolux_db < schema/autolux_db.sql
  mysql -h 127.0.0.1 -P 3306 -u root -p supplier_db < ../Node/schema/supplier_db.sql

WARNING: The exports contain DROP TABLE statements. Import only into
demonstration databases: existing tables and their contents will be replaced.
composer install and npm install do not create database tables.

autolux_db tables:
  clients, parts, orders, order_items, payment_methods, supplier_order_sync.

supplier_db tables:
  suppliers, parts, supplier_orders, supplier_order_items.

7. Configure the database connections
-------------------------------------

Edit AutoLux/db.env with your local connection details:

  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_USER=root
  DB_PASSWORD=
  DB_NAME=autolux_db
  NODE_URL=http://localhost:3030

Edit Node/db.env separately:

  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_USER=root
  DB_PASSWORD=
  DB_NAME=supplier_db

Set DB_PASSWORD to the account's password, or leave it empty if there is none.
Replace all example values as needed. In particular, replace the NODE_URL
port placeholder in the PHP example file with 3030.
Do not commit real database credentials.

8. Run the application
-----------------------

Start the Node.js API from the Node repository root:

  npm start

The API listens on port 3030. For automatic reload during development:

  npm run dev

In a separate terminal, start PHP from the AutoLux repository root:

  composer run dev

Alternatively, run the PHP development server directly:

  php -S localhost:3000 -t public public/index.php

Open http://localhost:3000 in your browser. Keep MySQL and both application
servers running. Stop each application server with Ctrl+C in its terminal.
The PHP built-in server is intended for local development and demonstration,
not production hosting.

Optional macOS/Homebrew MySQL service shortcuts, from AutoLux:

  composer run startMySQL
  composer run stopMySQL

These shortcuts are not needed if you manage MySQL another way.

9. Demonstration walkthrough
----------------------------

- /inventory: browse parts and try the brand/type and price filters.
- /order: select or create a customer, add parts and quantities to the cart,
  choose a payment method and submit a simulated sale.
- /admin: view recorded sales and open an order's details.
- /admin/clients: browse and manage customers.
- /admin/suppliers: list or create suppliers using the Node.js API.
- /management/order: choose a supplier, add parts to the restock cart and
  submit an order. The application updates local stock and marks the
  supplier order as received.

For an MB WAY demonstration, a nine-digit test value such as 900000001
satisfies the form's current format check. It is a placeholder only:
do not call or message it. No payment is sent.

10. Adding a payment method
---------------------------

Create a class in core/payment/ extending PaymentMethod and implement
renderForm(), validateForm() and getPaymentName(). Add the payment method
to autolux_db.payment_methods, then map its ID to the class in
core/payment/PaymentMethod.php.

The included database uses 1 = VISA, 2 = MasterCard and 3 = MB WAY.

11. Troubleshooting
--------------------

- Syntax error near "|>": check that the terminal uses PHP 8.5 or later.
- "could not find driver": enable/install the PHP pdo_mysql extension.
- Database connection failure: check MySQL, db.env, the port, credentials
  and database names.
- Missing table: import the SQL exports into the correct databases.
- Supplier service unavailable: start the Node.js API and check that
  NODE_URL is http://localhost:3030.
- Port already in use: stop the previous server instance before restarting.
- Empty supplier cart options: confirm the two catalogues contain matching
  part_id values and that the chosen supplier has parts.
