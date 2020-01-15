Usando Laravel 5.8
1. Creación de un panel administrativo usando AdminLTE (https://adminlte.io/)  ---- listo se creo el panel con la misma plantilla modificando algunas cosas.

2. Creación Básica de Laravel Auth con la habiliad de logearte como administrador ==== listo ya se puede loguear como administrador

3. Usar database seeds para crear el primer usario con email admin@admin.com y el password "password"  --- listo usuario ADMNISTRADOR admin@admin.com Y password 12356

4. Creación de un CRUD (Crear, Leer, Actualizar, Eliminar) para dos tablas relacionadas productos y categorías

5. La tabla de productos debe tener Nombre (Requerido), descripción, imagen (Mínimo 300 x 300), precio (Requerido), descuento y una llave foranea con el id de la categoría (Requerida)  ---- listo ya estan requeridos

6. La tabla de categorías debe tener Nombre (Requerido) y descripción  ----- listo ya estan requeridos

7. Estas dos tablas deben estar trabajadas desde migrations  ----- listo fueron creadas con migraciones

8. Store las imagenes de los productos en storage/app/public y hacerlos accessibles para el público

9. Usar Laravel resource controllers con los métodos index, create, store, etc ---- 

10. Usar las validaciones de function y clasess Request

11. Usar paginancion mostrabdo los 10 primeros productos

12. Use Laravel make:auth como tema de diseño predeterminado basado en Bootstrap, eliminar la capacidad de registrarse ---- listo solo se puede registrar cuando esta logueado como administrador

13. Enviar una notificación por email cuando un usario se logea  ---- listo ya se puede enviar enviar email cuando se logue solo hay que realizar la configuracion

14. Implementar el proyecto como multilenguaje usando resources/lang folder

15. Compartir el proyecto en GIthub (https://github.com/)   ---- listo ya fue subido el repositorio

16. Crear una vista en react o vue que liste los productos según las categorías creadas en el admin, cada producto dede mostrar su precio + igv y si existe descuento debe restarse al precio.

17. Crear páginado para cada categoria de no mas de 5 productos

18. Cada lista debe tener un resumen que debe ser la suma de los precios de los productos incluido + igv

Nota: Usar código propio para la solución, se calificará orden, organización, uso de MVC, Auth, CRUD, Eloquente y Relaciones, Migraciones, Validaciones de formularios, File manager, uso de Vue o React y paginaciones