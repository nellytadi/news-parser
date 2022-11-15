# news-parser
1. Set Up   
2. Clone the repository ```git clone https://github.com/nellytadi/news-parser.git```


    1) Build Docker

$ docker-compose build

    2) Start the Docker

$ docker-compose up -d

    3) Install external packaged

$ docker exec -it -u www-data  sf5_php php /usr/local/bin/composer install -d /home/wwwroot/sf5

    5) Generate database schema

$ docker exec -it -u www-data  sf5_php php  /home/wwwroot/sf5/bin/console d:s:u --dump-sql

    6) Create database schema

$ docker exec -it -u www-data  sf5_php php  /home/wwwroot/sf5/bin/console d:s:u --force

    7) Migration Script

$ docker exec -it -u www-data  sf5_php php  /home/wwwroot/sf5/bin/console d:m:m

    8) Yarn script

$ docker exec -it -u www-data  sf5_php  yarn

$ docker exec -it -u www-data  sf5_php  yarn encore dev

    9) Execute below command to enable symfony to read Messages from rabitMQ

$ docker exec -it -u www-data  sf5_php  php bin/console messenger:consume &

    9) ADD Below in your host file

$ 127.0.0.1 test.local

    10) Docker Stop

$ docker-compose stop




### Login Credentials     
Moderator     
email: moderator@example.com    
password: 123456    
    
Admin     
email: admin@example.com     
password: 123456      
