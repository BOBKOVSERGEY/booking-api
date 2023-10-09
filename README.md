# lesson 
error https://laraveldaily.com/lesson/booking-api-laravel/filter-properties-most-popular-facilities

https://laraveldaily.com/lesson/booking-api-laravel/ratings-ordering-search-results

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

# миграция многои ко многим
php artisan make:migration create_apartment_facility_table

#eloquent-eager-limit
https://github.com/staudenmeir/eloquent-eager-limit


# laravel-medialibrary

https://github.com/spatie/laravel-medialibrary

# change position https://spatie.be/docs/laravel-medialibrary/v10/advanced-usage/ordering-media

composer require "spatie/laravel-medialibrary:^10.0.0"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
