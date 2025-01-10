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
</script>
<script src="/assets/js/stats.js?v=<?= time(); ?>"></script>
<!--
		<script>
				window.Promise ||
						document.write(
								'<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>' +
								'<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>' +
								'<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
						);
		</script>

		<script src="https://cdn.jsdelivr.net/npm/react@16.12/umd/react.production.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/react-dom@16.12/umd/react-dom.production.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/prop-types@15.7.2/prop-types.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
		<script src="https://cdn.jsdelivr.net/npm/react-apexcharts@1.3.6/dist/react-apexcharts.iife.min.js"></script> -->