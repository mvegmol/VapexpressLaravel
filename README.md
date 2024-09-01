# Instalación del Proyecto en Local

Para instalar el proyecto en tu entorno local, sigue los siguientes pasos:

1. **Descargar el repositorio**
   - Clona o descarga el repositorio.

2. **Acceder al directorio del proyecto**
   - Navega a la carpeta principal del proyecto, usualmente llamada `Vapexpress`.

3. **Configurar el entorno**
   - Renombra el archivo `.env.example` a `.env`.
   - Abre el archivo `.env` y actualiza las variables de configuración de la base de datos con las credenciales que utilizas en tu entorno local.

4. **Instalar dependencias de PHP**
   - Ejecuta el siguiente comando para instalar las dependencias de PHP a través de Composer:
     ```bash
     composer install
     ```

5. **Instalar dependencias de JavaScript**
   - Ejecuta el siguiente comando para instalar las dependencias de JavaScript utilizando npm:
     ```bash
     npm install
     ```

6. **Migrar la base de datos**
   - Ejecuta el siguiente comando para migrar las tablas de la base de datos:
     ```bash
     php artisan migrate
     ```

7. **Datos de prueba**
   - Ejecutar el comando para tener los datos de prueba:
     ```bash
     php artisan db:seed
     ```

8. **Generar la clave de la aplicación**
   - Finalmente, genera la clave de la aplicación con el siguiente comando:
     ```bash
     php artisan key:generate
     ```
  ## Cuenta del MailTrap
  - Correo: mvegmol@alu.upo.es
  - Password: 123456
   
   
