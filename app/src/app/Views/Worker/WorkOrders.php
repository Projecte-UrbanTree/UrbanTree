<div class="mt-8 max-w-4xl mx-auto p-6 border rounded-md shadow-md bg-white">
    <h1 class="text-4xl font-bold text-center mt-8">Órdenes de Trabajo</h1>

    <div class="flex items-center justify-center mt-4 gap-4">
        <button id="prev-day" class="bg-blue-500 text-white rounded-full p-3 hover:bg-blue-600">
            <i class="fas fa-chevron-left"></i>
        </button>

        <input type="date" id="date-input" class="text-center border border-gray-300 rounded-md py-2 px-4 w-40" readonly
            value="<?= htmlspecialchars($date ?? date('Y-m-d')) ?>" />

        <button id="next-day" class="bg-blue-500 text-white rounded-full p-3 hover:bg-blue-600">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <?php if (!empty($work_orders)): ?>
        <div>
            <p class="mt-4 text-lg font-medium text-gray-700">Operarios asignados:</p>
            <?php
            $assignedUsers = [];
            foreach ($work_order->users() as $user) {
                $fullName = $user->name . ' ' . $user->surname;
                if (!in_array($fullName, $assignedUsers)) {
                    $assignedUsers[] = $fullName;
                }
            }
            ?>
            <input type="text" readonly class="text-center border border-gray-300 rounded-md py-2 px-4 w-full"
                value="<?= implode(', ', $assignedUsers) ?>">
        </div>

        <div class="mt-4">
            <p class="text-lg font-medium text-gray-700">Notas:</p>
            <div class="mt-2">
                <h2 class="text-md font-semibold text-gray-800">Orden de Trabajo ID:
                    <?= htmlspecialchars($work_order->id) ?>
                </h2>
                <?php foreach ($work_order->blocks as $block): ?>
                    <?php echo htmlspecialchars($blocks->notes) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-600">No hay órdenes de trabajo para esta fecha.</p>
    <?php endif; ?>
</div>