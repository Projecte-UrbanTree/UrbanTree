<div class="mb-4 flex justify-end">
    <a href="/contracts"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500 flex items-center space-x-2">
        <!-- Heroicon for return/back (chevron-left) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>Return to Contract</span>
    </a>
</div>

<div class="bg-white p-8 border border-gray-300 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Contract</h2>
    <form action="/contracts/store" method="POST" class="space-y-6">
    
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" id="name" name="name"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

      
        
        <!-- Start Date -->

        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
            <input type="text" id="start_date" name="start_date"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>

        <!-- End Date -->


        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
            <input type="text" id="end_date" name="end_date"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>


        <div>
            <label for="invoice_proposed" class="block text-sm font-medium text-gray-700 mb-1">Invoice Proposed</label>
            <input type="number" step="0.01" id="invoice_proposed" name="invoice_proposed"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
           required>
        </div>


        <div>
            <label for="invoice_agreed" class="block text-sm font-medium text-gray-700 mb-1">Invoice agreed</label>
            <input type="text" id="invoice_agreed" name="invoice_agreed"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>



        <div>
            <label for="invoice_paid" class="block text-sm font-medium text-gray-700 mb-1">Invoice paid</label>
            <input type="text" id="invoice_paid" name="invoice_paid"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>



        <div>
            <label for="created_ad" class="block text-sm font-medium text-gray-700 mb-1">Created ad</label>
            <input type="text" id="created_ad" name="created_ad"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500"
                   required>
        </div>


        <!-- Submit Button -->
        <div class="flex items-center">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                Create Contract
            </button>
        </div>
    </form>
</div>
