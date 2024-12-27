<div id="map" class="relative">
        <!-- Botón para abrir el primer panel -->
        <button class="absolute z-10 bottom-5 right-5 p-2 bg-blue-500 text-white rounded-full" id="openMore">
            <span class="material-icons">+</span>
        </button>

        <!-- Primer Panel -->
        <div id="firstPanel" class="absolute z-10 bottom-0 right-20 bg-white shadow-lg sm:w-60 h-1/4 p-5 hidden">
            <button class="text-lg font-semibold mb-4" id="openFilters">
                Filtros
            </button>
            <button class="text-lg font-semibold mb-4" id="openElements">
                Agregar Elementos
            </button>
            <button class="text-lg font-semibold" id="openZones">
                Agregar Zonas
            </button>
        </div>

        <!-- Panel de filtros -->
        <div id="filterPanel" class="absolute z-10 bottom-0 right-80 bg-white shadow-lg sm:w-64 h-1/4 p-5 hidden">
            <div class="space-y-2">
                <label class="block">
                    <input type="checkbox" class="mr-2" /> Zonas
                </label>
                <label class="block">
                    <input type="checkbox" class="mr-2" /> Elementos
                </label>
                <label class="block">
                    <input type="checkbox" class="mr-2" /> Opción 3
                </label>
            </div>
            <button class="mt-4 p-2 bg-blue-500 text-white rounded-full">
                Aplicar
            </button>
        </div>
    </div>
<script src="/assets/js/inventary.js"></script>
