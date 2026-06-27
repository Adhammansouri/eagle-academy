#!/usr/bin/env bash
# Run on Hostinger SSH from Laravel root (folder that contains artisan).
# Example: cd ~/domains/eagleacademy.site && bash scripts/hostinger-post-deploy.sh

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT" || exit 1

echo "== Laravel root: $ROOT =="
echo ""

echo ">>> php -v"
php -v
echo ""

echo ">>> vendor/autoload.php exists?"
if [[ -f vendor/autoload.php ]]; then echo "yes"; else echo "NO — run composer install"; exit 1; fi
echo ""

echo ">>> PHP load autoload only"
php -d display_errors=1 -d error_reporting=E_ALL -r 'require "vendor/autoload.php"; echo "autoload OK\n";' 2>&1
echo "    (exit $?)"
echo ""

echo ">>> artisan --version (shows parse/boot errors)"
php -d display_errors=1 -d error_reporting=E_ALL artisan --version 2>&1
av=$?
echo "    (exit $av)"
echo ""

if [[ $av -ne 0 ]]; then
  echo "=== artisan failed. Read the PHP message above. ==="
  echo ""
  echo "If you see: Permission denied ... vendor/ ..."
  echo "  cd \"$ROOT\""
  echo "  find . -type d -exec chmod u+rwx,go+rx {} \\;"
  echo "  find . -type f -exec chmod u+rw,go+r {} \\;"
  echo "  chmod 600 .env 2>/dev/null || true"
  echo "  ls -la vendor/symfony/deprecation-contracts/function.php"
  echo "If owner is not your user (e.g. root), delete vendor and re-extract the zip via File Manager as your account, or run: composer install --no-dev"
  echo ""
  echo "If the error is about .env / syntax (not vendor):"
  echo "  DB_PASSWORD with \$ or + must be: DB_PASSWORD=\"...\""
  echo "  Or: mv .env .env.bak  (if using only hPanel env vars)"
  exit "$av"
fi

run() {
  echo ">>> $*"
  php -d display_errors=1 -d error_reporting=E_ALL "$@" 2>&1
  echo "    (exit $?)"
  echo ""
}

run artisan config:clear
run artisan cache:clear
run artisan view:clear
php artisan route:clear 2>/dev/null || true
echo "    (route:clear done)"
echo ""

if [[ -d storage ]]; then
  echo ">>> chmod storage bootstrap/cache"
  chmod -R u+rwX storage bootstrap/cache 2>/dev/null || true
  echo "    (chmod done)"
  echo ""
fi

echo ">>> php artisan migrate:status"
COLUMNS=120 php -d display_errors=1 artisan migrate:status 2>&1
echo "    (exit $?)"
echo ""

echo ">>> php artisan migrate --force"
php -d display_errors=1 artisan migrate --force 2>&1
echo "    (exit $?)"
echo ""

echo "Done."
