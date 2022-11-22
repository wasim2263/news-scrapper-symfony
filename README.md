# news-scrapper-symfony
 - Run the project using ```docker compose up -d```
 - Prepare database ```docker-compose exec app php bin/console doctrine:schema:update --force``` 
 - Run seeder ```docker-compose exec app php bin/console doctrine:fixtures:load```
 - Check the server: ```http://localhost:8000/```  
   - Credentials: user:```admin```,  Password:`pass_1234`
   - Credentials: user:```moderator```,  Password:`pass_1234`
 - Check the rabbitmq server: ```http://localhost:15672/```
 - Scraper is not modified to handle from different sources yet. Need to modify the code and the settings to make it full functional 
 - Admin module: ```http://localhost:8000/admin```
