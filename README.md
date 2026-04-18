# Prueba Técnica: WordPress & WooCommerce Developer — Imaginamos

Solución a la prueba técnica de Imaginamos para el cargo de **WordPress & WooCommerce Developer**. El proyecto está dockerizado para que el evaluador pueda levantarlo en un solo comando.

## Autor

**Hader Rentería** — haderrenteria13az@gmail.com

## Stack

- WordPress 6.4 (PHP 8.2 + Apache)
- MySQL 8.0
- WooCommerce
- Elementor + ProElements (Theme Builder)
- CURCY — Multi Currency for WooCommerce (VillaTheme)
- TranslatePress — Multilingual
- Code Snippets (gestión de hooks personalizados)

## Requisitos

- Docker Desktop (o Docker + Docker Compose v2)
- 2GB libres en disco
- Puertos 8000 y 8080 libres

## Puesta en marcha (un solo comando)

```bash
git clone https://github.com/haderrenteria13/prueba-tecnica-wordpress-imaginamos.git
cd prueba-tecnica-wordpress-imaginamos
docker compose up -d
```

Espera ~30 segundos mientras MySQL importa `database.sql` y WordPress arranca.

Accesos:

- **Sitio:** http://localhost:8000
- **WP Admin:** http://localhost:8000/wp-admin
- **phpMyAdmin:** http://localhost:8080

### Credenciales

| Servicio   | Usuario     | Contraseña  |
| ---------- | ----------- | ----------- |
| WP Admin   | `admin`     | `admin`     |
| MySQL      | `wordpress` | `wordpress` |
| MySQL root | `root`      | `rootpass`  |

## Estructura del repositorio

```
.
├── docker-compose.yml       # Orquestación
├── database.sql             # Dump DB (auto-importado al primer `up`)
├── wp-content/              # Plugins, temas y uploads
├── .gitignore
├── .env.example
└── README.md
```

## Comandos útiles

```bash
# Levantar
docker compose up -d

# Ver logs
docker compose logs -f wordpress

# Detener (mantiene DB)
docker compose down

# Detener y borrar DB (empezar de cero)
docker compose down -v
```

## Notas técnicas

- El sitio se sirve en `http://localhost:8000`. Para cambiar dominio ajusta `WP_HOME` y `WP_SITEURL` en `docker-compose.yml`.
- Permalinks en formato `/%postname%/`.
- El `database.sql` se auto-importa solo en el primer `docker compose up`. Si ya se levantó antes, usa `docker compose down -v` para resetear.
