# Install

## On console

git clone <repository>
cd <project path>
php composer.phar selfupdate
php composer.phar install
php composer.phar dumpautoload

## On database

Import skeleton-db.sql
Import inserts.sql

## On http server

Create a vhost and set documentRoot <project path>/public
