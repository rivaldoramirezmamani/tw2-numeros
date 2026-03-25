# AGENTS.md — Generador de Números Aleatorios (PHP OOP)

## Proyecto

Aplicación web PHP 7.4+ que genera números enteros aleatorios, los muestra en una tabla con estadísticas, y evita reenvíos de formulario mediante el patrón PRG.

**Ruta del proyecto:** `./` (raíz del proyecto)

---

## Comandos de ejecución y verificación

### Servidor de desarrollo PHP (built-in)

```bash
php -S localhost:8000 -t .
```

Acceder a: `http://localhost:8000/`

### Con Docker/Podman (puerto 8082)

```bash
http://172.25.0.225:8082/
```

### Verificación de sintaxis PHP

```bash
# Un archivo
php -l src/Validator.php

# Todos los archivos PHP recursivamente
find . -name '*.php' -exec php -l {} \;
```

### Validación de tipos y análisis estático

```bash
# Verificar declare(strict_types=1) en todos los archivos
grep -rn 'strict_types' .

# PHPStan (si está instalado)
phpstan analyse src/ --level=max
```

### PHPCS / PHPCBF (si está instalado)

```bash
# Verificar estilo
phpcs --standard=PSR12 .

# Auto-corregir estilo
phpcbf --standard=PSR12 .
```

### PHPUnit (si está instalado y hay tests/)

```bash
# Todos los tests
phpunit

# Un solo archivo de test
phpunit --filter ValidatorTest tests/ValidatorTest.php

# Con cobertura (si está configurado)
phpunit --coverage-text
```

### Commit y push

```bash
git add .
git commit -m "mensaje"
git push
```

---

## Estructura de archivos

```
./                              # Raíz del proyecto
├── index.php                  # Controlador principal (PRG)
├── src/
│   ├── Validator.php           # Valida inputs del formulario
│   ├── NumberGenerator.php     # Genera números aleatorios
│   ├── Statistics.php          # Calcula suma, promedio, min, max
│   └── Session.php             # Maneja lectura/escritura de sesión
├── views/
│   ├── layout.php              # Plantilla HTML base (head, body, CSS)
│   ├── form.php                # Formulario de entrada
│   ├── errors.php              # Lista de errores de validación
│   └── results.php             # Tabla de resultados y estadísticas
├── tests/                      # (opcional) Tests PHPUnit
├── README.md
└── AGENTS.md
```

---

## Convenciones de código

### General

- `declare(strict_types=1);` obligatorio en **todos** los archivos PHP.
- Programación orientada a objetos obligatoria en todos los archivos de lógica.
- Cada clase en su propio archivo.
- Fin de línea: LF (`\n`). Encoding: UTF-8.

### Imports / autoload

- Usar `require_once` para incluir las clases de `src/`.
- Alternativa: un `autoload.php` simple con `spl_autoload_register`.

### Tipos

- Usar tipos declarados en propiedades y métodos (PHP 7.4+ typed properties).
- Usar `filter_var()` con `FILTER_VALIDATE_INT` para validación de enteros.
- Retornar tipos explícitos en todos los métodos.

### Nomenclatura

- Clases: `PascalCase` (ej. `Validator`, `Session`).
- Métodos y propiedades: `camelCase` (ej. `getErrors()`, `$rangoMin`).
- Métodos estáticos de utilidad: `PascalCase` (ej. `Session::start()`).
- Variables y argumentos: `camelCase` (ej. `$formValues`, `$rangoMin`).
- Constantes: `UPPER_SNAKE_CASE` (ej. `DEFAULT_MIN`).
- Vistas: `snake_case.php`.

### Formato

- Indentación: 4 espacios.
- Llaves en línea nueva para clases y métodos.
- Un espacio después de la coma, none before.
- Operadores bin con espacios circundantes (`$a + $b`, `$n > 1`).
- Sin espacio entre nombre de función y paréntesis (`func()` no `func ()`).

### Control de flujo

- **`switch` PROHIBIDO.** Usar `match` (PHP 8) o `if/elseif/else`.
- **`break` en estructuras de control PROHIBIDO**, excepto en `case` (que no se usa).
- **Bucles infinitos PROHIBIDOS** (`while(true)`, `for(;;)`).
- Iteraciones: usar `foreach` o `for` con condición finita.

### Excepciones y errores

- Lanzar `Exception` con mensajes descriptivos en caso de error de validación interno.
- No suprimir errores con `@`.
- Validación de inputs del usuario → no lanzar excepciones; registrar en array `$errores`.

### Seguridad

- Escapar **toda** salida HTML con `htmlspecialchars($var, ENT_QUOTES, 'UTF-8')`.
- Nunca confiar en `$_POST` o `$_GET` sin validación.
- Regenerar ID de sesión tras login (si se añade auth).

### Vistas (views/)

- Variables pasadas desde el controlador, nunca acceder a `$_POST`/`$_GET` directamente.
- Usar `foreach` para iterar arrays.
- Incluir `layout.php` al final; este envuelve el contenido con `<html>`, `<head>` y `<body>`.

### CSS embebido (layout.php)

- Tema oscuro con variables CSS (`--color-bg`, `--color-surface`, `--color-accent`, etc.).
- Sin frameworks externos — CSS puro.
- Tabla responsiva con `overflow-x: auto` en móvil.
- Tarjetas de estadísticas con colores diferenciados por tipo (suma, promedio, min, max).

---

## Patrón PRG (Post-Redirect-Get)

1. `POST` → validar → guardar en sesión → `header('Location: index.php')` → `exit`.
2. `GET` → leer sesión → mostrar vista → `Session::remove()`.

```php
Session::start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator();
    if ($validator->validate($_POST)) {
        $generator = new NumberGenerator($validator->getN(), $validator->getRangoMin(), $validator->getRangoMax());
        $numeros = $generator->generate();
        $stats = new Statistics($numeros);
        Session::set('resultado', ['numeros' => $numeros, 'stats' => $stats]);
    } else {
        Session::set('errores', $validator->getErrors());
        Session::set('formValues', $_POST);
    }
    header('Location: index.php');
    exit;
}
```

---

## Clases

### `src/Session.php` (estática)
```
start(): void
set(string $key, mixed $value): void
get(string $key, mixed $default = null): mixed
remove(string $key): void
has(string $key): bool
```

### `src/Validator.php`
```
Propiedades privadas: errores[], n, rangoMin, rangoMax
validate(array $data): bool
getErrors(): array
getN(): int
getRangoMin(): int
getRangoMax(): int
```

### `src/NumberGenerator.php`
```
__construct(int $n, int $min, int $max)
generate(): array<int>
```

### `src/Statistics.php`
```
__construct(array $numeros)
getSuma(): int
getPromedio(): float  (2 decimales)
getMinimo(): int
getMaximo(): int
```

---

## Reglas de validación

| Campo        | Regla                              |
|-------------|------------------------------------|
| `n`          | Entero positivo, 1–1000            |
| `rango_min`  | Entero, 1–10000                    |
| `rango_max`  | Entero, 1–10000                    |
| `rango_min`  | Debe ser menor que `rango_max`     |
