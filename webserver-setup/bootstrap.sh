#!/bin/sh
# set -x

# based on: 
# https://stackoverflow.com/questions/58279183/how-do-i-check-that-a-sql-server-linux-database-is-up-and-running

sleep 10 # wait for sql server to start up

DIR=$(dirname $0)

if ls $DIR/*.sql &>/dev/null
then
    echo "SQL script files found."

    for sqlfile in $DIR/*.sql
    do
        dbname=$(basename "$sqlfile" .sql)
        # 20 retries....
        i=0
        while [ $i -le 20 ]; do
            echo ""
            echo "---------------------------------------------"
            echo "- $i: checking for database '$dbname'       -"
            echo "---------------------------------------------"

            # Check if Database already exists
            RESULT=$(/opt/mssql-tools18/bin/sqlcmd -C -S "$DB_HOST" -U sa -P "$SA_PASSWORD" -Q "IF DB_ID('$dbname') IS NOT NULL print 'YES'")
            CODE=$?

            if [ "$RESULT" = "YES" ]; then
                echo ""
                echo "-----------------------------------------------"
                echo "- $i: Database '$dbname' exists               -"
                echo "-----------------------------------------------"
                # php -S 0.0.0.0:80 -t /applicatie/
                break # exit for loop

            elif [ $CODE -eq 0 ] && [ "$RESULT" = "" ]; then
                echo ""
                echo "-------------------------------------------------------"
                echo "- $i: Server available, creating database '$dbname'  -"
                echo "-------------------------------------------------------"
                /opt/mssql-tools18/bin/sqlcmd -C -S "$DB_HOST" -U sa -P "$SA_PASSWORD" -d "master" -Q "create database $dbname"
                /opt/mssql-tools18/bin/sqlcmd -C -S "$DB_HOST" -U sa -P "$SA_PASSWORD" -d "$dbname" -i "$DIR/$dbname".sql
                echo "-------------------------------------------------------"
                echo "- $i: Database created '$dbname'                     -"
                echo "-------------------------------------------------------"
                # no break, let run the loop again, line 13 should return 'YES'

            # If the code is different than 0, an error occured. (most likely database wasn't online) Retry.
            else
                echo "-------------------------------------------------------"
                echo "- $i: Database not ready yet...                       -"
                echo "-------------------------------------------------------"
                sleep 5
            fi
            i=$(( i + 1 ))
        done
    done
else
    echo "No SQL script files found in folder '$DIR'"
fi

echo ''
echo '-------------------------------------------------------'
echo ' Available databases:                                 -'

/opt/mssql-tools18/bin/sqlcmd -C -S "$DB_HOST" -U sa -P "$SA_PASSWORD" -d "master" -Q "set nocount on; select '- ' + name from sys.databases where name not in ('master', 'tempdb', 'model', 'msdb')" -h-1

echo
echo ' webserver starting'
echo '-------------------------------------------------------'

php -S 0.0.0.0:80 -t /applicatie/

