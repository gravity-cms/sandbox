Gravity CMS Sonata Sandbox
==========================

This project is a concept CMS, extending the Sonata CMS to provide pre-defined field types.

Installation
------------
Gravity uses PHP >= 5.5, MySQL, Ruby and Node.

Install Ruby and Node dependencies:
```bash
sudo npm install
bundle install --binstubs
```

Install PHP Dependencies:
```bash
composer install
```

Generate database schema:
```bash
./app/console doctrine:database:create
./app/console doctrine:schema:create
```

Generate the assets:
```bash
./app/console assetic:dump
```

Finally, create an admin user:
```bash
./app/console fos:user:create --super-admin
```

Now you're ready! Browse to `/admin/dashboard` and log in!
