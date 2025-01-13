<div class="mt-8 max-w-3xl mx-auto p-8 border rounded-lg shadow-lg bg-white text-center">
    <h1 class="text-4xl font-bold mb-6 text-gray-800">Órdenes de Trabajo</h1>

    <!-- Date picker -->
    <div class="flex items-center justify-center mb-6 space-x-4">
        <button id="prev-day" class="bg-blue-500 text-white rounded-full p-3 hover:bg-blue-600 shadow-md">
            <i class="fas fa-chevron-left"></i>
        </button>

        <input type="date" id="date-input" 
            class="text-center border border-gray-300 rounded-lg py-2 px-4 w-48 focus:ring-2 focus:ring-blue-500 focus:outline-none"
            value="<?= htmlspecialchars($date ?? date('Y-m-d')) ?>" />

        <button id="next-day" class="bg-blue-500 text-white rounded-full p-3 hover:bg-blue-600 shadow-md">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <?php if (!empty($work_orders)): ?>
        <?php foreach ($work_orders as $work_order): ?>
            <form method="POST" action="/worker/work-orders/update-status">
                <input type="hidden" name="work_order_id" value="<?= $work_order->getId() ?>">
                <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
                <!-- Users -->
                <div class="mt-6">
                    <p class="text-lg font-semibold">Usuarios asignados:</p>
                    <input type="text" readonly
                        class="text-center border border-gray-300 rounded-md py-2 px-4 w-full mt-2 bg-gray-100"
                        value="<?= implode(', ', array_map(fn($user) => $user->name . ' ' . $user->surname, $work_order->users())) ?>" />
                </div>
        
                <!-- Tasktype and Species -->
                <div>
                    <?php foreach ($work_order->blocks() as $block): ?>
                        <p class="text-lg font-semibold text-gray-800">Tipo de Tareas</p>
                        <ul class="list-disc list-inside">
                            <?php foreach ($block->tasks() as $blockTask): ?>
                                <li class="flex items-center space-x-2">
                                <input type="hidden" name="tasks[<?= $blockTask->getId() ?>]" value="0">
                                <input 
                                    type="checkbox" 
                                    name="tasks[<?= $blockTask->getId() ?>]" 
                                    value="1" 
                                    class="form-checkbox text-blue-500 rounded-md focus:ring-2 focus:ring-blue-400"
                                    <?= $blockTask->status == 1 ? 'checked' : '' ?>
                                />
                                    <span>
                                        <?= htmlspecialchars($blockTask->task()->name) ?>
                                        <?php if ($blockTask->treeType() != null): ?>
                                            : <?= htmlspecialchars($blockTask->treeType()->species) ?>
                                        <?php endif; ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>
                </div>    

                <!-- Notes -->
                <div>
                    <p class="text-lg font-semibold text-gray-800">Notas:</p>
                    <?php foreach ($work_order->blocks() as $block): ?>
                        <p class="mt-2 text-gray-700 bg-gray-100 rounded-md p-3 shadow-sm">
                            <?= htmlspecialchars($block->notes) ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-full">
                    Enviar
                </button>
            </form>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-gray-600 mt-6">No hay órdenes de trabajo para esta fecha.</p>
    <?php endif; ?>
</div>

<script>
    const dateInput = document.getElementById("date-input");
    const prevDay = document.getElementById("prev-day");
    const nextDay = document.getElementById("next-day");

    function changeDate(days) {
        const currentDate = new Date(dateInput.value);
        currentDate.setDate(currentDate.getDate() + days);
        dateInput.value = currentDate.toISOString().split("T")[0];

        const newUrl = `${window.location.pathname}?date=${dateInput.value}`;
        window.location.href = newUrl;
    }

    prevDay.addEventListener("click", () => changeDate(-1));
    nextDay.addEventListener("click", () => changeDate(1));
</script>