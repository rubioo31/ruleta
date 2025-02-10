# Aplicación de Apuestas: Ruleta y Validación de Usuario

## Descripción

Esta aplicación es una plataforma interactiva de apuestas que integra las siguientes funcionalidades:

- **Autenticación de Usuario:**  
  Se utiliza autenticación HTTP básica mediante un archivo `.htpasswd` para restringir el acceso a usuarios autorizados.

- **Validación de Usuario:**  
  El usuario debe subir un documento personal con sus datos (por ejemplo, fecha de nacimiento) para validar que es mayor de 18 años y poder participar en las apuestas.

- **Gestión de Saldo:**  
  El saldo de cada usuario se almacena en el archivo `saldoCuenta.txt`. Cada apuesta actualiza el saldo según el resultado (ganancia o pérdida).

- **Apuestas y Ruleta:**  
  La aplicación ofrece una interfaz interactiva de ruleta en la que el usuario puede apostar:
  - A un **número específico**.
  - A **colores** (rojo o negro).
  - A **pares** o **impares**.  
  Se genera un resultado aleatorio y se calcula la ganancia según el tipo de apuesta.

---

## Tecnologías Utilizadas

- **PHP:**  
  Para la lógica del servidor, procesamiento de apuestas, manejo de archivos y autenticación.

- **HTML y CSS:**  
  Para la estructura y el diseño de las vistas.  
  Se utilizan estilos personalizados para la vista de validación y la de la ruleta.

- **JavaScript:**  
  Para mostrar mensajes emergentes con los resultados de las apuestas.

- **XAMPP:**  
  Para el alojamiento y la ejecución de la aplicación en entorno local.

## Estructura del Proyecto
```
/tu-proyecto
├── app
│   ├── controllers
│   │   ├── auth.php          # Controlador de autenticación 
│   │   ├── apuesta.php       # Lógica para procesar las apuestas
│   │   └── upload.php        # Controlador para la subida y procesamiento de archivos
│   ├── models
│   │   └── saldo.php         # Funciones para leer y actualizar el saldo del usuario
│   └── views
│       ├── index.php         # Vista de validación de usuario (subida de archivo, zona, idioma)
│       └── ruleta.php        # Vista de la ruleta y formulario de apuestas
├── public
│   └── css
│       ├── style.css         # Estilos para la vista de la ruleta (tablero, formulario de apuestas, etc.)
│       └── validacion.css    # Estilos para la vista de validación de usuario
│   
├── storage
│   └── documentosPersonales  # Carpeta para almacenar los archivos subidos por el usuario
├── saldoCuenta.txt           # Archivo que guarda el saldo de cada usuario (formato: usuario,saldo)
├── .htpasswd                 # Archivo de credenciales para autenticación HTTP básica
├── logout.php                # Archivo para cerrar sesion
└── index.php                 # Front Controller que maneja el enrutamiento y carga de vistas/controladores

```
---

## Uso de la Aplicación

- **Validación de Usuario:**  
  El usuario debe subir un archivo que contenga sus datos personales. La aplicación extrae la fecha de nacimiento para verificar que es mayor de 18 años. Si la validación es exitosa, se permite el acceso a la página de apuestas.

- **Gestión del Saldo:**  
  El saldo inicial se carga desde `saldoCuenta.txt`. Cada apuesta resta el monto apostado y suma las ganancias en caso de acierto.

- **Realización de Apuestas:**
  - **Apuesta a Numero:**  
    El usuario indica el numero al que apostar.
  - **Apuesta a Color, Pares o Impares:**  
    Mediante un selector en el formulario, el usuario puede elegir apostar al color (rojo o negro), a números pares o impares.
  - Se genera un número ganador aleatorio para cada apuesta o para la apuesta en color/pares/impares, y se calcula la ganancia de acuerdo a la modalidad de apuesta.
  - El resultado se muestra al usuario mediante un alert, y el saldo se actualiza en la interfaz.
