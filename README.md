# Weather App - Consulta del tiempo con PHP

Practica de 2 ASIR. Una web hecha en PHP con el patron MVC que te permite buscar cualquier ciudad del mundo y ver su prevision meteorologica. Los datos vienen de la API gratuita de OpenWeatherMap y todas las busquedas se guardan en una base de datos MariaDB. Todo corre dentro de Docker.

Este proyecto no se puede levantar en AWS, debido a que no tengo cuenta de AWS por lo que me veo obligado a hacerlo en local.
---

## Que hace la aplicacion

Escribes el nombre de una ciudad, la app la busca con la API de geocoding y si existe te da tres opciones:

- Ver el tiempo en este momento (temperatura, humedad, viento...)
- Ver como va a estar el tiempo hora a hora durante el dia
- Ver la prevision para los proximos dias de la semana

Ademas de mostrar los datos en texto, hay una grafica de barras hecha en CSS puro para visualizar las temperaturas. Cada consulta que se hace queda registrada en la base de datos, y hay una pagina opcional para ver el historial completo.

---

## Organizacion del codigo

He seguido el patron MVC para separar bien las responsabilidades:

```
weather-app/
├── index.php                     <- Punto de entrada, hace de router
├── config/
│   └── database.php              <- Credenciales de BD y API key
├── controllers/
│   └── WeatherController.php     <- Recibe las peticiones y coordina todo
├── models/
│   ├── Database.php              <- Conexion PDO a MariaDB
│   └── WeatherModel.php          <- Llama a la API con cURL
├── dao/
│   └── ConsultaDAO.php           <- Inserta y recupera datos de la BD
├── views/
│   ├── index.php                 <- Pagina de inicio con el buscador
│   ├── ciudad.php                <- Resultado de la busqueda
│   ├── actual.php                <- Tiempo actual
│   ├── horas.php                 <- Prevision por horas
│   ├── semana.php                <- Prevision semanal
│   └── historial.php             <- Listado de consultas realizadas
├── public/css/
│   └── estilo.css
├── database.sql
├── Dockerfile
└── docker-compose.yml
```

El router (`index.php`) lee el parametro `accion` de la URL y llama al metodo correspondiente del controlador. El controlador usa el modelo para obtener datos y luego carga la vista.

---

## Base de datos

Solo hay una tabla. Guarda cada consulta que se hace con la ciudad, las coordenadas, el tipo de consulta y la fecha:

```sql
CREATE TABLE consultas (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    ciudad        VARCHAR(200) NOT NULL,
    lat           DECIMAL(10, 6) NOT NULL,
    lon           DECIMAL(10, 6) NOT NULL,
    tipo_consulta ENUM('actual', 'horas', 'semana') NOT NULL,
    fecha         DATETIME NOT NULL
);
```

---

## Endpoints de la API

**Buscar ciudad:**
```
GET /geo/1.0/direct?q={ciudad}&limit=1&appid={API_KEY}
```

**Tiempo ahora mismo:**
```
GET /data/2.5/weather?lat={lat}&lon={lon}&appid={API_KEY}&units=metric&lang=es
```

**Prevision (horas y dias):**
```
GET /data/2.5/forecast?lat={lat}&lon={lon}&appid={API_KEY}&units=metric&lang=es&cnt=8
```

---

## Primeros pasos de configuración

### 1. Poner la API key para que funcione

En `config/database.php` cambia esta linea con tu clave de OpenWeatherMap:

```php
define('API_KEY', 'aqui_va_tu_clave');
```

Si no tienes cuenta, registrate gratis en openweathermap.org. Ojo que las claves nuevas tardan un rato en activarse (puede ser hasta 2 horas).

### 2. Levantar con Docker

```bash
docker compose up -d --build
```

Luego abre el navegador en `http://localhost:8087` y ya esta.

Para apagar el contenedor:
```bash
docker compose down
```

### 3. Sin Docker (XAMPP)

1. Pon la carpeta en `htdocs`
2. Importa `database.sql` en tu MariaDB
3. Cambia los datos de conexion en `config/database.php`
4. Entra a `http://localhost:8087/weather-app/`

---

## Despliegue en AWS

1. Crear instancia EC2 con Ubuntu
2. Instalar Docker y Docker Compose en la maquina
3. Subir el proyecto (con `scp` o clonando el repo)
4. Ejecutar `docker compose up -d --build`
5. Abrir el puerto 80 en las reglas del grupo de seguridad
6. Acceder desde el navegador con la IP publica

---

## Tecnologias usadas

| Cosa | Para que sirve |
|---|---|
| PHP 8.2 | El backend de toda la vida |
| Apache | Servidor web dentro del contenedor |
| MariaDB | Base de datos |
| PDO | Conectar PHP con la BD de forma segura |
| cURL | Hacer las peticiones HTTP a la API |
| HTML + CSS | El frontend, sencillo y sin librerias |
| Docker | Contenedores para no liarse con la instalacion |
| OpenWeatherMap | La API que nos da los datos del tiempo |

---

## Enlace al repo y a la app

- GitHub: `https://github.com/Manuel190906/Aplicaci-n-del-Tiempo`
- App desplegada: `http://IP_PUBLICA_AWS`

Realizado por : Manuel Ramírez Rodríguez
Curso : ASIR 2º.
