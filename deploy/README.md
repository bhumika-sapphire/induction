# Hosting the induction portal on the VPS

This adds the portal to the existing VPS next to `cashforesee` and `skillassessment`. It uses the same setup as those sites:
**Nginx** and **MySQL 8.4**, which are already running, plus **PHP 8.3 (PHP-FPM)** and a free Let's Encrypt certificate.
The other sites keep running throughout. The portal gets its own Nginx site, PHP pool, database and database user.

Replace `induction.example.com` with your domain and `SERVER_IP` with the VPS IP throughout.
The portal needs about 3 GB of free disk space, mostly for uploads. Check with `df -h /`.

## 1. Point the domain at the VPS

At your DNS provider, add an **A record** for `induction.example.com` with the value `SERVER_IP`.
Do this first, because the HTTPS step in section 3 only works once DNS resolves.

## 2. Put the code on the server

```bash
git clone https://github.com/bhumika-sapphire/induction.git /var/www/induction
```

If the repository is private, GitHub will ask for credentials. Use your GitHub username and a
[personal access token](https://github.com/settings/tokens) (read-only "Contents" permission) as the password.

## 3. Add the site to Nginx

```bash
cd /var/www/induction
bash deploy/setup-server.sh induction.example.com you@example.com
```

The script:

- installs PHP 8.3 and the extensions the portal needs, alongside the PHP versions already there;
- creates a separate PHP-FPM pool for the portal, so its upload limits, sessions and error log don't affect the other sites;
- adds an Nginx site for this domain only, and stops if one with the same name or domain already exists;
- tests the Nginx config before applying it, and removes the new site again if the test fails;
- reloads Nginx instead of restarting it, so the other sites stay up;
- gets an HTTPS certificate for this domain.

The firewall already allows ports 80 and 443, so it doesn't need changes.

## 4. Create the database

```bash
mysql -u root -p                   # or: sudo mysql
```
```sql
CREATE DATABASE sapphzgv_induction CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'induction'@'localhost' IDENTIFIED BY 'a-strong-password';
GRANT ALL PRIVILEGES ON sapphzgv_induction.* TO 'induction'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

## 5. Copy the data from your PC (run these on Windows, in Git Bash)

The SQL dump and the uploads are not in git, so copy them over directly:

```bash
cd /d/Code/induction
tar -czf /tmp/induction-files.tgz uploads uploads_1 siteadmin/uploads
scp sapphzgv_induction.sql /tmp/induction-files.tgz root@SERVER_IP:/root/
```

Back on the server:

```bash
mysql -u root -p sapphzgv_induction < /root/sapphzgv_induction.sql
tar -xzf /root/induction-files.tgz -C /var/www/induction
chown -R www-data:www-data /var/www/induction/{uploads,uploads_1,temp,siteadmin/uploads}
rm /root/sapphzgv_induction.sql /root/induction-files.tgz
```

If the old cPanel site is still live, export a **fresh** dump and uploads from it instead, so you don't lose recent data.

## 6. Configure the app

```bash
cd /var/www/induction/includes
cp config_file.example.php config_file.php
nano config_file.php
```

Set `DB_PASSWORD`, `SERVER_URL` (`https://induction.example.com`), and the `SMTP_*` values.
The VPS has no mail server, so the "forgot password" and admin emails only work with a real SMTP account,
such as your existing mailbox on cPanel, Google Workspace or Zoho.

```bash
chmod 640 config_file.php && chown root:www-data config_file.php
```

## 7. Test before announcing it

The database dump comes from **MySQL 5.7** on cPanel, and the VPS runs **MySQL 8.4**, which is stricter.
Click through the main flows as a new user and as an admin:

- log in;
- fill in employee details;
- read chapters;
- take a test;
- upload and download documents;
- export to Excel.

If a page shows a database error, check `/var/log/php8.3-fpm-induction.log`. The usual fix for old code
is a relaxed SQL mode for this app only.

Also confirm the two other sites still load.

## Updating the site later

```bash
cd /var/www/induction && git pull
```

`config_file.php` and the upload folders are git-ignored, so a pull never overwrites them.

## Backups (recommended)

Run `crontab -e` as root and add these lines. They give you a nightly database dump and keep 14 days of dumps:

```
0 2 * * * mysqldump sapphzgv_induction | gzip > /root/backups/induction-db-$(date +\%F).sql.gz
0 3 * * * find /root/backups -name 'induction-db-*.sql.gz' -mtime +14 -delete
```

Create the folder first with `mkdir -p /root/backups`. If `mysqldump` asks for a password when you run it by hand,
save the credentials in `/root/.my.cnf` (`[client]` / `user=...` / `password=...`, then `chmod 600`).
Also turn on your VPS provider's snapshot backups, which cover the uploads too.

## Troubleshooting

| Symptom | Check |
|---|---|
| "Database connection failed" | DB credentials in `config_file.php`; `systemctl status mysql` |
| Blank page, HTTP 500 or 502 | `tail -f /var/log/nginx/induction_error.log /var/log/php8.3-fpm-induction.log`; `systemctl status php8.3-fpm` |
| Uploads fail | Permissions on the upload folders (`chown www-data`); limits in `/etc/php/8.3/fpm/pool.d/induction.conf` |
| Domain shows another site | DNS for the new domain; `nginx -T \| grep server_name` should list `induction.example.com` |
| Emails not sent | `SMTP_*` settings; some VPS providers block port 25/587 until you ask them to unblock it |
| certbot fails | DNS must point at the VPS first; re-run `certbot --nginx -d induction.example.com` |
