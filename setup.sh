#!/usr/bin/env bash
# Script de ayuda para exportar WP desde Local by Flywheel al repo
# Uso: bash setup.sh <ruta-al-sitio-Local>
# Ejemplo: bash setup.sh "$HOME/Local Sites/imaginamos-prueba/app/public"

set -e

if [ -z "$1" ]; then
  echo "Uso: bash setup.sh <ruta-al-sitio-Local>"
  echo 'Ejemplo: bash setup.sh "$HOME/Local Sites/imaginamos-prueba/app/public"'
  exit 1
fi

SOURCE="$1"
DEST="$(pwd)"

if [ ! -d "$SOURCE/wp-content" ]; then
  echo "ERROR: no se encontró wp-content en $SOURCE"
  exit 1
fi

echo "==> Copiando wp-content desde $SOURCE..."
rm -rf "$DEST/wp-content"
cp -R "$SOURCE/wp-content" "$DEST/wp-content"

echo "==> Eliminando caches y uploads pesados (opcional)"
rm -rf "$DEST/wp-content/cache" \
       "$DEST/wp-content/upgrade" \
       "$DEST/wp-content/debug.log" 2>/dev/null || true

echo ""
echo "==> wp-content copiado correctamente a $DEST/wp-content"
echo ""
echo "Ahora exporta la base de datos. Desde Local:"
echo "  1. Click derecho en tu sitio -> Open Site Shell"
echo "  2. Ejecuta: wp db export /tmp/database.sql --allow-root"
echo "  3. Copia el archivo:"
echo "     cp /tmp/database.sql \"$DEST/database.sql\""
echo ""
echo "Luego levanta todo con: docker compose up -d"
