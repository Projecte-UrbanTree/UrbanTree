<!DOCTYPE html>
<html lang="ca">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ordres</title>
    </head>
    <body class="bg-gray-100 p-8">
        <h1 class="text-2xl font-bold mb-4">Crear Ordre de Treball</h1>

        <form action="/orders/store" method="POST">
            <label for="order_name">Nom de l'Ordre:</label>
            <input type="text" id="order_name" name="order_name" required>

            <label for="contract">Contracte:</label>
            <select id="contract" name="contract_id" required>
                <option value="">Selecciona un contracte</option>
                <?php foreach ($contracts as $contract): ?>
                    <option value="<?php echo htmlspecialchars($contract['id']); ?>">
                        <?php echo htmlspecialchars($contract['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="order_date">Data:</label>
            <input type="date" id="order_date" name="order_date" required>

            <button type="submit">Crear Ordre</button>
        </form>
    </body>
</html>