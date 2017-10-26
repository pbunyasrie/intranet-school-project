# Intranet School Project

## About
Allows user registration, uploading and downloading files, and searching contents of files.
In addition, it allows creation of projects to segment the files.

Built using the Laravel PHP framework.

## Requirements
* PHP 7+
* Java 1.7+
* [composer](https://getcomposer.org/)
* [tika](https://tika.apache.org/)
* [elasticsearch](https://www.elastic.co/products/elasticsearch)
* [tesseract](https://github.com/tesseract-ocr/tesseract)

## Installing
Assuming all of the requirements are installed:

* ```git clone https://github.com/pbunyasrie/intranet-school-project```
* ```composer install```
* ```cp .env.example .env```
* Configure your APP and DB settings in .env
* ```php artisan key:generate```
* ```php artisan elastic:create-index "\App\FileIndexConfigurator"``` - this creates the Elasticsearch indices
* ```php artisan migrate:refresh --seed```
* ```php artisan elastic:update-mapping App\\File``` - this maps the models (File in this case) to Elasticsearch


## Development
If you are using MacOS, you can use homebrew to easily install all of the requirements for a quick development environment:

* [PHP/MySQL/Nginx](https://laravel.com/docs/5.5/valet#installation)
* brew cask install java
* brew install tika
* brew install tesseract
* brew install elasticsearch

Then make sure Elasticsearch is started:

* brew services start elasticsearch

### Vagrant
* [Install Vagrant](https://www.vagrantup.com/docs/installation/)
* Copy .env.example to .env (don't change the database settings)
* vagrant plugin install vagrant-vbguest
* vagrant up
