# Docker-Laravel

## Setting up

##### 0 Environments info
Set the ```DB_HOST``` from ```.env``` to the mysql service name (currently ```db```, so ```DB_HOST=db```).

Add this new line ```127.0.0.1 redtutorial.local``` to ```/etc/hosts``` file on you machine.

##### 1 Start the services
Run the commands inside the root folder of your Laravel project

```
docker-compose build
docker-compose up -d
```

##### 2 Wait...
A temporary ```initial-script-progress.txt``` file will be created, wait until it's automatically deleted before using the services.

First time when booting up the services it will take longer.

## Client side usage
Go in the browser to [http://redtutorial.local](http://redtutorial.local) to view the app.

Go in the browser to [http://localhost:7001](http://localhost:7001) to check the database in phpmyadmin (currently the phpmyadmin service uses the 7001 port).

# App Screenshots

![Screenshot](public/readme_files/admin-dashboard.png)
![Screenshot](public/readme_files/client-homepage.png)
![Screenshot](public/readme_files/client-tutorial.png)
![Screenshot](public/readme_files/client-tutorial2.png)

##### Enjoy by Eduard Robu!
