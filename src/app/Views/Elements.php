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
    <a href="#"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow focus:outline-none focus:ring focus:ring-green-500">
        Create Element
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full table-fixed bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-700 text-white text-left h-14">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Name</th>
                <th class="px-4 py-2 border-b">Zone Name</th>
                <th class="px-4 py-2 border-b">Zone Postal Code</th>
                <th class="px-4 py-2 border-b">Species</th>
                <th class="px-4 py-2 border-b">Latitude</th>
                <th class="px-4 py-2 border-b">Longitude</th>
                <th class="px-4 py-2 border-b">Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($elements as $element) { ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b">
                    <?php echo $element->getId(); ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $element->name; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $element->zone()->name; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $element->zone()->postal_code; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $element->treeType()->species; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $element->point()->latitude; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $element->point()->longitude; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $element->getCreatedAt(); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
