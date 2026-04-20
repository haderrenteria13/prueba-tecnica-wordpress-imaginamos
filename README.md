# Prueba Técnica: WordPress & WooCommerce Developer Imaginamos

Solución a la prueba técnica de Imaginamos para el cargo de WordPress & WooCommerce Developer.
El proyecto está dockerizado para facilitar su ejecución en local y evaluación funcional.

## Autor

Hader Rentería - haderrenteria13az@gmail.com

## Stack

- WordPress 6.4 (PHP 8.2 + Apache)
- MySQL 8.0
- WooCommerce
- Elementor + ProElements (Theme Builder)
- CURCY - Multi Currency for WooCommerce (VillaTheme)
- TranslatePress - Multilingual

## Puesta en marcha

```bash
git clone https://github.com/haderrenteria13/prueba-tecnica-wordpress-imaginamos.git
cd prueba-tecnica-wordpress-imaginamos
docker compose up -d
```

Espera aproximadamente 30 segundos mientras MySQL importa `database.sql` y WordPress termina de arrancar.

## Accesos

- Sitio: http://localhost:8000
- WP Admin: http://localhost:8000/wp-admin
- phpMyAdmin: http://localhost:8080

### Credenciales

| Servicio   | Usuario   | Contraseña |
| ---------- | --------- | ---------- |
| WP Admin   | admin     | admin      |
| MySQL      | wordpress | wordpress  |
| MySQL root | root      | rootpass   |

## Rutas relevantes

- Home: http://localhost:8000
- Checkout (ES): http://localhost:8000/finalizar-compra/
- Checkout (EN): http://localhost:8000/en/finalizar-compra/
- Detalle de producto: http://localhost:8000/producto/producto-de-prueba/

## Estructura del repositorio

```text
.
├── docker-compose.yml
├── database.sql
├── setup.sh
├── wp-content/
│   ├── mu-plugins/
│   │   └── imaginamos-woo-styles.php
│   ├── plugins/
│   └── themes/
└── README.md
```

## Personalización visual

La personalización principal está centralizada en:

- `wp-content/mu-plugins/imaginamos-woo-styles.php`

Este MU plugin:

- Define variables de diseño (tipografía, color, bordes y radios).
- Estiliza carrito y checkout (WooCommerce Blocks).
- Estiliza la página de detalle de producto (single product).
- Carga estilos también en checkout traducido detectando bloque/shortcode, además de `is_checkout()`.

## Comandos útiles

```bash
# Levantar
docker compose up -d

# Ver logs de WordPress
docker compose logs -f wordpress

# Detener (mantiene DB)
docker compose down

# Reset total (elimina volúmenes y reinicia import de DB)
docker compose down -v
```

## Notas técnicas

- Permalinks en formato `/%postname%/`.
- `database.sql` se auto-importa solo en el primer `docker compose up` del volumen.
- Si ya habías levantado antes, usa `docker compose down -v` para reinicializar.
- Si no ves cambios de estilo al instante, usa recarga fuerte del navegador (`Cmd + Shift + R`).
