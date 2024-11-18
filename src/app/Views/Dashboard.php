<div class="p-6">
  <!-- Page Title -->
  <div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-sm text-gray-600">Welcome back,
      <?php echo $_SESSION['user']['name']; ?>
      to your dashboard. Here's a quick overview of your data.
    </p>
  </div>

  <!-- Scrollable Content -->
  <div class="overflow-x-auto">
    <!-- Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <!-- Widget 1 -->
      <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold text-gray-700">Example 1</h2>
        <p class="mt-2 text-3xl font-bold text-gray-900">0</p>
        <p class="text-sm text-gray-500 mt-1">+0% since last week</p>
      </div>

      <!-- Widget 2 -->
      <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold text-gray-700">Example 2</h2>
        <p class="mt-2 text-3xl font-bold text-gray-600">0</p>
        <p class="text-sm text-gray-500 mt-1">+0% since last week</p>
      </div>

      <!-- Widget 3 -->
      <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-lg font-semibold text-gray-700">Example 3</h2>
        <p class="mt-2 text-3xl font-bold text-gray-500">0</p>
        <p class="text-sm text-gray-500 mt-1">+0% since week</p>
      </div>
    </div>
  </div>
</div>
