# Aplicacion del Tiempo - PHP MVC

Aplicacion web que permite consultar el tiempo atmosferico de cualquier ciudad del mundo usando la API de OpenWeatherMap. Desarrollada en PHP siguiendo el patron MVC, con base de datos MariaDB y desplegada con Docker.

---

## Estructura del proyecto

```
weather-app/
├── index.php                        <- Router principal
├── config/
│   └── database.php                 <- API key y configuracion de BD
├── controllers/
│   └── WeatherController.php        <- Controlador principal
├── models/
│   ├── Database.php                 <- Conexion a MariaDB con PDO
│   └── WeatherModel.php             <- Llamadas a la API con cURL
├── dao/
│   └── ConsultaDAO.php              <- Guarda y lee consultas de la BD
├── views/
│   ├── index.php                    <- Formulario de busqueda
│   ├── ciudad.php                   <- Ciudad encontrada + opciones
│   ├── actual.php                   <- Tiempo actual + grafica
│   ├── horas.php                    <- Prevision por horas + grafica
│   ├── semana.php                   <- Prevision semanal + grafica
│   └── historial.php                <- Historial de consultas
├── public/css/
│   └── estilo.css                   <- Estilos
├── database.sql                     <- Script SQL para crear la BD
├── Dockerfile
└── docker-compose.yml
```

---

## Como funciona el MVC

- **Modelo** (`WeatherModel.php`, `Database.php`): se encarga de hablar con la API y con la base de datos.
- **Vista** (archivos dentro de `views/`): solo muestra los datos, sin logica.
- **Controlador** (`WeatherController.php`): recibe la peticion del usuario, llama al modelo y carga la vista.
- **Router** (`index.php`): segun el parametro `accion` de la URL, decide que metodo del controlador ejecutar.

---

## Base de datos

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

## API utilizada

Se usan tres endpoints de OpenWeatherMap:

**Geocoding** (buscar ciudad por nombre):
```
GET /geo/1.0/direct?q={ciudad}&limit=1&appid={API_KEY}
```

**Tiempo actual:**
```
GET /data/2.5/weather?lat={lat}&lon={lon}&appid={API_KEY}&units=metric&lang=es
```

**Prevision por horas y semanal:**
```
GET /data/2.5/forecast?lat={lat}&lon={lon}&appid={API_KEY}&units=metric&lang=es&cnt=8
```

---

## Configuracion

Abre `config/database.php` y pon tu clave de OpenWeatherMap:

```php
define('API_KEY', 'tu_clave_aqui');
```

La clave gratuita se obtiene en [openweathermap.org](https://openweathermap.org/api). Las claves nuevas pueden tardar hasta 2 horas en activarse.

---

## Instalacion

### Con Docker (recomendado)

```bash
docker compose up -d --build
```

Abre en el navegador: `http://localhost`

Para parar:
```bash
docker compose down
```

### Sin Docker (XAMPP)

1. Copia la carpeta dentro de `htdocs`
2. Importa `database.sql` en MariaDB
3. Ajusta los datos de conexion en `config/database.php`
4. Abre `http://localhost/weather-app/`

---

## Despliegue en AWS

1. Lanza una instancia EC2 con Ubuntu
2. Instala Docker y Docker Compose
3. Sube el proyecto o clona desde GitHub
4. Ejecuta `docker compose up -d --build`
5. Abre el puerto 80 en el grupo de seguridad
6. Accede con la IP publica de la instancia

---

## Funcionalidades

- Busqueda de ciudades por nombre
- Si la ciudad no existe se muestra un error
- Tiempo actual: temperatura, humedad, presion, viento, visibilidad y nubosidad
- Prevision por horas: datos cada 3 horas para las proximas 24 horas
- Prevision semanal: un dato representativo por dia
- Graficas de barras en CSS para visualizar temperaturas
- Guardado automatico de cada consulta en la BD usando DAO
- Historial con todas las consultas realizadas (pagina opcional)

---

## Tecnologias

| Tecnologia | Uso |
|---|---|
| PHP 8.2 | Backend |
| Apache | Servidor web |
| MariaDB | Base de datos |
| PDO | Conexion a la BD |
| cURL | Llamadas a la API |
| HTML + CSS | Frontend |
| Docker + Compose | Despliegue |
| OpenWeatherMap API | Datos meteorologicos |

---

## Repositorio y acceso

- Repositorio GitHub: `https://github.com/tuusuario/weather-app`
- URL de la aplicacion: `http://IP_PUBLICA_AWS`
