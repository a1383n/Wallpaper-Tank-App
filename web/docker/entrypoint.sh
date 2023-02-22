#!/bin/bash

YELLOW='\033[0;33m'
NC='\033[0m' # No Color

echo "################################ Start of script #################################"
echo "Upgrading system"
apt-get update -q && apt-get upgrade -q -y

if [ ! -d vendor ]; then
        echo -e "${YELLOW}Installing dependencies...${NC}"
    composer install --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader --quiet
fi

if [ ! -d node_modules  ]; then
        echo -e "${YELLOW}Installing node dependencies...${NC}"
    npm ci
fi

# Setup supervisor and run the supervisor with no daemon
echo -e "${YELLOW}Starting supervisor...${NC}"
service supervisor start
supervisord -c /var/www/laravel/docker/supervisor.conf


