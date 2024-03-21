



markdown
# Hotel Search API

This is a RESTful API built using Laravel to search and sort hotels based on various criteria.

## Requirements
```````````````````````
- PHP >= 8.x
- Laravel framework
- Composer

## Installation

1. Clone the repository:

   ```````````````````````
   git clone https://github.com/AHMED7SERAG/hotels.git

   ```````````````````````
Navigate to the project directory:



cd hotels
Install dependencies:


```````````````````````
composer install
```````````````````````
Usage
Fetch Hotels
To fetch hotels, send a GET request to the /hotels endpoint.
```````````````````````
Search Hotels
To search for hotels, send a GET request to the /hotels/search endpoint with the following query parameters:

name: Search by hotel name
city: Search by destination city
price_range: Search by price range (format: as ann array [10,15])
date_range: Search by date range (format:an array [2023-10-10,2023-10-15])
Example:



GET /hotels/search?name=Le%20Meridien&city=london
Sort Hotels
To sort hotels, send a GET request to the /hotels/sort endpoint with the following query parameter:

sort_by: Sort by hotel name or price
Example:



GET /hotels/sort?sort_by=name


GET /hotels/sort?sort_by=price
Testing
To run tests, execute:


`````
php artisan test

`````
Notes
Hotel data is fetched from a JSON object stored within the controller.
This project does not use a database or external services for hotel data.
Ensure to provide valid query parameters for searching and sorting.
