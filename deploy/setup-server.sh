#!/usr/bin/env bash
# Adds the induction portal to the existing Nginx + MySQL server without touching
# the other sites. Run as root:
#   sudo bash deploy/setup-server.sh induction.example.com you@example.com
set -euo pipefail

DOMAIN="${1:?usage: setup-server.sh <domain> <email-for-ssl>}"
EMAIL="${2:?usage: setup-server.sh <domain> <email-for-ssl>}"
APP_DIR=/var/www/induction
REPO_DIR="$(cd "$(dirname "$0")/.." && pwd)"

if ! systemctl is-active --quiet nginx; then
    echo "Nginx is not running; this script expects the existing Nginx server." >&2
    exit 1
fi
if [ -e /etc/nginx/sites-enabled/induction ] || grep -rqs "server_name.*\b$DOMAIN\b" /etc/nginx/sites-enabled/; then
    echo "An Nginx site for 'induction' or $DOMAIN already exists; not overwriting it." >&2
    exit 1
fi

# PHP 8.3 alongside the other PHP versions (apt only adds what is missing)
apt-get update
apt-get -y install python3-certbot-nginx \
    php8.3-fpm php8.3-mysql php8.3-gd php8.3-mbstring php8.3-xml php8.3-zip php8.3-curl

# Own PHP-FPM pool and session folder, so settings stay separate from other sites
cp "$REPO_DIR/deploy/php-fpm-induction.conf" /etc/php/8.3/fpm/pool.d/induction.conf
install -d -o www-data -g www-data -m 700 /var/lib/php/sessions-induction
install -o www-data -g www-data -m 640 /dev/null /var/log/php8.3-fpm-induction.log

# Writable runtime directories
mkdir -p "$APP_DIR"/{uploads,uploads_1,temp,siteadmin/uploads}
chown -R www-data:www-data "$APP_DIR"/{uploads,uploads_1,temp,siteadmin/uploads}

# Site config
sed "s/induction.example.com/$DOMAIN/" "$REPO_DIR/deploy/nginx-induction.conf" \
    > /etc/nginx/sites-available/induction
ln -s /etc/nginx/sites-available/induction /etc/nginx/sites-enabled/induction

# Validate before touching the running server, then reload (no downtime for other sites)
php-fpm8.3 -t
systemctl enable php8.3-fpm
systemctl reload-or-restart php8.3-fpm   # graceful if other sites use it
if ! nginx -t; then
    rm /etc/nginx/sites-enabled/induction
    echo "Nginx config test failed; site disabled again, other sites unaffected." >&2
    exit 1
fi
systemctl reload nginx

# HTTPS for this domain only (DNS must already point at this server)
certbot --nginx -d "$DOMAIN" -m "$EMAIL" --agree-tos --redirect -n

echo "Done. Next: create the database and edit $APP_DIR/includes/config_file.php"
