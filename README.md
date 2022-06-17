<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></p>


<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


## Introducción

Aplicación con Laravel 7, Bootstrap 5, Vue js 2.5. Importación de un archivo .csv en una vista de administrador para el acceso o rechazo de proveedores al mismo.

## Configuración

Seguir los siguientes pasos para la puesta en marcha:

```
1. Crear archivo enviroment (.env), copiando el archivo .env.example.
2. composer update.
3. php artisan migrate:fresh --seed.
4. npm i.
5. php artisan cache:clear
6. php artisan config:cache
7. php artisan view:clear
8. php artisan route:clear
```
## Prueba

Para realizar pruebas dentro de la aplicación:
```
1. Para administrador con las siguientes credenciales: admin@correo.com/temporal2022
2. Cargar archivo csv ubicado en public/file/ dentro del proyecto.
3. Password para proveedor: prueba.
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
