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

## Funcionalidades implementadas

### 1. Estructura Global (Header + Footer)

- **Header global** creado desde el **Theme Builder de Elementor**: widget Site Title mostrando "Imaginamos Store" + widget Menu Cart para el carrito.
- **Footer global** con el texto literal del **Recurso B**:
  > `© 2026 - Todos los derechos reservados. Desarrollado para la evaluación técnica de CMS WordPress IMAGINAMOS.`
- Ambas plantillas aplicadas con condición **"Todo el sitio"**.

### 2. Producto de Prueba

Producto simple creado en WooCommerce:

- Nombre: **Producto de Prueba**
- Precio: **$10.00 COP**

### 3. Centro de Soporte (página + formulario)

- Página estática maquetada con Elementor en `/centro-de-soporte/`.
- Incluye el texto literal del **Recurso A** (Lorem ipsum + consulta sobre políticas de envío/devoluciones).
- Formulario funcional con los campos **Nombre**, **Correo Electrónico** y **Motivo de la consulta** (widget Form de ProElements).
- Acción al enviar: email al administrador.

### 4. Botón "Consultar soporte" en Checkout (hooks + CSS)

Implementado vía **Code Snippets** usando el hook `woocommerce_review_order_after_submit`:

```php
add_action( 'woocommerce_review_order_after_submit', 'imaginamos_soporte_button', 20 );
function imaginamos_soporte_button() {
    $soporte_url = home_url( '/centro-de-soporte/' );
    echo '<a href="' . esc_url( $soporte_url ) . '" class="imaginamos-soporte-btn">¿Dudas con tu pedido? Consultar soporte</a>';
}

add_action( 'wp_head', 'imaginamos_soporte_button_styles' );
function imaginamos_soporte_button_styles() {
    if ( is_checkout() ) {
        echo '<style>
            .imaginamos-soporte-btn {
                display: block;
                width: 100%;
                margin-top: 15px;
                padding: 16px 24px;
                background-color: #FF6B00;
                color: #FFFFFF !important;
                font-weight: 700;
                text-align: center;
                text-decoration: none;
                border-radius: 8px;
                font-size: 16px;
                transition: background 0.2s ease;
            }
            .imaginamos-soporte-btn:hover {
                background-color: #E55A00;
                color: #FFFFFF !important;
            }
        </style>';
    }
}
```

Cumple los requisitos del PDF:

- Fondo naranja `#FF6B00`
- Texto blanco en negrita (`font-weight: 700`)
- Borde redondeado (`border-radius: 8px`)
- Diferenciado visualmente del botón "Realizar pedido" de WooCommerce

### 5. Multiidioma

- **TranslatePress** instalado y activo.
- Idiomas: **Español (por defecto)** + **Inglés**.
- Switcher de idioma disponible en el menú.

### 6. Multimoneda

- **CURCY — Multi Currency for WooCommerce** (VillaTheme).
- Monedas: **COP (Peso colombiano)** como default + **USD (Dólar)**.
- Switcher visible en el frontend.

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

## Hooks de WooCommerce utilizados

| Hook                                   | Propósito                                          |
| -------------------------------------- | -------------------------------------------------- |
| `woocommerce_review_order_after_submit` | Añadir botón "Consultar soporte" en checkout        |
| `wp_head`                              | Inyectar CSS del botón condicional a `is_checkout()` |
