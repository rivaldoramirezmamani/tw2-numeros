<form method="POST" action="index.php">
    <label for="n">
        Cantidad de números
        <span class="label-hint">(1–1000)</span>
    </label>
    <input
        type="number"
        id="n"
        name="n"
        min="1"
        max="1000"
        value="<?php echo htmlspecialchars($formValues['n'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
        placeholder="Ej: 10"
        required
    >

    <div class="input-row">
        <div>
            <label for="rango_min">
                Rango mínimo
                <span class="label-hint">(1–10000)</span>
            </label>
            <input
                type="number"
                id="rango_min"
                name="rango_min"
                min="1"
                max="10000"
                value="<?php echo htmlspecialchars($formValues['rango_min'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                placeholder="Ej: 1"
            >
        </div>
        <div>
            <label for="rango_max">
                Rango máximo
                <span class="label-hint">(1–10000)</span>
            </label>
            <input
                type="number"
                id="rango_max"
                name="rango_max"
                min="1"
                max="10000"
                value="<?php echo htmlspecialchars($formValues['rango_max'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                placeholder="Ej: 100"
            >
        </div>
    </div>

    <button type="submit">Generar</button>
</form>
