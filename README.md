## Price Listing System Documentation

- How to run the project.
- Code Structure.
- Database Structure.
- Why did I choose this solution?
- What can we do to get better performance (in case the application keeps growing)


## How to run the project

    Basic way (requires PHP > 8.2)
        - copy the .env.example and name it .env
        - composer install
        - run php artisan key:generate
        - composer install  
        - php artisan migrate

    Using docker
        - docker-compose build
        - docker-compose up
        - docker-compose exec laravel.test sh (to open the container terminal)
        - composer install
        - cp .env.example .env
        - php artisan key:generate
        - php artisan migrate
        - docker-compose restart

 ## Code structure
    The structure has 2 main folders
    domain (where all the business logic resides)
    src (containing the applications (users, admin...)) in this folder, 
    We only consume the business logic from the domain folders
    Each application has its own resource, requests to serve its needs

## Database structure
    The database structure is the same as the one in the test file you sent, with some small changes
    - The description for the product is in a separate table 
    (It contains a text (may be very big) column, we don't use it a lot, so no need to have it in the main product table)
    - In the price_lists table, we use the foreign key for country and currency instead of 3-character columns 
    (I will describe the purpose in detail in the next section)

## Why did I choose this solution
    Let's discuss all the possible solutions (based on the number of records in the product and product_lists table) 
    - small number of records, let's consider it 500K or less
        Every solution can fit in this range, so the best one will be 
        (less code, less time, fewer services and computing resources)
        using country_code and currency_code (consider using an index for each of them) in the price_list table,
        and take the user input and use it to search the table
        No additional joins with the countries and currencies table 
        The project will work without problems
        The search for an integer foreign is, of course, more efficient than the string search 
        (But we have only 3 chars, and with indexes, the difference is very low)
    - when the application starts to grow and the price_list becomes bigger
        The size of 3 char is 3 bytes, the size of a tiny integer is 1 byte 
        (We use a tiny integer because its max number is 255, because countries and currencies are less than 200)
        With a 100M record, the difference in size between the 2 tables will be 200 megabytes, 
        Also, the difference in speed between using an index char and a foreign integer will increase
        So we will start working on tiny integers as the foreign keys instead of the currency code
        We will face a small problem that the user input will still contain currency code and country code (not IDs)
        So if we do not want to search using codes, instead of integers, 
        We need to take the country code and get the country ID, and use it in the search
        We may have 2 more queries on each request (one for currency and the other for country)
        Because the number of countries and currencies is small, and they are barely changing
        We can cache these queries in Redis 
        (but we have to manage the Redis service and remember to clear the cache on each change to the cached data)
        
## What can we do to get better performance (in case the application keeps growing)
    If the price list keeps growing and the performance becomes slow
    - we can separate the price_lists table to have table for each product_id ({$productId}_price_lists)
    - We can move the old data after, like one year or 6 months, to another table and keep the newly created data
    (also prevent the user from using dates less than 6 months)


## Note
    We only consider what to do if the number of records becomes more
