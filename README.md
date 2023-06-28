# Event Management API
Laravel Event Management API.
This project covers basic themes about API creation:
- creating models and seeders
- crud operations and validation
- creating API resources
- pagination
- optional relations
- authentication with Sanctum
- authorization with Policies and Gates
- notifications (email notification): creating console command, scheduling it and preparing queues for executing background process 

# How to
- To build the project, execute:
```docker-compose up --build -d```
- To execute composer commands:
```docker-compose run --rm composer [command]```
- To execute artisan commands:
```docker-compose run --rm artisan [command]```
- To use tinker:
```docker-compose run -it --rm artisan tinker```
