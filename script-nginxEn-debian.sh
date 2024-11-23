#!/bin/bash
sudo apt update -y
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
sudo apt install php php-fpm -y
sudo systemctl start php-fpm
sudo systemctl enable php-fpm
sudo systemctl enable php8.2-fpm
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo apt install rsync
sudo apt install curl php-cli php-mbstring unzip git -y
sudo apt install composer
sudo apt install php8.2-xml