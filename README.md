# PrestaShop Module Skeleton

Boilerplate de módulo PrestaShop listo para producción, compatible con **1.7, 8.x y 9.x**. Pensado como punto de partida limpio para arrancar un módulo nuevo sin reescribir lo básico cada vez.

Mantenido por [SapyensDev](https://sapyensdev.com).

## Qué incluye

- Estructura estándar de módulo (`config.xml`, clase principal, `views/`, `translations/`)
- Ejemplo de **hook de front** con `displayHeader` (carga de CSS y JS) y `displayFooter` (renderiza una plantilla Smarty)
- Ejemplo de **hook de back office** con `displayBackOfficeHeader`, restringido a la propia página del módulo con `Tools::getValue('configure')`, para no ensuciar el resto del admin de la tienda
- Ejemplo de **página de configuración** en el back office (Módulos → Configurar) usando `HelperForm`, con guardado y validación de un valor en `Configuration`
- Ejemplo de **tabla propia en base de datos**, con creación en `install()` (`CREATE TABLE IF NOT EXISTS`) y eliminación en `uninstall()` (`DROP TABLE`)
- **`ObjectModel` genérico** (`SapyensDevSkeletonItem`) sobre la tabla propia, con validación de campos y fecha de alta automática
- **`AdminController` con CRUD** (`AdminSapyensDevSkeletonItemController`) usando `HelperList` y `HelperForm`, dado de alta como pestaña propia en el menú de Módulos
- `install()` / `uninstall()` completos, incluyendo limpieza de la tabla, la pestaña del menú y la configuración propia, con `$this->_errors[]` en cada paso que puede fallar (PrestaShop los muestra automáticamente en el back office y corta el proceso)
- Archivos `index.php` de protección en cada carpeta de `views/` (convención estándar de PrestaShop)
- `logo.png` de referencia (reemplázalo por el ícono real de tu módulo antes de instalarlo, PrestaShop lo muestra en el listado de módulos)
- Licencia MIT

## Estructura

```
sapyensdevskeleton.php          # Clase principal del módulo
config.xml                   # Metadatos del módulo
classes/
  SapyensDevSkeletonItem.php  # ObjectModel sobre la tabla propia
controllers/admin/
  AdminSapyensDevSkeletonItemController.php  # CRUD del ObjectModel
views/
  css/front.css               # Estilos del hook de front
  css/admin.css                # Estilos del hook de back office
  js/front.js                 # Script del hook de front
  templates/hook/footer.tpl   # Plantilla Smarty del hook displayFooter
translations/                # Carpeta de traducciones (.php por idioma)
```

## Instalación

1. Clona o descarga este repositorio dentro de `modules/` de tu instalación de PrestaShop
2. Renombra la carpeta y el archivo principal (`sapyensdevskeleton.php`) al nombre técnico de tu módulo, deben coincidir, y el nombre de la clase PHP también
3. Busca y reemplaza `sapyensdevskeleton` / `SapyensDevSkeleton` / `SAPYENSDEVSKELETON_MENSAJE` en todo el proyecto por el nombre de tu módulo
4. Instala el módulo desde el back office (Módulos → Instalar) o con `php bin/console prestashop:module install <nombre>` en 8.x/9.x

## Compatibilidad

Este skeleton usa `Module` + `HelperForm`, disponibles sin cambios desde PrestaShop 1.7 hasta 9.x. No usa Symfony ni autoload PSR-4 porque no lo necesita para un módulo simple. Si tu módulo va a crecer con controladores Symfony, servicios o entidades Doctrine, agrega `composer.json` con autoload PSR-4 y un directorio `src/`.

**Nota:** PrestaShop 1.6 tiene una arquitectura distinta (sin Symfony, otro sistema de admin controllers) y no está cubierto por este skeleton.

## Traducciones

La carpeta `translations/` está vacía a propósito. PrestaShop genera los archivos `.php` de cada idioma automáticamente cuando exportas las traducciones desde el back office (Traducciones → Exportar), con claves basadas en un hash de cada cadena de texto de `$this->l()`. No tiene sentido escribir ese archivo a mano.

## Licencia

MIT, ver [LICENSE](LICENSE).
