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

<div class="max-w-6xl mx-auto my-16">
	<div id="charts-container" class="grid grid-cols-3 gap-4 bg-gray-100 relative">
		<div class="col" id="app1"></div>
		<div class="col" id="app2"></div>
		<div class="col" id="app3"></div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
	const tasks = <?= json_encode($tasks); ?>;
	const taskTypes = <?= json_encode($taskTypes); ?>;
	const treeTypes = <?= json_encode($treeTypes); ?>;
</script>
<script src="/assets/js/stats.js?v=<?= time(); ?>"></script>
