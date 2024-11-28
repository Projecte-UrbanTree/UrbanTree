<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Contract</h2>


    <div id="errorMessages"
        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 hidden"></div>

    <form id="contractForm" action="/contracts/<?php echo htmlspecialchars($contract->getId()); ?>/update" method="POST"
        class="space-y-6">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($contract->name); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>


        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
            <input type="datetime-local" id="start_date" name="start_date"
                value="<?php echo htmlspecialchars($contract->start_date); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>


        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
            <input type="datetime-local" id="end_date" name="end_date"
                value="<?php echo htmlspecialchars($contract->end_date); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="invoice_proposed" class="block text-sm font-medium text-gray-700 mb-1">Invoice Proposed</label>
            <input type="number" step="0.01" id="invoice_proposed" name="invoice_proposed"
                value="<?php echo htmlspecialchars($contract->invoice_proposed); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="invoice_agreed" class="block text-sm font-medium text-gray-700 mb-1">Invoice Agreed</label>
            <input type="number" step="0.01" id="invoice_agreed" name="invoice_agreed"
                value="<?php echo htmlspecialchars($contract->invoice_agreed); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="invoice_paid" class="block text-sm font-medium text-gray-700 mb-1">Invoice Paid</label>
            <input type="number" step="0.01" id="invoice_paid" name="invoice_paid"
                value="<?php echo htmlspecialchars($contract->invoice_paid); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500">
        </div>

        <button type="button" id="submitBtn"
            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
            Update Contract
        </button>
    </form>
</div>

<script src="/assets/js/app.js"></script>
<script>
    document.getElementById('submitBtn').addEventListener('click', function (event) {
        const errorMessagesDiv = document.getElementById('errorMessages');
        validateForm(event);

        if (errorMessagesDiv.innerHTML.trim() !== '') {
            errorMessagesDiv.classList.remove('hidden');
        } else {
            errorMessagesDiv.classList.add('hidden');
        }
    });
</script>