<!DOCTYPE html>
<html lang="ca">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista d'Ordres</title>
    </head>
    <body class="bg-gray-100 p-8">
        <h1 class="text-2xl font-bold mb-4">Ordre de Treball</h1>
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded mb-4" onclick="window.location.href='/order/create'">
            Crear Ordre
        </button>
         
         <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden shadow-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border-b">Contracte</th>
                    <th class="py-2 px-4 border-b">Data</th>
                    <th class="py-2 px-4 border-b">Zones</th>
                    <th class="py-2 px-4 border-b">Tasques</th>
                    <th class="py-2 px-4 border-b">Operaris</th>
                    <th class="py-2 px-4 border-b">Notes</th>
                    <th class="py-2 px-4 border-b">Estat</th>
                    <th class="py-2 px-4 border-b">Opcions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php foreach ($order->tasks() as $task): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-2 px-4"><?php echo $order->contract()->name; ?></td>
                        <td class="py-2 px-4"><?php echo $order->getCreatedAt(); ?></td>
                        <td class="py-2 px-4">
                            <?php foreach ($task->zones() as $zone): ?>
                                <?php echo $zone->name; ?>,
                            <?php endforeach; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php foreach ($task->taskTypes() as $task_type): ?>
                                <?php echo $task_type->name; ?>,
                            <?php endforeach; ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php foreach ($task->workers() as $worker): ?>
                                <?php echo $worker->name; ?>,
                            <?php endforeach; ?>
                        </td>
                        <td class="py-2 px-4"><?php echo $task->notes; ?></td>
                        <td class="py-2 px-4"></td>
                        <td class="py-2 px-4">
                        <button class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-2 rounded mr-2" onclick="window.location.href='/order/edit/<?php echo $order->getId(); ?>'">
                            Editar
                        </button>

                        <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-2 rounded" onclick="deleteOrder(<?php echo $order->getId(); ?>)">
                            Eliminar
                        </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
         </table>
            <script>
            function deleteOrder(orderId) {
                if (confirm("Â¿EstÃ¡s seguro de que deseas eliminar esta orden?")) {
                    window.location.href = `/orders/delete/${orderId}`;
                }
            }
            </script>
    </body>
</html>