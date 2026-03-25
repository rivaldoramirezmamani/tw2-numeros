# Generador de Números Aleatorios — PHP OOP

Aplicación web en PHP 7.4+ que genera números enteros aleatorios, los muestra en una tabla con estadísticas, y evita reenvíos de formulario mediante el patrón PRG (Post-Redirect-Get).

---

## Requisitos

- PHP 7.4 o superior
- Servidor web (Apache, Nginx) o servidor PHP built-in

---

## Ejecución

### Servidor PHP built-in

```bash
php -S localhost:8000 -t .
```

Acceder en: `http://localhost:8000/`

### Docker / Podman

```bash
http://172.25.0.225:8082/
```

---

## Estructura del proyecto

```
./                              # Raíz del proyecto
├── index.php          # Controlador principal (patrón PRG)
├── src/
│   ├── Session.php    # Gestión de sesiones
│   ├── Validator.php # Validación de inputs
│   ├── NumberGenerator.php  # Generación de números aleatorios
│   └── Statistics.php # Cálculo de estadísticas
└── views/
    ├── layout.php     # Plantilla HTML + CSS
    ├── form.php       # Formulario de entrada
    ├── errors.php     # Mensajes de error
    └── results.php    # Tabla de resultados
```

---

## Verificación de sintaxis

```bash
find . -name '*.php' -exec php -l {} \;
```

---

## Validación de código

```bash
# PHPStan (si está instalado)
phpstan analyse src/ --level=max

# PHPCS (si está instalado)
phpcs --standard=PSR12 .
```

---

## Tecnologías

- PHP 7.4+ con `declare(strict_types=1)`
- Programación orientada a objetos
- Patrón PRG para evitar reenvíos de formulario
- CSS puro, tema oscuro, sin frameworks externos
