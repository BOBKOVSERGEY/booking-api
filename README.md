# lesson 
https://laraveldaily.com/lesson/booking-api-laravel/facility-structure-show-property-details
# create alias
alias alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# first command
sail artisan migrate:refresh --seed

# token 
1|TOgt5E3JHPwRlQkBfoLBvfDsGA8uhlgiZcmJPwqi

php artisan make:seeder PermissionSeeder

https://laraveldaily.com/lesson/booking-api-laravel/profile-fields

# git 
https://github.com/LaravelDaily/Booking-Com-Simulation-Laravel/

Врачи и пациенты

#ssl
https://docs.boltcms.io/5.0/howto/curl-ca-certificates

#yandex geo
https://github.com/martinjack/laravel-yandex-geocoding

# goole geo 
https://github.com/LaravelDaily/Booking-Com-Simulation-Laravel/
sail composer require toin0u/geocoder-laravel -W
sail artisan vendor:publish --provider="Geocoder\Laravel\Providers\GeocoderService"

# create observer
sail artisan make:observer PropertyObserver --model=Property


# spatie
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# create factory
php artisan make:factory PropertyFactory --model=Property

# add column in table
php artisan make:migration add_apartment_type_size_to_apartments_table
