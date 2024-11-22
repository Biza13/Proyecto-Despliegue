#!/bin/bash
sudo apt update -y
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
sudo apt install php php-fpm -y
sudo systemctl start php-fpm
sudo systemctl enable php-fpm
sudo systemctl restart nginx