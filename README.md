# Copy .env.example 
## cp .env.example .env

#run commands:
###docker-compose up -d
###docker exec -it homework bash

#Need to install application dependencies
##Composer install

# System should be run by follow command: 
### php artisan calculate:commission input.csv     

## To initiate system's tests 
### vendor/bin/phpunit      

## Short description of functionality
### Added code base with flexible,extending approach code cover by cs-fixer to keep it more strictly
### I took latest rates for each transaction it means that if transaction was made in 2016 anyway rate will be taken
### on day of a running script. need to change logic of exchange little bit to take rate in day of a transaction.
