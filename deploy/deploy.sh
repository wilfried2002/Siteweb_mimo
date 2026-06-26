#!/usr/bin/env bash
# ============================================================
# Script de déploiement — mimosaflour.com (VPS / serveur dédié)
# ============================================================
# Usage : bash deploy/deploy.sh
# À exécuter depuis la racine du projet sur le serveur, par
# l'utilisateur propriétaire des fichiers (ex: www-data ou deploy).
# ------------------------------------------------------------
set -euo pipefail

echo "==> Activation du mode maintenance"
MAINTENANCE_KEY=$(grep -E '^MAINTENANCE_KEY=' .env | cut -d= -f2-)
php artisan down ${MAINTENANCE_KEY:+--secret="$MAINTENANCE_KEY"}

echo "==> Récupération du code"
git pull origin main

echo "==> Installation des dépendances PHP (production)"
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Installation et build des assets front-end"
npm ci
npm run build

echo "==> Migrations de base de données"
php artisan migrate --force

echo "==> Lien symbolique de stockage (idempotent)"
php artisan storage:link || true

echo "==> Mise en cache de la configuration, routes et vues"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "==> Redémarrage des workers de file d'attente"
php artisan queue:restart

echo "==> Désactivation du mode maintenance"
php artisan up

echo "==> Déploiement terminé avec succès."
