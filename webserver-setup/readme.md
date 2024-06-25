# webserver-setup

Deze map bevat de scriptbestanden om de omgeving te initialiseren. De
bestanden `bootstrap.sh` en `docker-php-ext-xdebug.ini` mogen niet
gewijzigd of verwijderd worden.

## SQL-bestanden

Bestanden met de extensie `.sql` zijn database script files om een
database aan te maken en te initaliseren. Ze bevatten het *create
script* van de database. Deze bestanden worden op de volgende manier
verwerkt:

1. De bestandsnaam (zonder extensie) is de databasenaam. Er wordt
   gecontroleerd of er al een database met die naam aanwezig is.
2. Als de database wel bestaat, wordt het volgende bestand opgezocht.
3. Als de database *niet* bestaat,
   a. wordt er een `create database <naam>` gedaan
   b. het bestand wordt in die nieuwe database uitgevoerd (aanmaken
   tabellen, constraints, default vulling, etc. etc.)

Deze sql-bestanden mogen verwijderd worden of nieuwe toegevoegd worden.
Let op, in het script zelf geen 'create database' o.i.d. doen. Daarnaast
moet het bestandsnaam een geldige databasenaam zijn (dus geen speciale
tekens en/of spaties).

Met SQL Management Studio kun je dan verbinding maken met de database(s)
om wijzigingen e.d. te doen.
