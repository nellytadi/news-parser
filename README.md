# news-parser Set Up   
1. Clone the repository

```git clone https://github.com/nellytadi/news-parser.git```
2. Change Directory
        cd news-parser

3. Build Docker

        $ docker-compose build

4. Start the Docker

        $ docker-compose up -d

5. Install external packaged

        $ docker exec -it -u www-data  sf5_php php /usr/local/bin/composer install -d /home/wwwroot/sf5

6. Generate database schema

        $ docker exec -it -u www-data  sf5_php php  /home/wwwroot/sf5/bin/console d:s:u --dump-sql

7. Create database schema

        $ docker exec -it -u www-data  sf5_php php  /home/wwwroot/sf5/bin/console d:s:u --force

8. Migration Script

        $ docker exec -it -u www-data  sf5_php php  /home/wwwroot/sf5/bin/console d:m:m

9. Yarn script

        $ docker exec -it -u www-data  sf5_php  yarn

        $ docker exec -it -u www-data  sf5_php  yarn encore dev

10. Execute below command to enable symfony to read Messages from rabitMQ

        $ docker exec -it -u www-data  sf5_php  php bin/console messenger:consume &

11. ADD Below in your host file

        $ 127.0.0.1 test.local

12. Docker Stop

        $ docker-compose stop




### Login Credentials     
#### Moderator     
    email: moderator@example.com    
    password: 123456    
    
#### Admin     
    email: admin@example.com     
    password: 123456      
