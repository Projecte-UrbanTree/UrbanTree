<?php

use App\Core\Session;

?>

<?php if (Session::has('success')) { ?>
    <div id="alert-msg" class="bg-blue-500 text-white px-4 py-3 rounded-lg mb-6" role="alert">
        <strong class="font-bold">Success: </strong>
        <span><?php echo htmlspecialchars(Session::get('success')); ?></span>
    </div>
<?php } ?>

<div class="mb-4 flex justify-end">
    <a href="/contract/create"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
        Create Contract
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full table-fixed bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-700 text-white text-left h-14">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Start Date</th>
                <th class="px-4 py-2 border-b">End Date</th>
                <th class="px-4 py-2 border-b">Invoice proposed</th>
                <th class="px-4 py-2 border-b">Invoice agreed</th>
                <th class="px-4 py-2 border-b">Invoice paid</th>
                <th class="px-4 py-2 border-b">Created at</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contracts as $contract) { ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->getId(); ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->name; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->start_date; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->end_date; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->invoice_proposed; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->invoice_agreed; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->invoice_paid; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $contract->getCreatedAt(); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
