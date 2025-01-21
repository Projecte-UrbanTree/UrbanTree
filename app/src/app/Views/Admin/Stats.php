<?php
function mapWithId($items, $getIdMethod)
{
    return array_map(function ($item) use ($getIdMethod) {
        $properties = get_object_vars($item);
        $properties['id'] = $item->$getIdMethod();

        return (object) $properties;
    }, $items);
}
?>

<div class="mb-4 flex justify-end">
	<a href="/admin" class="px-4 py-2 bg-gray-700 text-white shadow-sm hover:bg-gray-500 transition-all duration-200 rounded">
		<i class="fas fa-arrow-left mr-2"></i> Volver al Dashboard
	</a>
</div>
<div id="charts-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
	<div class="col bg-white p-4 border border-gray-200 rounded shadow-sm">
		<h3 class="text-xl font-semibold text-gray-800 mb-4">Tareas Hechas vs No Hechas</h3>
		<div id="app1"></div>
	</div>
	<div class="col bg-white p-4 border border-gray-200 rounded shadow-sm">
		<h3 class="text-xl font-semibold text-gray-800 mb-4">Horas Trabajadas</h3>
		<div id="app2"></div>
	</div>
	<div class="col bg-white p-4 border border-gray-200 rounded shadow-sm">
		<h3 class="text-xl font-semibold text-gray-800 mb-4">Consumo de Gasoil</h3>
		<div id="app3"></div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
	const tasksDoneCount = <?= json_encode($tasksDoneCount); ?>;
	const tasksNotDoneCount = <?= json_encode($tasksNotDoneCount); ?>;
	const hoursWorked = <?= json_encode($hoursWorked); ?>;
	const fuelConsumption = <?= json_encode($fuelConsumption); ?>;
</script>
<script src="/assets/js/stats.js?v=<?= time(); ?>"></script>
