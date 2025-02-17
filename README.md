# Laravel project die servers pingt

## Installatie

### Kloon de repository

Kloon de repository met het volgende commando in de command prompt:

    git clone https://github.com/Stefan-Mars/Ping.git

### Composer

Ga naar de gekloonde map in de command prompt en voer het volgende commando uit:

    composer install
### Packages
Installeer deze packages

- NPM
    
- Python3
    
- Python3 Sql connector
    
- Python3 Dot ENV
    

### Omgeving instellen

Dupliceer het .env.example bestand en hernoem het naar .env. Pas de database-instellingen aan met je eigen gegevens:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=je_database_naam
    DB_USERNAME=je_gebruikersnaam
    DB_PASSWORD=je_wachtwoord

### Uitvoeren van migraties

Voer de database-migraties uit om de tabellen aan te maken:

    php artisan migrate

### Opzetten van de Ontwikkelingsserver

Gebruik het volgende commando om de ontwikkelingsserver te starten:

    php artisan serve
    
### Opzetten van een Normale Server (Ubuntu)

1) Kloon het project naar een Ubuntu server.

2) Installeer Apache2 op de server.

    
## Pinger starten

### Als je het op een ontwikkelingsserver hebt 

    php artisan run

### Als je het op een Ubuntu server hebt 

Voeg het volgende commando aan crontab

     php artisan run



    
