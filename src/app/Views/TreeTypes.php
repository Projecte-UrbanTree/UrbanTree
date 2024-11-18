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
        Create Tree Type
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full table-fixed bg-white border border-gray-300 rounded-lg shadow-md">
        <thead>
            <tr class="bg-gray-700 text-white text-left h-14">
                <th class="px-4 py-2 border-b">ID</th>
                <th class="px-4 py-2 border-b">Family</th>
                <th class="px-4 py-2 border-b">Genus</th>
                <th class="px-4 py-2 border-b">Species</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tree_types as $tree_type) { ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border-b">
                    <?php echo $tree_type->getId(); ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $tree_type->family; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $tree_type->genus; ?></td>
                <td class="px-4 py-2 border-b">
                    <?php echo $tree_type->species; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
