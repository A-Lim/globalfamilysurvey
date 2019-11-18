echo "-- Restarting NGINX --"
sudo systemctl restart nginx
echo "-- Restarting mariadb --"
sudo systemctl restart mariadb
echo "-- Restarting laravel-worker --"
sudo supervisorctl start laravel-worker:*
