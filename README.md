Para su ejecución seguir estos pasos:

- Instalar dependencias ```composer install```
- Copiar el archivo .env.example a .env
- Modificar las configuraciones de la base de datos desde .env
- Ejecutar la migración de la base de datos ```php artisan migrate:refresh```
- Ejecutar el trabajador de fondo ```php artisan queue:work --queue=high,default```
