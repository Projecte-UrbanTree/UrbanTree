document.addEventListener("DOMContentLoaded", () => {
    const preloader = document.getElementById("preloader");
    const zoneButton = document.getElementById("zone-control");
    const elementButton = document.getElementById("element-control");
    const createButton = document.getElementById("create-control");
    const finishButton = document.getElementById("finish-control");
    const cancelZoneButton = document.createElement("button");
    const contractSelect = document.getElementById("contractBtn");
    const inventoryContainer = document.querySelector("#filters");
    const elementModal = document.getElementById("element-modal");
    const elementModalTitle = document.getElementById("element-modal-title");
    const elementModalContent = document.getElementById("element-modal-content");
    const elementModalClose = document.getElementById("element-modal-close");
    const createElementModal = document.getElementById("create-element-modal");
    const createElementForm = document.getElementById("create-element-form");
    const createElementType = document.getElementById("element-type");
    const createElementDescription = document.getElementById("element-description");
    const createElementTreeType = document.getElementById("element-tree-type");
    const treeTypeContainer = document.getElementById("tree-type-container");
    const createElementCancel = document.getElementById("create-element-cancel");
    const toggleInventoryButton = document.getElementById("toggle-inventory");
    const inventorySidebar = document.querySelector(".inventory");
    const mapContainer = document.querySelector(".map");

    let editor_mode = "none";
    let editor_status = "none";
    let markers = {};
    let zonesData = [];
    let zonePoints = [];
    let tempMarkers = [];
    let selectedZone = null;
    let elementTypes = [];
    let treeTypes = [];

    // Initialize the map
    mapboxgl.accessToken = "pk.eyJ1IjoidXJiYW50cmVlIiwiYSI6ImNtNHI4MXNhaTAxc3gybHNpMWp3ejJldHcifQ.d94SBSjOt6Ylu4A8PKPFiQ";
    const map = new mapboxgl.Map({
        container: "map",
        center: [0.5826405437646912, 40.70973485628924],
        style: "mapbox://styles/mapbox/standard-satellite",
        zoom: 15,
    });

    // Event listeners
    elementModalClose.addEventListener("click", () => elementModal.classList.add("hidden"));
    createElementCancel.addEventListener("click", () => createElementModal.classList.add("hidden"));
    toggleInventoryButton.addEventListener("click", () => {
        inventorySidebar.classList.toggle("hidden");
        inventorySidebar.classList.toggle("w-5/6");
        mapContainer.classList.toggle("w-1/6");
    });

    createButton.addEventListener("click", handleCreateButtonClick);
    cancelZoneButton.addEventListener("click", handleCancelZoneButtonClick);
    finishButton.addEventListener("click", handleFinishButtonClick);
    createElementForm.addEventListener("submit", handleCreateElementFormSubmit);
    createElementType.addEventListener("change", handleCreateElementTypeChange);
    map.on("click", handleMapClick);
    map.on("load", fetchZones);

    // Functions
    function hidePreloader() {
        preloader.style.display = "none";
    }

    function handleCreateButtonClick() {
        if (editor_status === "create") {
            deactivateCreateMode();
        } else if (editor_mode === "zone") {
            activateZoneCreateMode();
        } else if (editor_mode === "element") {
            activateElementCreateMode();
        }
    }

    function handleCancelZoneButtonClick() {
        editor_status = "none";
        zonePoints = [];
        tempMarkers.forEach((marker) => marker.remove());
        tempMarkers = [];
        finishButton.classList.add("hidden");
        cancelZoneButton.classList.add("hidden");
        createButton.classList.remove("text-gray-300");
        createButton.classList.add("text-gray-700");
        createButton.removeAttribute("disabled");
        elementButton.classList.remove("text-gray-300");
        elementButton.classList.add("text-gray-700");
        elementButton.removeAttribute("disabled");
        alert("Creación de zona cancelada.");
    }

    function handleFinishButtonClick() {
        if (editor_mode === "zone" && editor_status === "create") {
            if (zonePoints.length < 4) {
                alert("Una zona debe tener al menos cuatro puntos.");
                return;
            }

            if (zonesCollide(zonePoints)) {
                alert("La nueva zona colisiona con una zona existente.");
                return;
            }

            const newZone = {
                id: getNextZoneId(),
                name: `Zona ${getNextZoneId()}`,
                description: "",
                color: "#FF0000",
                points: zonePoints,
                element_types: [],
            };

            createZone(newZone);
        }
    }

    function handleCreateElementFormSubmit(e) {
        e.preventDefault();
        const elementType = createElementType.value;
        const description = createElementDescription.value;
        const treeTypeId = createElementTreeType.value;
        const [lng, lat] = selectedZone.point;

        const bodyData = {
            zone_id: selectedZone.id,
            element_type_id: elementType,
            description: description,
            latitude: lat,
            longitude: lng,
            tree_type_id: treeTypeId
        };

        createElement(bodyData);
    }

    function handleCreateElementTypeChange() {
        const selectedTypeId = parseInt(createElementType.value);
        const selectedType = elementTypes.find(t => t.id === selectedTypeId);
        if (selectedType.requires_tree_type) {
            createElementTreeType.innerHTML = "";
            treeTypes.forEach((tree) => {
                const option = document.createElement("option");
                option.value = tree.id;
                option.text = tree.species;
                createElementTreeType.appendChild(option);
            });
            treeTypeContainer.classList.remove("hidden");
        } else {
            treeTypeContainer.classList.add("hidden");
        }
    }

    function handleMapClick(e) {
        if (editor_mode === "zone" && editor_status === "create") {
            const { lng, lat } = e.lngLat;
            zonePoints.push([lng, lat]);
            console.log("Point added:", [lng, lat]);

            const markerElement = document.createElement("div");
            markerElement.style.cssText =
                "width: 30px; height: 30px; background-color: red; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;";
            markerElement.innerText = zonePoints.length;
            const marker = new mapboxgl.Marker({ element: markerElement })
                .setLngLat([lng, lat])
                .addTo(map);
            tempMarkers.push(marker);
        } else if (editor_mode === "element" && editor_status === "create") {
            console.log("Element mode clicked.");
            const { lng, lat } = e.lngLat;
            const point = turf.point([lng, lat]);

            const zone = zonesData.zones.find((zone) => {
                const numericPoints = zone.points.map(([lngStr, latStr]) => [
                    parseFloat(lngStr),
                    parseFloat(latStr),
                ]);

                const polygon = turf.polygon([[...numericPoints, numericPoints[0]]]);
                console.log("Checking point in polygon:", point, polygon);
                return turf.booleanPointInPolygon(point, polygon);
            });

            if (zone) {
                showCreateElementModal(zone, [lng, lat]);
            } else {
                alert("El elemento debe estar dentro de una zona.");
            }
        }
    }

    function setEditorMode(mode) {
        const activeButton = document.getElementById(`${mode}-control`);

        if (
            activeButton.classList.contains("font-semibold") &&
            activeButton.classList.contains("text-primary")
        ) {
            zoneButton.classList.remove("font-semibold", "text-primary");
            zoneButton.classList.add("text-gray-700");

            elementButton.classList.remove("font-semibold", "text-primary");
            elementButton.classList.add("text-gray-700");

            createButton.classList.remove("text-gray-700");
            createButton.classList.add("text-gray-300");
            createButton.setAttribute("disabled", "true");

            editor_mode = "none";
        } else {
            elementButton.classList.remove("font-semibold", "text-primary");
            elementButton.classList.add("text-gray-700");
            zoneButton.classList.remove("font-semibold", "text-primary");
            zoneButton.classList.add("text-gray-700");
            activeButton.classList.remove("text-gray-700");
            activeButton.classList.add("font-semibold", "text-primary");

            if (editor_status === "create") {
                editor_status = "none";
                createButton.classList.remove("font-semibold", "text-primary");
                createButton.classList.add("text-gray-700");
                finishButton.classList.add("hidden");
                cancelZoneButton.classList.add("hidden");
                elementButton.classList.remove("text-gray-300");
                elementButton.classList.add("text-gray-700");
                elementButton.removeAttribute("disabled");
                alert("Modo de creación desactivado.");
            }

            if (mode === "zone") {
                editor_mode = "zone";
                createButton.innerHTML =
                    "<i class='fas fa-plus-circle'></i> Crear nueva zona";
            } else if (mode === "element") {
                editor_mode = "element";
                createButton.innerHTML =
                    "<i class='fas fa-plus-circle'></i> Crear nuevo elemento";
            }

            createButton.classList.remove("text-gray-300");
            createButton.classList.add("text-gray-700");
            createButton.removeAttribute("disabled");
        }
    }

    function deactivateCreateMode() {
        editor_status = "none";
        createButton.classList.remove("font-semibold", "text-primary");
        createButton.classList.add("text-gray-700");
        finishButton.classList.add("hidden");
        cancelZoneButton.classList.add("hidden");
        elementButton.classList.remove("text-gray-300");
        elementButton.classList.add("text-gray-700");
        elementButton.removeAttribute("disabled");
        alert("Modo de creación desactivado.");
    }

    function activateZoneCreateMode() {
        editor_status = "create";
        zonePoints = [];
        finishButton.classList.remove("hidden");
        cancelZoneButton.classList.remove("hidden");
        createButton.classList.remove("text-gray-700");
        createButton.classList.add("text-gray-300");
        createButton.setAttribute("disabled", "true");
        elementButton.classList.remove("text-gray-700");
        elementButton.classList.add("text-gray-300");
        elementButton.setAttribute("disabled", "true");

        alert("Marca los puntos de la zona en el mapa.");
    }

    function activateElementCreateMode() {
        editor_status = "create";
        createButton.classList.add("font-semibold", "text-primary");
        alert("Haz clic en el mapa para añadir un elemento.");
    }

    function getNextZoneId() {
        if (!zonesData.zones || !zonesData.zones.length) return 1;
        const maxId = Math.max(...zonesData.zones.map((zone) => zone.id));
        return maxId + 1;
    }

    function zonesCollide(newZonePoints) {
        if (newZonePoints.length < 4) {
            return false;
        }

        const closedNewZonePoints = [...newZonePoints, newZonePoints[0]];
        const newZonePolygon = turf.polygon([closedNewZonePoints]);

        return zonesData.zones.some((zone) => {
            const zonePoints = zone.points.map(([lng, lat]) => [parseFloat(lng), parseFloat(lat)]);
            const closedZonePoints = [...zonePoints, zonePoints[0]];
            const zonePolygon = turf.polygon([closedZonePoints]);
            return turf.booleanOverlap(newZonePolygon, zonePolygon);
        });
    }

    async function fetchZones() {
        try {
            const response = await fetch("/api/map/zones");
            if (!response.ok)
                throw new Error("No se pudo cargar los datos de las zonas.");
            zonesData = await response.json();
            renderZones(zonesData.zones);
            zonesData.zones.forEach((zone) => {
                zone.element_types.forEach((type) => {
                    addMarkersForElementType(zone, type);
                });
            });

            hidePreloader();
        } catch (error) {
            console.error(error);
            inventoryContainer.innerHTML =
                '<p class="text-red-500">Error al cargar las zonas.</p>';
            hidePreloader();
        }
    }

    function renderZones(zones) {
        inventoryContainer.innerHTML = "";
        if (zones.length === 0) {
            const emptyMessage = document.createElement("div");
            emptyMessage.className = "text-gray-700 text-center p-6 bg-gray-100 rounded-lg flex flex-col items-center";
            emptyMessage.innerHTML = `
                <i class="fas fa-exclamation-circle text-4xl mb-4"></i>
                <p class="text-lg font-semibold">No hay zonas creadas.</p>
                <p class="text-sm">Por favor, crea una nueva zona para comenzar.</p>
            `;
            inventoryContainer.appendChild(emptyMessage);
        } else {
            zones.forEach((zone) => {
                const zoneItem = createZoneItem(zone);
                inventoryContainer.appendChild(zoneItem);
                addZonePolygon(zone);
            });
        }
    }

    function createZoneItem(zone) {
        const zoneItem = document.createElement("div");
        zoneItem.className = "bg-white border rounded-lg mb-4 p-4";

        const zoneHeader = document.createElement("div");
        zoneHeader.className = "flex items-center justify-between mb-4";

        const zoneTitleContainer = document.createElement("div");
        zoneTitleContainer.className = "flex items-center space-x-2";

        const zoneTitle = document.createElement("span");
        zoneTitle.className = "text-xl font-semibold text-gray-700 truncate";
        zoneTitle.innerText = `${zone.name}`;

        const zoneTitleInput = document.createElement("input");
        zoneTitleInput.type = "text";
        zoneTitleInput.className =
            "hidden text-xl font-semibold text-gray-700 border-b-2 border-gray-300 focus:outline-none";
        zoneTitleInput.value = ` ${zone.name}`;

        zoneTitle.addEventListener("click", () => {
            zoneTitle.classList.add("hidden");
            zoneTitleInput.classList.remove("hidden");
            zoneTitleInput.focus();
        });

        zoneTitleInput.addEventListener("blur", async () => {
            zoneTitle.classList.remove("hidden");
            zoneTitleInput.classList.add("hidden");
            zoneTitle.innerText = zoneTitleInput.value;

            try {
                const response = await fetch("/api/map/zones/name", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: zone.id, name: zoneTitleInput.value }),
                });

                const result = await response.json();
                if (result.status !== "success") {
                    alert(`Error: ${result.message}`);
                }
            } catch (error) {
                console.error("Update Zone Name Error", error);
                alert("Error al actualizar el nombre de la zona.");
            }
        });

        zoneTitleInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                zoneTitleInput.blur();
            }
        });

        zoneTitleContainer.appendChild(zoneTitle);
        zoneTitleContainer.appendChild(zoneTitleInput);

        const zoneControls = document.createElement("div");
        zoneControls.className = "flex items-center space-x-4";

        const showHideIcon = document.createElement("i");
        showHideIcon.className = "fas fa-eye text-gray-700 cursor-pointer";
        showHideIcon.dataset.zoneId = zone.id;
        showHideIcon.addEventListener("click", (e) => handleZoneToggle(e, zone));

        const colorPicker = createColorPicker(zone.id, zone.color);

        zoneControls.appendChild(showHideIcon);
        zoneControls.appendChild(colorPicker);

        zoneHeader.appendChild(zoneTitleContainer);
        zoneHeader.appendChild(zoneControls);

        const zoneDescription = document.createElement("textarea");
        zoneDescription.className =
            "w-full mt-4 p-3 border rounded-lg text-gray-700 focus:ring-2 focus:ring-blue-400 transition duration-200";
        zoneDescription.placeholder = "Descripción de la zona";
        zoneDescription.value = zone.description || "";

        const elementTypesContainer = document.createElement("div");
        elementTypesContainer.id = `element-types-zone-${zone.id}`;

        if (zone.element_types.length === 0) {
            const emptyMessage = document.createElement("p");
            emptyMessage.className = "text-gray-500 italic text-sm";
            emptyMessage.innerText = "No hay elementos en esta zona.";
            elementTypesContainer.appendChild(emptyMessage);
        } else {
            zone.element_types.forEach((type) => {
                const elementTypeItem = createElementTypeItem(zone, type);
                elementTypesContainer.appendChild(elementTypeItem);
            });
        }

        const zoneFooter = document.createElement("div");
        zoneFooter.className = "flex justify-end mt-4";

        const deleteButton = document.createElement("button");
        deleteButton.className =
            "bg-red-500 hover:bg-red-600 px-4 py-2 text-white rounded-lg transition duration-300";
        deleteButton.innerText = "Eliminar";
        deleteButton.onclick = () => deleteZone(zone.id);

        zoneFooter.appendChild(deleteButton);

        zoneItem.appendChild(zoneHeader);
        zoneItem.appendChild(zoneDescription);
        zoneItem.appendChild(elementTypesContainer);
        zoneItem.appendChild(zoneFooter);

        return zoneItem;
    }

    function handleZoneToggle(event, zone) {
        const showHideIcon = event.target;
        const isVisible = showHideIcon.classList.contains("fa-eye");
        const elementTypesContainer = document.querySelector(
            `#element-types-zone-${zone.id}`
        );
        const zoneItem = event.target.closest(".bg-white");

        let hiddenMessageDiv = zoneItem.querySelector(".zone-hidden-message");

        if (isVisible) {
            elementTypesContainer.style.display = "none";
            const polygonLayerId = `zone-polygon-layer-${zone.id}`;
            map.setLayoutProperty(polygonLayerId, "visibility", "none");

            showHideIcon.classList.remove("fa-eye");
            showHideIcon.classList.add("fa-eye-slash");

            if (!hiddenMessageDiv) {
                hiddenMessageDiv = document.createElement("div");
                hiddenMessageDiv.className =
                    "zone-hidden-message text-gray-700 mt-2 p-4";
                hiddenMessageDiv.innerHTML = "Zona actualmente oculta.";
                zoneItem.insertBefore(hiddenMessageDiv, zoneItem.querySelector(".flex.justify-end.mt-4"));
            }

            removeMarkersForZone(zone);
        } else {
            elementTypesContainer.style.display = "block";
            const polygonLayerId = `zone-polygon-layer-${zone.id}`;
            map.setLayoutProperty(polygonLayerId, "visibility", "visible");

            showHideIcon.classList.remove("fa-eye-slash");
            showHideIcon.classList.add("fa-eye");

            if (hiddenMessageDiv) {
                hiddenMessageDiv.remove();
            }

            zone.element_types.forEach((type) => {
                const typeCheckbox = document.querySelector(
                    `input[data-zone-id="${zone.id}"][data-type-id="${type.id}"]`
                );
                if (typeCheckbox.checked) addMarkersForElementType(zone, type);
            });
        }
    }

    function createElementTypeItem(zone, type) {
        const elementTypeItem = document.createElement("div");
        elementTypeItem.className =
            "flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-200 transition ease-in-out duration-300";
        const elementCount = type.elements.length;
        elementTypeItem.innerHTML = `
            <span class="text-gray-700"><i class="${type.icon} text-xl mr-2"></i> ${type.name} (${elementCount} elementos)</span>
        `;

        const showHideIcon = document.createElement("i");
        showHideIcon.className = "fas fa-eye text-gray-700 cursor-pointer";
        showHideIcon.dataset.zoneId = zone.id;
        showHideIcon.dataset.typeId = type.id;
        showHideIcon.addEventListener("click", (e) => handleElementTypeToggle(e, zone, type));

        elementTypeItem.appendChild(showHideIcon);
        return elementTypeItem;
    }

    function handleElementTypeToggle(event, zone, type) {
        const showHideIcon = event.target;
        const isVisible = showHideIcon.classList.contains("fa-eye");

        if (isVisible) {
            removeMarkersForElementType(zone, type);
            showHideIcon.classList.remove("fa-eye");
            showHideIcon.classList.add("fa-eye-slash");
        } else {
            addMarkersForElementType(zone, type);
            showHideIcon.classList.remove("fa-eye-slash");
            showHideIcon.classList.add("fa-eye");
        }
    }

    function addMarkersForElementType(zone, type) {
        if (!markers[zone.id]) markers[zone.id] = {};
        if (!markers[zone.id][type.id]) markers[zone.id][type.id] = [];

        type.elements.forEach((el) => {
            const markerElement = createMarkerElement(type.icon, type.color);
            const marker = new mapboxgl.Marker({ element: markerElement })
                .setLngLat([el.longitude, el.latitude])
                .addTo(map);

            marker.getElement().addEventListener('click', () => {
                if (editor_mode !== "element" || editor_status !== "create") {
                    showElementModal(el);
                }
            });

            markers[zone.id][type.id].push(marker);
        });
    }

    function removeMarkersForZone(zone) {
        if (markers[zone.id]) {
            Object.values(markers[zone.id])
                .flat()
                .forEach((marker) => marker.remove());
            delete markers[zone.id];
        }
    }

    function removeMarkersForElementType(zone, type) {
        if (markers[zone.id] && markers[zone.id][type.id]) {
            markers[zone.id][type.id].forEach((marker) => marker.remove());
            markers[zone.id][type.id] = [];
        }
    }

    function createMarkerElement(icon, color) {
        const markerElement = document.createElement("div");
        markerElement.style.cssText = `width: 40px; height: 40px; background-color: ${color}; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid white;`;
        markerElement.innerHTML = `<i class="${icon}" style="color: white; font-size: 20px;"></i>`;
        return markerElement;
    }

    function addZonePolygon(zone) {
        console.log("Adding polygon for zone: ", zone.id);
        const polygonSourceId = `zone-polygon-${zone.id}`;
        const polygonLayerId = `zone-polygon-layer-${zone.id}`;

        if (!map.isStyleLoaded()) {
            map.on("styledata", () => {
                if (
                    !map.getSource(polygonSourceId) &&
                    !map.getLayer(polygonLayerId)
                ) {
                    addPolygonSourceAndLayer(
                        zone,
                        polygonSourceId,
                        polygonLayerId
                    );
                }
            });
        } else {
            if (
                !map.getSource(polygonSourceId) &&
                !map.getLayer(polygonLayerId)
            ) {
                addPolygonSourceAndLayer(zone, polygonSourceId, polygonLayerId);
            }
        }
    }

    function addPolygonSourceAndLayer(
        zone,
        polygonSourceId,
        polygonLayerId
    ) {
        console.log("Adding polygon source and layer for zone: ", zone.id);
        console.log("Zone points:", zone.points);
        console.log("Zone color:", zone.color);
        if (!map.getSource(polygonSourceId)) {
            map.addSource(polygonSourceId, {
                type: "geojson",
                data: {
                    type: "Feature",
                    geometry: {
                        type: "Polygon",
                        coordinates: [
                            [
                                ...zone.points.map((point) => [
                                    point[0],
                                    point[1],
                                ]),
                            ],
                        ],
                    },
                },
            });
        }

        if (!map.getLayer(polygonLayerId)) {
            map.addLayer({
                id: polygonLayerId,
                type: "fill",
                source: polygonSourceId,
                paint: {
                    "fill-color": zone.color
                        ? hexToRgbaString(zone.color, 0.8)
                        : "rgba(255, 99, 132, 0.2)",
                },
            });
        }
    }

    async function updateZoneColorInDatabase(zoneId, color) {
        try {
            const response = await fetch(`/api/map/zones/color`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: zoneId, color: color }),
            });

            const result = await response.json();
            if (result.status !== "success") {
                alert(`Error: ${result.message}`);
            }
        } catch (error) {
            console.error("Update Zone Color Error", error);
            alert("Error al actualizar el color de la zona.");
        }
    }

    function updateZoneColor(color, zoneId) {
        console.log("Updating zone color to: ", color);
        const zone = zonesData.zones.find((zone) => zone.id === zoneId);
        const polygonLayerId = `zone-polygon-layer-${zone.id}`;
        if (map.getLayer(polygonLayerId)) {
            map.setPaintProperty(
                polygonLayerId,
                "fill-color",
                hexToRgbaString(color, 0.8)
            );
        }
        updateZoneColorInDatabase(zoneId, color);
    }

    function hexToRgbaString(hex, alpha = 1) {
        hex = hex.replace(/^#/, "");

        if (hex.length === 3) {
            hex = hex
                .split("")
                .map((x) => x + x)
                .join("");
        }

        const r = parseInt(hex.substring(0, 2), 16);
        const g = parseInt(hex.substring(2, 4), 16);
        const b = parseInt(hex.substring(4, 6), 16);

        return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    }

    function createColorPicker(zoneId, color) {
        const colorPickerContainer = document.createElement("div");
        colorPickerContainer.className = "ml-4";
        colorPickerContainer.innerHTML = `
        <input
            type="color"
            data-zone-id="${zoneId}"
            class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none"
            value="${color || '#2563eb'}"
            title="Choose your color"
        >
    `;
        const colorPickerInput = colorPickerContainer.querySelector("input");

        colorPickerInput.addEventListener("input", (e) => {
            const color = e.target.value;
            updateZoneColor(color, zoneId);
        });

        return colorPickerContainer;
    }

    function removeZoneFeatures(zoneId) {
        const polygonLayerId = `zone-polygon-layer-${zoneId}`;
        const polygonSourceId = `zone-polygon-${zoneId}`;

        if (map.getLayer(polygonLayerId)) {
            map.removeLayer(polygonLayerId);
            console.log(`Polygon layer removed: ${polygonLayerId}`);
        }
        if (map.getSource(polygonSourceId)) {
            map.removeSource(polygonSourceId);
            console.log(`Polygon source removed: ${polygonSourceId}`);
        }
        map.triggerRepaint();
    }

    async function deleteZone(zoneId) {
        console.log(`Attempting to delete zone with ID: ${zoneId}`);

        try {
            const response = await fetch("/api/map/zones", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: zoneId }),
            });

            if (!response.ok) throw new Error("Failed to delete zone");

            const result = await response.json();
            if (result.status === "success") {
                const zoneIndex = zonesData.zones.findIndex((z) => z.id === zoneId);
                if (zoneIndex === -1) {
                    console.error(`Zona con ID ${zoneId} no encontrada.`);
                    return;
                }

                zonesData.zones.splice(zoneIndex, 1);
                console.log(`Zone with ID: ${zoneId} removed from zonesData`);

                removeMarkersForZone({ id: zoneId });
                removeZoneFeatures(zoneId);

                renderZones(zonesData.zones);
                alert(`Zona ${zoneId} eliminada exitosamente.`);
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error(error);
            alert("Error al eliminar la zona.");
        }
    }

    function showElementModal(el) {
        fetch(`/api/map/elements/${el.id}`)
            .then(response => response.json())
            .then(data => {
                elementModalTitle.innerText = `Elemento ${data.id}`;
                elementModalContent.innerHTML = `
                    <div class="space-y-2">
                        <p><strong><i class="fas fa-map-marker-alt"></i> Zona:</strong> ${data.zone.name}</p>
                        <p><strong><i class="${data.element_type.icon}"></i> Tipo:</strong> ${data.element_type.name}</p>
                        ${data.element_type.requires_tree_type && data.tree_type ? `<p><strong><i class="fas fa-tree"></i> Especie:</strong> ${data.tree_type.species}</p>` : ""}
                        <p><strong><i class="fas fa-map-pin"></i> Coordenadas:</strong> ${data.point.latitude}, ${data.point.longitude}</p>
                        <p><strong><i class="fas fa-align-left"></i> Descripción:</strong> <textarea id="element-description-input" class="border rounded p-1 w-full">${data.description || ""}</textarea></p>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button id="delete-element-btn" class="bg-red-500 hover:bg-red-600 px-4 py-2 text-white rounded-lg transition duration-300" data-element-id="${data.id}">Eliminar elemento</button>
                    </div>
                `;
                elementModal.classList.remove("hidden");

                const descriptionInput = document.getElementById('element-description-input');
                const originalDescription = data.description || "";
                descriptionInput.addEventListener('blur', () => {
                    const newDescription = descriptionInput.value;
                    if (newDescription !== originalDescription) {
                        updateElementDescription(data.id, newDescription);
                    }
                });

                document.getElementById("element-modal-close").addEventListener("click", () => {
                    elementModal.classList.add("hidden");
                });

                document.getElementById("delete-element-btn").addEventListener("click", (event) => {
                    const elementId = event.target.getAttribute('data-element-id');
                    deleteElement(elementId);
                });
            })
            .catch(error => {
                console.error("Error al obtener los datos del elemento", error);
                alert("Error al obtener los datos del elemento.");
            });
    }

    function updateElementDescription(elementId, newDescription) {
        fetch(`/api/map/elements/description`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: elementId, description: newDescription }),
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                alert('Descripción del elemento actualizada correctamente.');
            } else {
                alert(`Error: ${result.message}`);
            }
        })
        .catch(error => {
            console.error('Error al actualizar la descripción del elemento', error);
            alert('Error al actualizar la descripción del elemento.');
        });
    }

    function clearMap() {
        Object.keys(markers).forEach(zoneId => {
            Object.values(markers[zoneId]).flat().forEach(marker => marker.remove());
        });
        markers = {};

        if (zonesData.zones) {
            zonesData.zones.forEach(zone => {
                removeZoneFeatures(zone.id);
            });
        }
    }

    function deleteElement(elementId) {
        fetch(`/api/map/elements`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id: elementId }),
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                alert('Elemento eliminado correctamente.');
                elementModal.classList.add("hidden");
                clearMap();
                fetchZones();
            } else {
                alert(`Error: ${result.message}`);
            }
        })
        .catch(error => {
            console.error('Error al eliminar el elemento', error);
            alert('Error al eliminar el elemento.');
        });
    }

    async function loadElementTypes() {
        try {
            const response = await fetch("/api/map/elementtypes");
            if (!response.ok) throw new Error("Error fetching element types");
            elementTypes = await response.json();
        } catch (error) {
            console.error(error);
            elementTypes = [];
        }
    }

    async function loadTreeTypes() {
        try {
            const response = await fetch("/api/map/treetypes");
            if (!response.ok) throw new Error("Error fetching tree types");
            treeTypes = await response.json();
        } catch (error) {
            console.error(error);
            treeTypes = [];
        }
    }

    function showCreateElementModal(zone, point) {
        selectedZone = { id: zone.id, point: point };
        createElementType.innerHTML = "";
        elementTypes.forEach((t) => {
            const option = document.createElement("option");
            option.value = t.id;
            option.text = t.name;
            createElementType.appendChild(option);
        });

        const selectedType = elementTypes.find(t => t.id === parseInt(createElementType.value));
        if (selectedType.requires_tree_type) {
            createElementTreeType.innerHTML = "";
            treeTypes.forEach((tree) => {
                const option = document.createElement("option");
                option.value = tree.id;
                option.text = tree.species;
                createElementTreeType.appendChild(option);
            });
            treeTypeContainer.classList.remove("hidden");
        } else {
            treeTypeContainer.classList.add("hidden");
        }

        createElementModal.classList.remove("hidden");
    }

    async function createElement(bodyData) {
        try {
            const response = await fetch("/api/map/elements", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(bodyData),
            });
            const result = await response.json();
            if (result.status === "success") {
                alert("Elemento guardado en la base de datos");
                fetchZones();
                createElementModal.classList.add("hidden");
                createElementForm.reset();
            } else {
                alert(`Error: ${result.message}`);
            }
        } catch (error) {
            console.error("Create Element Error", error);
        }
    }

    if (contractSelect && contractSelect.value === "-1") {
        zoneButton.classList.add("text-gray-300");
        zoneButton.disabled = true;
        elementButton.classList.add("text-gray-300");
        elementButton.disabled = true;
        createButton.classList.add("text-gray-300");
        createButton.disabled = true;
        finishButton.classList.add("text-gray-300");
        finishButton.disabled = true;
    }

    cancelZoneButton.id = "cancel-zone-control";
    cancelZoneButton.className = "hidden text-sm text-gray-700 flex flex-col items-center";
    cancelZoneButton.innerHTML = "<i class='fas fa-times-circle'></i> Cancelar creación";
    document.getElementById("submenu").appendChild(cancelZoneButton);

    window.setEditorMode = setEditorMode;

    loadElementTypes();
    loadTreeTypes();
});

