#!/bin/bash

cd /var/www/guiafloripa.morettic.com.br/crons/

php cinema.php > cinema.log
echo "CINEMA IS DONE";
php cultura.php > cultura.log
echo "CULT IS DONE";
php destaque.php > destaque.log
echo "STARS IS DONE";
php esporte.php > esporte.log
echo "SPORTS IS DONE";
php evento.php > evento.log
echo "EVENT IS DONE";
php gratuito.php > gratuito.log
echo "FREE IS DONE";
php infantil.php > infantil.log
echo "CHILD IS DONE";
php lazer.php > lazer.log
echo "PARTY IS DONE";
