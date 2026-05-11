#!/usr/bin/env bash
# Patch .env MySQL block. Set variables then run (on server SSH).
#
#   cd ~/domains/eagleacademy.site
#   export DB_DATABASE=u358087675_admin
#   export DB_USERNAME=u358087675_admin
#   export DB_PASSWORD='your_password_here'
#   bash scripts/patch-env-mysql.sh
#
# Use single quotes around DB_PASSWORD in export if it contains $ ! etc.

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT" || exit 1

if [[ -z "${DB_DATABASE:-}" || -z "${DB_USERNAME:-}" ]]; then
  echo "Set DB_DATABASE and DB_USERNAME (and DB_PASSWORD) first."
  exit 1
fi

php scripts/patch-env-mysql.php
