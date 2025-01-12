## Descripción

Este proyecto es una API REST conectada a Giphy. La aplicación ofrece cuatro endpoints:

- **Login**: Autenticación de usuario.
- **Search**: Devuelve una colección de GIFs.
- **Show**: Recupera un GIF específico por su ID.
- **Add Favorite**: Guarda un GIF en la lista de favoritos del usuario.

El sistema está desarrollado con Laravel 10 y PHP 8.2. Utiliza contenedores Docker gestionados mediante Docker Compose, levantando servicios que incluyen:

- **Base de datos**: MySQL 8
- **Servidor web**: Nginx para gestionar las rutas de Laravel

## Requisitos
- Docker
- Docker Compose

## Instalación

1. Clona el repositorio y accede al directorio del proyecto:
   ```bash  
   git clone https://github.com/gabriela-bot/challenge_php.git 
   cd challenge_php  
   ```  

2. Construye y levanta los contenedores:
   ```bash  
   docker compose up --build -d  
   ```  

3. Ejecuta las migraciones:
   ```bash  
   docker compose exec app start_container  
   ```  

## Uso

- El sistema inicializa automáticamente con las migraciones, un usuario de prueba y un cliente personal de Passport.

### Usuarios demo
- **Email:** `test@example.com`
- **Contraseña:** `password`

### Integración API Giphy
Para obtener una clave diferente para la API de Giphy, visita:  
[Obtener clave Giphy API](https://developers.giphy.com/dashboard/)

## Endpoints

- **POST `/api/login`**  
  Autenticación de usuario.

- **GET `/api/gifs`**  
  Obtiene una colección de GIFs según la query enviada.

- **GET `/api/gif/:id`**  
  Obtiene los datos del GIF seleccionado.

- **POST `/api/add-favorite`**  
  Añade un GIF a favoritos del usuario.

### Colección Postman
La colección de endpoints está disponible en [Postman](https://www.postman.com/ducknaruto/challenge-php/overview).

## Tests
Para ejecutar los tests, utiliza el siguiente comando:
```bash  
docker compose exec app php artisan test  
```  
### Documentacion

#### UML

![UML](https://github.com/gabriela-bot/challenge_php/blob/main/doc/UML.png)

#### DER

![DER.png](https://github.com/gabriela-bot/challenge_php/blob/main/doc/DER.png)

#### Secuencia de casos de usos

![Autenticación.png](https://github.com/gabriela-bot/challenge_php/blob/main/doc/Autenticaci%C3%B3n.png)

![ColeccionGifs.png](https://github.com/gabriela-bot/challenge_php/blob/main/doc/ColeccionGifs.png)

![ById.png](https://github.com/gabriela-bot/challenge_php/blob/main/doc/ById.png)

![Favorito.png](https://github.com/gabriela-bot/challenge_php/blob/main/doc/Favorito.png)


