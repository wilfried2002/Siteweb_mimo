# Guide de déploiement — mimosaflour.com

Ce document décrit la procédure de mise en production de l'application
Laravel **Mimosa Flour** sur le nom de domaine **mimosaflour.com**.

---

## 1. Prérequis serveur

| Composant       | Version minimale | Remarque |
|------------------|-------------------|----------|
| PHP              | 8.2               | extensions requises ci-dessous |
| MySQL / MariaDB  | 8.0 / 10.6        | obligatoire (migrations `ALTER ... ENUM`, voir §6) |
| Composer         | 2.x               | |
| Node.js / npm    | 20+ / 10+         | uniquement pour `npm run build` (peut être fait en local) |
| Extensions PHP   | `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `tokenizer`, `xml` | toutes présentes par défaut sur PHP 8.2 |
| Certificat SSL   | Let's Encrypt (certbot) ou certificat fourni par l'hébergeur | obligatoire — `APP_URL=https://mimosaflour.com` |

Deux scénarios sont couverts :

- **A. VPS / serveur dédié** (Nginx ou Apache + PHP-FPM, accès SSH complet, cron, supervisor)
- **B. Hébergement partagé cPanel** (pas d'accès root, document root fixe)

---

## 2. Scénario A — VPS / serveur dédié

### 2.1 Arborescence

```
/var/www/mimosaflour.com/        ← racine du projet (ce dépôt)
/var/www/mimosaflour.com/public/ ← DocumentRoot du serveur web
```

### 2.2 Première installation

```bash
cd /var/www
git clone <url-du-repo> mimosaflour.com
cd mimosaflour.com

# Dépendances
composer install --no-dev --optimize-autoloader --no-interaction
npm ci
npm run build

# Configuration
cp .env.production.example .env
php artisan key:generate
nano .env   # renseigner DB_*, MAIL_*, MAINTENANCE_KEY (voir §5)

# Base de données
php artisan migrate --force
php artisan db:seed --force   # optionnel : crée le compte admin + comptes employés de démo

# Stockage (CV, lettres de motivation, images)
php artisan storage:link

# Optimisation
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Permissions (utilisateur du serveur web : www-data)
chown -R www-data:www-data /var/www/mimosaflour.com
chmod -R 775 storage bootstrap/cache
```

### 2.3 Configuration du serveur web

- Apache : copier [`deploy/apache-mimosaflour.conf`](deploy/apache-mimosaflour.conf)
- Nginx  : copier [`deploy/nginx-mimosaflour.conf`](deploy/nginx-mimosaflour.conf)

Dans les deux cas, le **DocumentRoot doit pointer vers `public/`**, jamais
vers la racine du projet (sécurité : `.env`, `app/`, `vendor/` ne doivent
pas être accessibles via le web).

### 2.4 Certificat SSL

```bash
certbot --apache -d mimosaflour.com -d www.mimosaflour.com   # ou --nginx
```

### 2.5 Worker de file d'attente (emails, traitements asynchrones)

Copier [`deploy/supervisor-mimosaflour-worker.conf`](deploy/supervisor-mimosaflour-worker.conf)
dans `/etc/supervisor/conf.d/` puis :

```bash
supervisorctl reread
supervisorctl update
supervisorctl start mimosaflour-worker:*
```

### 2.6 Planificateur (cron)

Ajouter la ligne de [`deploy/crontab-mimosaflour.txt`](deploy/crontab-mimosaflour.txt)
au crontab de l'utilisateur `www-data`.

### 2.7 Déploiements suivants

Le script [`deploy/deploy.sh`](deploy/deploy.sh) automatise une mise à jour :

```bash
cd /var/www/mimosaflour.com
bash deploy/deploy.sh
```

---

## 3. Scénario B — Hébergement partagé (cPanel)

La plupart des hébergements cPanel imposent `public_html/` comme racine
web et ne permettent pas de la rediriger vers `public/`.

1. Uploader l'ensemble du projet **hors de `public_html`**, par exemple
   dans `/home/USER/mimosaflour/`.
2. Copier le **contenu** du dossier `public/` du projet (assets, `build/`,
   `images/`, `favicon.ico`, `robots.txt`, `storage/` symlink…) à la racine
   de `public_html/`.
3. Remplacer `public_html/index.php` par
   [`deploy/cpanel-public_html.index.php`](deploy/cpanel-public_html.index.php)
   en adaptant la variable `$appBasePath`.
4. Copier [`deploy/cpanel-public_html.htaccess`](deploy/cpanel-public_html.htaccess)
   vers `public_html/.htaccess`.
5. Créer la base de données MySQL et l'utilisateur depuis cPanel
   (MySQL® Databases), puis renseigner `.env` (voir §5).
6. Via le terminal SSH cPanel (ou Cron Jobs si pas de SSH) :
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```
   Le build front-end (`npm run build`) peut être réalisé **en local** et
   le dossier `public/build/` simplement uploadé (Node n'est pas toujours
   disponible sur cPanel).
7. Activer le SSL gratuit "AutoSSL" depuis cPanel et forcer HTTPS
   (déjà géré par le `.htaccess` Laravel si `APP_URL` est en `https://`).
8. Planificateur : ajouter dans **Cron Jobs** (cPanel) :
   ```
   * * * * * php /home/USER/mimosaflour/artisan schedule:run >> /dev/null 2>&1
   ```
9. File d'attente : sur cPanel sans accès process manager, privilégier
   `QUEUE_CONNECTION=sync` (traitement immédiat, sans worker) — voir §5.

---

## 4. DNS — mimosaflour.com

Chez le registrar / gestionnaire DNS du domaine :

| Type  | Hôte | Valeur                          | TTL  |
|-------|------|----------------------------------|------|
| A     | @    | IP du serveur (VPS)              | 3600 |
| A     | www  | IP du serveur (VPS)              | 3600 |
| CNAME | www  | mimosaflour.com (si hébergement) | 3600 |
| MX/TXT| @    | selon fournisseur d'emails (SPF/DKIM pour `MAIL_FROM_ADDRESS`) | — |

> Pour un hébergement cPanel, pointer les enregistrements `A` (ou les
> nameservers) vers les valeurs fournies par l'hébergeur.

---

## 5. Variables d'environnement de production

Partir de [`.env.production.example`](.env.production.example) et renseigner :

- `APP_KEY` : généré via `php artisan key:generate` (ne jamais réutiliser la clé locale)
- `APP_URL=https://mimosaflour.com`
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` : identifiants MySQL de production
- `MAIL_*` : SMTP réel (l'application envoie des emails pour les candidatures
  et les commandes — `MAIL_MAILER=log` ne doit **jamais** être utilisé en prod)
- `MAINTENANCE_KEY` : chaîne aléatoire longue (ex: `php artisan tinker --execute="echo bin2hex(random_bytes(16));"`)
- `SESSION_DOMAIN=.mimosaflour.com` et `SESSION_SECURE_COOKIE=true`
- Si pas de worker disponible (hébergement partagé) : `QUEUE_CONNECTION=sync`

`APP_DEBUG` **doit impérativement rester à `false`** en production : le
projet possède déjà une page d'erreur applicative dédiée
(`data.database-error`, `data.maintenance`, etc. — voir `resources/views/data/`)
pilotée par le middleware `EnsureApplicationIsAvailable`.

---

## 6. Points d'attention spécifiques au projet

- **Base MySQL obligatoire** : la migration
  `2026_04_21_081127_add_new_statuses_to_orders_table.php` utilise
  `ALTER TABLE ... MODIFY COLUMN ... ENUM(...)`, syntaxe MySQL/MariaDB
  uniquement. SQLite n'est pas supporté en production.
- **Mode disponibilité applicative** : la table `system_settings`
  (gérée via `/system/status`, accessible même en cas de coupure) permet
  de basculer le site en mode « indisponible » avec différentes pages
  (`maintenance`, `account-suspended`, `security-lock`, etc.). Conserver
  l'accès à `/system/status` et `/admin/login` même quand le site est
  désactivé (déjà géré par le middleware).
- **Comptes par défaut** (créés par `db:seed`) — **à changer immédiatement
  après le premier déploiement** :
  - Admin : `admin@mimosaflour.com` / `Admin@2024!`
  - Commercial / Magasinier / RH : `*@mimosaflour.com` / `Employe@2024!`
- **Uploads** : CV et lettres de motivation (`storage/app/public`) et
  images produits/sliders — vérifier que `storage/` et `bootstrap/cache`
  sont accessibles en écriture par l'utilisateur du serveur web.
- **Sauvegardes** : mettre en place une sauvegarde quotidienne de la base
  MySQL et du dossier `storage/app/public` (candidatures, documents).

---

## 7. Checklist de mise en production

- [ ] DNS `mimosaflour.com` / `www.mimosaflour.com` pointés vers le serveur
- [ ] Certificat SSL valide (HTTPS forcé)
- [ ] `.env` de production complété, `APP_ENV=production`, `APP_DEBUG=false`
- [ ] `php artisan migrate --force` exécuté sans erreur
- [ ] `php artisan storage:link` exécuté
- [ ] `npm run build` exécuté (assets dans `public/build/`)
- [ ] Caches générés (`config`, `route`, `view`, `event`)
- [ ] Mots de passe des comptes de démonstration changés
- [ ] Mailer SMTP réel configuré et testé (candidature / commande de test)
- [ ] Cron `schedule:run` actif
- [ ] Worker de file d'attente actif (ou `QUEUE_CONNECTION=sync` si indisponible)
- [ ] Sauvegardes automatiques en place
