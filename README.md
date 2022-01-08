# UWDC 2022

## Setup
```
git clone https://github.com/YLPMF/UWDC2022.git
```

// Laravel
Copy .env.example file to .env and add your database configuration.
```
cd backend 
composer install
php artisan key:gen
php artisan migrate --seed
php artisan passport:install
php artisan optimize
```

// Vue
Copy .env.example file to .env and add change API url.
```
cd ../frontend
npm install
npm run build
```

The frontend is separated from the backend, so you will need to add this configuration to Apache.
Replace DocumentRoot, Alias and Directory with your paths.
```
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/UWDC2022/frontend/dist
        ErrorLog /error.log
        CustomLog /access.log combined

        Alias /backend /var/www/UWDC2022/backend/public

        <Directory /var/www/UWDC2022/backend>
                AllowOverride All
        </Directory>

        <Directory /var/www/UWDC2022/frontend/dist>
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>

</VirtualHost>
```