Para su ejecución seguir estos pasos:

- Instalar dependencias ```composer install```
- Copiar el archivo .env.example a .env
- Modificar las configuraciones de la base de datos desde .env
- Ejecutar la migración de la base de datos ```php artisan migrate:refresh```
- Ejecutar el trabajador de fondo ```php artisan queue:work --queue=high,default```
- Para la sincronización programada se puede configurar cron en el servidor para ejecutar ```* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1``` o a su vez para una ejecución local ```php artisan schedule:work```
