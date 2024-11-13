# Instructions:
- install docker if it is not already installed
- pull this repository from Bitbucket
- edit the .env in the symfony project as following:
    - ```DATABASE_URL=mysql://root:secret@mysql:3306/wordpress``` - this tells symfony how to connect with the databse
- open up a terminal and run the following commands inside your folder:
    - ```SSH_PRIVATE_KEY="$(cat ~/.ssh/id_rsa)" docker-compose up -d``` - this command pulls the docker images from hub.docker.com and runs the docker containers
    - ```docker exec -it php bash``` - this command puts us into the php docker container
    - ```cd /var/www/html/www.facelandclinic.com.devbox``` - this is the folder where our project is mounted to
    - ```exit``` - this command puts us out of the php docker container
- put ```127.0.0.1 www.facelandclinic.com.devbox``` into the hosts folder on your pc
- go to the following urls:
  - ```www.facelandclinic.com.devbox``` - for the Wordpress project
  - ```localhost:8080``` - for phpmyadmin

# Instructions for Windows (Windows 10)
Create two files:

- "dockerup.bat"
- "dockerup.ps1"

In "dockerup.bat" put the following:
```
Powershell.exe -ExecutionPolicy remotesigned -File dockerup.ps1
```
And in "dockerup.ps1" put:
```
cd C:\Your\Path\To\FollowApp
$env:SSH_PRIVATE_KEY=cat "C:\Your\Path\To\Your\SSH\Private\Key\OpenSSH\Formatted" -Delimiter "\n"
docker-compose up -d
```

Start `cmd.exe`, go to the place you stored dockerup.bat and run `dockerup`.