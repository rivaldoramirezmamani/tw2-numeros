<?php if (count($resultado['numeros']) === 0): ?>
    <p class="empty">No se generaron números.</p>
<?php else: ?>
    <div class="stats-grid">
        <div class="stat-card stat-suma">
            <div class="stat-label">Suma</div>
            <div class="stat-value">
                <?php echo htmlspecialchars((string) $resultado['stats']['suma'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>
        <div class="stat-card stat-promedio">
            <div class="stat-label">Promedio</div>
            <div class="stat-value">
                <?php echo htmlspecialchars((string) $resultado['stats']['promedio'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>
        <div class="stat-card stat-minimo">
            <div class="stat-label">Mínimo</div>
            <div class="stat-value">
                <?php echo htmlspecialchars((string) $resultado['stats']['minimo'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>
        <div class="stat-card stat-maximo">
            <div class="stat-label">Máximo</div>
            <div class="stat-value">
                <?php echo htmlspecialchars((string) $resultado['stats']['maximo'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Índice</th>
                    <th>Número</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado['numeros'] as $indice => $numero): ?>
                <tr>
                    <td><?php echo htmlspecialchars((string) ($indice + 1), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars((string) $numero, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
