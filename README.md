## Instalación

Para instalar el proyecto debes clonar el repositorio de gitHub luego ir a la ruta del proyecto y crear el archivo .env para conectarlo a tu Base de Datos, luego debes ejecutar los siguientes comandos artisan:

- Ejecutar comando ``composer install``
- Ejecutar comando ``php artisan key:generate``
- Ejecutar comando ``npm install``
- Ejecutar comando ``npm run dev``
- Ejecutar comando ``php artisan migrate``
- Ejecutar comando ``php artisan db:seed``

## Congiguracion de Entorno

* Para envío de correos
``MAIL_MAILER=smtp``
``MAIL_HOST=smtp.mailtrap.io``
``MAIL_PORT=2525``
``MAIL_USERNAME=d550ba9cf81209``
``MAIL_PASSWORD=4180c1be2eae51``
``MAIL_ENCRYPTION=tls``
``MAIL_FROM_ADDRESS='pedroxromano18@gmail.com'``
``MAIL_FROM_NAME="${APP_NAME}"``

* Para envío masivo de correos
- Ejecutar comando: ``php artisan email:send``

## Usuario admin para ingreso
- usuario: pedroxromano18@gmail.com
- clave: admin

## Librerías utilizadas
- Owenit Audit
- LaravelDatabaseEmail
- Kyslik Sortable

## Api
- El api para consulta de emails responde en la siguiente url: ``/api/emails?items=5&sort=created_at&direction=asc&filter_text=``

- Puedes utilizar los item en el querystring para aplicar paginado, filtro y ordenamiento ``items`` (numero de items para paginado), ``sort`` (indicar el campo a ordenar), ``direction`` (tipo de ordenamiento desc,asc), ``filter_text`` (texto para filtrar)