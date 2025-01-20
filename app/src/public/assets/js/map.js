document.addEventListener("DOMContentLoaded", () => {
    const MODE = { NONE: "NONE", ZONE: "ZONE", ELEMENT: "ELEMENT" };
    let currentMode = MODE.NONE;
    let isCreating = false;
    let markers = [];
    let zonesData = [];
    let zonePoints = [];
    let tempMarkers = [];
    let selectedZone = null;
    let elementTypes = [];
    let treeTypes = [];

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
    const inventorySidebarToggle = document.getElementById("inventory-sidebar-toggle");
    const inventorySidebar = document.querySelector(".inventory-sidebar");
    const mapWrapper = document.querySelector(".map");
    const elementModalTabs = document.querySelectorAll(".element-modal-tab");
    const elementModalTabContents = document.querySelectorAll(".element-modal-tab-content");

    // Initialize the map
    mapboxgl.accessToken = "pk.eyJ1IjoidXJiYW50cmVlIiwiYSI6ImNtNHI4MXNhaTAxc3gybHNpMWp3ejJldHcifQ.d94SBSjOt6Ylu4A8PKPFiQ";
    const mapContainer = new mapboxgl.Map({
        container: "map",
        center: [0.5826405437646912, 40.70973485628924],
        style: "mapbox://styles/mapbox/standard-satellite",
        zoom: 15,
    });

    // Event listeners
    elementModalClose.addEventListener("click", () => elementModal.classList.add("hidden"));
    createElementCancel.addEventListener("click", () => createElementModal.classList.add("hidden"));
    inventorySidebarToggle.addEventListener("click", () => {
        inventorySidebar.classList.toggle("hidden");
        inventorySidebar.classList.toggle("w-5/6");
        mapWrapper.classList.toggle("w-1/6");
    });

    createButton.addEventListener("click", handleCreateClick);
    cancelZoneButton.addEventListener("click", handleCancelZoneCreation);
    finishButton.addEventListener("click", handleFinishZoneCreation);
    createElementForm.addEventListener("submit", handleElementFormSubmit);
    createElementType.addEventListener("change", handleElementTypeChange);
    mapContainer.on("click", handleMapClick);
    mapContainer.on("load", loadZones);

    zoneButton.addEventListener("click", () => setMode(MODE.ZONE));
    elementButton.addEventListener("click", () => setMode(MODE.ELEMENT));

    elementModalTabs.forEach(tab => {
        tab.addEventListener("click", () => {
            elementModalTabs.forEach(t => {
                t.classList.remove("border-primary");
                t.classList.add("border-transparent");
            });
            elementModalTabContents.forEach(tc => tc.classList.add("hidden"));

            tab.classList.add("border-primary");
            tab.classList.remove("border-transparent");
            document.getElementById(tab.dataset.target).classList.remove("hidden");
        });
    });

    // Functions
    function setActiveButton(activeButton) {
        const buttons = [zoneButton, elementButton];
        buttons.forEach(button => {
            if (button === activeButton) {
                button.classList.add("font-semibold", "text-primary");
            } else {
                button.classList.remove("font-semibold", "text-primary");
            }
        });
    }

    function hidePreloader() {
        preloader.style.display = "none";
    }

    function handleCreateClick() {
        if (isCreating) {
            stopCreation();
        } else if (currentMode === MODE.ZONE) {
            startZoneCreation();
        } else if (currentMode === MODE.ELEMENT) {
            startElementCreation();
        }
    }

    function handleCancelZoneCreation() {
        isCreating = false;
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

    function handleFinishZoneCreation() {
        if (currentMode === MODE.ZONE && isCreating) {
            if (zonePoints.length < 4) {
                alert("Una zona debe tener al menos cuatro puntos.");
                return;
            }

            if (checkZoneCollision(zonePoints)) {
                alert("La nueva zona colisiona con una zona existente.");
                return;
            }

            const newZone = {
                id: generateNextZoneId(),
                name: `Zona ${generateNextZoneId()}`,
                description: "",
                color: "#FF0000",
                points: zonePoints,
                elementTypes: [],
            };

            saveZone(newZone);
            finishButton.classList.add("hidden");
            cancelZoneButton.classList.add("hidden");
        }
    }

    async function handleElementFormSubmit(e) {
        e.preventDefault();
        const elementType = createElementType.value;
        const description = createElementDescription.value;
        const treeTypeId = createElementTreeType.value;
        const [lng, lat] = selectedZone.point;

        const bodyData = {
            zoneId: selectedZone.id,
            elementTypeId: elementType,
            description: description,
            latitude: lat,
            longitude: lng,
            treeTypeId: treeTypeId
        };

        try {
            const response = await fetch("/api/map/elements", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(bodyData),
            });
            const result = await response.json();
            if (result.status === "success") {
                alert("Elemento guardado en la base de datos");
                addMarkerForNewElement(result.element);
                createElementModal.classList.add("hidden");
                createElementForm.reset();
            } else {
                alert(`Error: ${result.message}`);
            }
        } catch (error) {
            console.error("Create Element Error", error);
        }
    }

    function addMarkerForNewElement(element) {
        const zone = zonesData.zones.find(z => z.id === element.zoneId);
        const type = zone.elementTypes.find(t => t.id === element.elementTypeId);

        if (!markers[element.zoneId]) markers[element.zoneId] = {};
        if (!markers[element.zoneId][element.elementTypeId]) markers[element.zoneId][element.elementTypeId] = [];

        const markerElement = createMarkerElement(type.icon, type.color);
        markerElement.dataset.elementId = element.id;

        const marker = new mapboxgl.Marker({ element: markerElement })
            .setLngLat([element.longitude, element.latitude])
            .addTo(mapContainer);

        marker.getElement().addEventListener('click', () => {
            if (currentMode !== MODE.ELEMENT || !isCreating) {
                showElementModal(element);
            }
        });

        markers[element.zoneId][element.elementTypeId].push(marker);
        type.elements.push(element);
    }

    function handleElementTypeChange() {
        const selectedTypeId = parseInt(createElementType.value);
        const selectedType = elementTypes.find(t => t.id === selectedTypeId);
        if (selectedType.requiresTreeType) {
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
        if (currentMode === MODE.ZONE && isCreating) {
            const { lng, lat } = e.lngLat;
            zonePoints.push([lng, lat]);

            const markerElement = document.createElement("div");
            markerElement.style.cssText =
                "width: 30px; height: 30px; background-color: red; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;";
            markerElement.innerText = zonePoints.length;
            const marker = new mapboxgl.Marker({ element: markerElement })
                .setLngLat([lng, lat])
                .addTo(mapContainer);
            tempMarkers.push(marker);
        } else if (currentMode === MODE.ELEMENT && isCreating) {
            const { lng, lat } = e.lngLat;
            const point = turf.point([lng, lat]);

            const zone = zonesData.zones.find((zone) => {
                const numericPoints = zone.points.map(([lngStr, latStr]) => [
                    parseFloat(lngStr),
                    parseFloat(latStr),
                ]);

                const polygon = turf.polygon([[...numericPoints, numericPoints[0]]]);
                return turf.booleanPointInPolygon(point, polygon);
            });

            if (zone) {
                showNewElementModal(zone, [lng, lat]);
            } else {
                alert("El elemento debe estar dentro de una zona.");
            }
        }
    }

    function setMode(mode) {
        if (currentMode === mode) {
            currentMode = MODE.NONE;
            setActiveButton(null);
            if (isCreating) {
                stopCreation();
            }
            createButton.classList.add("text-gray-300");
            createButton.classList.remove("text-gray-700");
            createButton.setAttribute("disabled", "true");
        } else {
            currentMode = mode;
            setActiveButton(mode === MODE.ZONE ? zoneButton : elementButton);
            if (isCreating) {
                stopCreation();
            }
            createButton.classList.remove("text-gray-300");
            createButton.classList.add("text-gray-700");
            createButton.removeAttribute("disabled");
            if (mode === MODE.ZONE) {
                createButton.innerHTML = '<i class="fas fa-plus-circle"></i> Crear nueva zona';
            } else if (mode === MODE.ELEMENT) {
                createButton.innerHTML = '<i class="fas fa-plus-circle"></i> Crear nuevo elemento';
            }
        }
    }

    function stopCreation() {
        isCreating = false;
        createButton.classList.remove("font-semibold", "text-primary");
        createButton.classList.add("text-gray-700");
        finishButton.classList.add("hidden");
        cancelZoneButton.classList.add("hidden");
        elementButton.classList.remove("text-gray-300");
        elementButton.classList.add("text-gray-700");
        elementButton.removeAttribute("disabled");
        alert("Modo de creación desactivado.");
    }

    function startZoneCreation() {
        isCreating = true;
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

    function startElementCreation() {
        isCreating = true;
        createButton.classList.add("font-semibold", "text-primary");
        alert("Haz clic en el mapa para añadir un elemento.");
    }

    function generateNextZoneId() {
        if (!zonesData.zones || !zonesData.zones.length) return 1;
        const maxId = Math.max(...zonesData.zones.map((zone) => zone.id));
        return maxId + 1;
    }

    function checkZoneCollision(newZonePoints) {
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

    async function loadZones() {
        try {
            const response = await fetch("/api/map/zones");
            if (!response.ok)
                throw new Error("No se pudo cargar los datos de las zonas.");
            zonesData = await response.json();
            updateInventory(zonesData.zones);
            zonesData.zones.forEach((zone) => {
                drawZonePolygonOnMap(zone);
                zone.elementTypes.forEach((type) => {
                    addMarkersForElementType(zone.id, type);
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

    function updateInventory(zones) {
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
                const zoneItem = buildZoneInventoryItem(zone);
                inventoryContainer.appendChild(zoneItem);
            });
        }
    }

    function buildZoneInventoryItem(zone) {
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

        zoneDescription.addEventListener("blur", async () => {
            try {
                const response = await fetch("/api/map/zones/description", {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id: zone.id, description: zoneDescription.value }),
                });

                const result = await response.json();
                if (result.status !== "success") {
                    alert(`Error: ${result.message}`);
                }
            } catch (error) {
                console.error("Update Zone Description Error", error);
                alert("Error al actualizar la descripción de la zona.");
            }
        });

        const elementTypesContainer = document.createElement("div");
        elementTypesContainer.id = `element-types-zone-${zone.id}`;

        if (zone.elementTypes.length === 0) {
            const emptyMessage = document.createElement("p");
            emptyMessage.className = "text-gray-500 italic text-sm";
            emptyMessage.innerText = "No hay elementos en esta zona.";
            elementTypesContainer.appendChild(emptyMessage);
        } else {
            zone.elementTypes.forEach((type) => {
                const elementTypeItem = createElementTypeItem(zone, type);
                elementTypesContainer.appendChild(elementTypeItem);
            });
        }

        const zoneFooter = document.createElement("div");
        zoneFooter.className = "flex justify-end mt-4";

        const deleteButton = document.createElement("button");
        deleteButton.className =
            "bg-red-500 hover:bg-red-600 px-4 py-2 text-white rounded-lg transition duration-300";
        deleteButton.innerHTML = "<i class='fas fa-trash-alt'></i> Eliminar";
        deleteButton.onclick = () => {
            if (confirm("¿Estás seguro de que deseas eliminar esta zona?")) {
                removeZone(zone.id);
            }
        };

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
            mapContainer.setLayoutProperty(polygonLayerId, "visibility", "none");

            showHideIcon.classList.remove("fa-eye");
            showHideIcon.classList.add("fa-eye-slash");

            if (!hiddenMessageDiv) {
                hiddenMessageDiv = document.createElement("div");
                hiddenMessageDiv.className =
                    "zone-hidden-message text-gray-700 mt-2 p-4";
                hiddenMessageDiv.innerHTML = "Zona actualmente oculta.";
                zoneItem.insertBefore(hiddenMessageDiv, zoneItem.querySelector(".flex.justify-end.mt-4"));
            }

            removeMarkersForZone(zone.id);
        } else {
            elementTypesContainer.style.display = "block";
            const polygonLayerId = `zone-polygon-layer-${zone.id}`;
            mapContainer.setLayoutProperty(polygonLayerId, "visibility", "visible");

            showHideIcon.classList.remove("fa-eye-slash");
            showHideIcon.classList.add("fa-eye");

            if (hiddenMessageDiv) {
                hiddenMessageDiv.remove();
            }

            zone.elementTypes.forEach((type) => {
                const typeIcon = document.querySelector(
                    `i[data-zone-id="${zone.id}"][data-type-id="${type.id}"]`
                );
                if (typeIcon && typeIcon.classList.contains("fa-eye")) {
                    addMarkersForElementType(zone.id, type);
                }
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
            removeMarkersForElementType(zone.id, type.id);
            showHideIcon.classList.remove("fa-eye");
            showHideIcon.classList.add("fa-eye-slash");
        } else {
            addMarkersForElementType(zone.id, type);
            showHideIcon.classList.remove("fa-eye-slash");
            showHideIcon.classList.add("fa-eye");
        }
    }

    function addMarkersForElementType(zoneId, type) {
        if (!markers[zoneId]) markers[zoneId] = {};
        if (!markers[zoneId][type.id]) markers[zoneId][type.id] = [];

        type.elements.forEach((el) => {
            const markerElement = createMarkerElement(type.icon, type.color);
            markerElement.dataset.elementId = el.id;

            const marker = new mapboxgl.Marker({ element: markerElement })
                .setLngLat([el.longitude, el.latitude])
                .addTo(mapContainer);

            marker.getElement().addEventListener('click', () => {
                if (currentMode !== MODE.ELEMENT || !isCreating) {
                    showElementModal(el);
                }
            });

            markers[zoneId][type.id].push(marker);
        });
    }

    function removeMarkersForZone(zoneId) {
        if (markers[zoneId]) {
            Object.values(markers[zoneId])
                .flat()
                .forEach((marker) => marker.remove());
            delete markers[zoneId];
        }
    }

    function removeMarkersForElementType(zoneId, typeId) {
        if (markers[zoneId] && markers[zoneId][typeId]) {
            markers[zoneId][typeId].forEach((marker) => marker.remove());
            markers[zoneId][typeId] = [];
        }
    }

    function createMarkerElement(icon, color) {
        const markerElement = document.createElement("div");
        markerElement.style.cssText = `width: 40px; height: 40px; background-color: ${color}; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid white;`;
        markerElement.innerHTML = `<i class="${icon}" style="color: white; font-size: 20px;"></i>`;
        return markerElement;
    }

    function drawZonePolygonOnMap(zone) {
        const polygonSourceId = `zone-polygon-${zone.id}`;
        const polygonLayerId = `zone-polygon-layer-${zone.id}`;
        if (
                !mapContainer.getSource(polygonSourceId) &&
                !mapContainer.getLayer(polygonLayerId)
            ) {
                addPolygonSourceAndLayer(zone, polygonSourceId, polygonLayerId);
            }
    }

    function addPolygonSourceAndLayer(
        zone,
        polygonSourceId,
        polygonLayerId
    ) {
        if (!mapContainer.getSource(polygonSourceId)) {
            mapContainer.addSource(polygonSourceId, {
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

        if (!mapContainer.getLayer(polygonLayerId)) {
            mapContainer.addLayer({
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

    async function updateZoneColor(color, zoneId) {
        const zone = zonesData.zones.find((zone) => zone.id === zoneId);
        const polygonLayerId = `zone-polygon-layer-${zone.id}`;
        if (mapContainer.getLayer(polygonLayerId)) {
            mapContainer.setPaintProperty(
                polygonLayerId,
                "fill-color",
                hexToRgbaString(color, 0.8)
            );
        }
        try {
            const response = await fetch("/api/map/zones/color", {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
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

    function removeZonePolygons(zoneId) {
        const polygonLayerId = `zone-polygon-layer-${zoneId}`;
        const polygonSourceId = `zone-polygon-${zoneId}`;

        if (mapContainer.getLayer(polygonLayerId)) {
            mapContainer.removeLayer(polygonLayerId);
        }
        if (mapContainer.getSource(polygonSourceId)) {
            mapContainer.removeSource(polygonSourceId);
        }
        mapContainer.triggerRepaint();
    }

    async function removeZone(zoneId) {
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
                removeZonePolygons(zoneId);
                zonesData.zones = zonesData.zones.filter((zone) => zone.id !== zoneId);
                alert(`Zona ${zoneId} eliminada exitosamente.`);
                reloadMap();
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error(error);
            alert("Error al eliminar la zona.");
        }
    }

    function clearMap() {
        if (zonesData.zones) {
            zonesData.zones.forEach(zone => {
                removeZonePolygons(zone.id);
            });
        }
        Object.keys(markers).forEach(zoneId => {
            removeMarkersForZone(zoneId);
        });
        zonesData = { zones: [] };
        markers = {};
    }

    function showElementModal(el) {
        fetch(`/api/map/elements/${el.id}`)
            .then(response => response.json())
            .then(data => {
                elementModalTitle.innerText = `Elemento ${data.id}`;
                document.getElementById("element-modal-info").innerHTML = `
                    <div class="space-y-2">
                        <p><strong><i class="fas fa-map-marker-alt"></i> Zona:</strong> ${data.zone.name}</p>
                        <p><strong><i class="${data.elementType.icon}"></i> Tipo:</strong> ${data.elementType.name}</p>
                        ${data.elementType.requires_tree_type && data.tree_type ? `<p><strong><i class="fas fa-tree"></i> Especie:</strong> ${data.tree_type.species}</p>` : ""}
                        <p><strong><i class="fas fa-map-pin"></i> Coordenadas:</strong> ${data.point.latitude}, ${data.point.longitude}</p>
                        <p><strong><i class="fas fa-align-left"></i> Descripción:</strong> <textarea id="element-description-input" class="border rounded p-1 w-full" rows="5">${data.description || ""}</textarea></p>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button id="delete-element-btn" class="bg-red-500 hover:bg-red-600 px-4 py-2 text-white rounded-lg transition duration-300" data-element-id="${data.id}">Eliminar elemento</button>
                    </div>
                `;
                document.getElementById("element-modal-incidences").innerHTML = `
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold">Incidencias</h3>
                        <div id="incidences-list">
                            <!-- Incidences will be injected here -->
                        </div>
                        <div class="flex justify-end">
                            <button id="add-incidence-btn" class="bg-blue-500 text-white px-4 py-2 rounded">Añadir Incidencia</button>
                        </div>
                    </div>
                `;
                loadIncidences(data.id);
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

                document.getElementById("add-incidence-btn").addEventListener("click", () => {
                    showAddIncidenceModal(data.id);
                });
            })
            .catch(error => {
                console.error("Error al obtener los datos del elemento", error);
                alert("Error al obtener los datos del elemento.");
            });
    }

    function loadIncidences(elementId) {
        fetch(`/api/map/elements/${elementId}/incidences`)
            .then(response => response.json())
            .then(data => {
                const incidencesList = document.getElementById("incidences-list");
                incidencesList.innerHTML = "";
                if (data.length === 0) {
                    const emptyMessage = document.createElement("p");
                    emptyMessage.innerText = "No hay incidencias registradas.";
                    incidencesList.appendChild(emptyMessage);
                } else {
                    data.forEach(incidence => {
                        const incidenceItem = document.createElement("div");
                        incidenceItem.className = "border rounded-lg p-4 mb-4 bg-white shadow-sm";
                        incidenceItem.innerHTML = `
                            <p class="text-lg font-semibold mb-2">Incidencia ${incidence.id}</p>
                            <p class="mb-2"><strong><i class="fas fa-tag"></i> Nombre:</strong> ${incidence.name}</p>
                            <p class="mb-2"><strong><i class="fas fa-calendar"></i> Fecha Creación:</strong> ${incidence.created_at || "N/A"}</p>
                            <p class="mb-2"><strong><i class="fas fa-info-circle"></i> Estado:</strong> <span class="text-sm rounded px-2 py-1 ml-2 ${incidence.status === "closed" ? "bg-gray-700 text-white" : "bg-yellow-500 text-white"}">${incidence.status === "closed" ? '<i class="fas fa-lock mr-1"></i> Cerrado' : '<i class="fas fa-exclamation-triangle mr-1"></i> Abierta'}</span></p>
                            <p class="mb-4"><strong><i class="fas fa-align-left"></i> Descripción:</strong> ${incidence.description || "N/A"}</p>
                            <div class="flex justify-end space-x-2">
                                <button class="bg-green-500 text-white px-4 py-2 rounded-lg toggle-status-btn" data-incidence-id="${incidence.id}">
                                    Cambiar Estado
                                </button>
                                <button class="bg-red-500 text-white px-4 py-2 rounded-lg delete-incidence-btn" data-incidence-id="${incidence.id}">
                                    Eliminar incidencia
                                </button>
                            </div>
                        `;
                        incidencesList.appendChild(incidenceItem);
                    });

                    document.querySelectorAll(".toggle-status-btn").forEach(button => {
                        button.addEventListener("click", (event) => {
                            const incidenceId = event.target.getAttribute('data-incidence-id');
                            toggleIncidenceStatus(incidenceId, elementId);
                        });
                    });

                    document.querySelectorAll(".delete-incidence-btn").forEach(button => {
                        button.addEventListener("click", (event) => {
                            const incidenceId = event.target.getAttribute('data-incidence-id');
                            deleteIncidence(incidenceId, elementId);
                        });
                    });
                }
            })
            .catch(error => {
                console.error("Error al cargar las incidencias", error);
                alert("Error al cargar las incidencias.");
            });
    }

    function showAddIncidenceModal(elementId) {
        const incidenceModal = document.createElement("div");
        incidenceModal.className = "fixed inset-0 flex items-center justify-center bg-black bg-opacity-50";
        incidenceModal.innerHTML = `
            <div class="bg-white rounded-lg shadow-lg p-6 w-5/6 md:w-3/6 lg:w-1/3">
                <h2 class="text-xl font-bold mb-4">Añadir Incidencia</h2>
                <form id="add-incidence-form">
                    <div class="mb-4">
                        <label for="incidence-name" class="block text-gray-700">Nombre</label>
                        <input type="text" id="incidence-name" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="incidence-description" class="block text-gray-700">Descripción</label>
                        <textarea id="incidence-description" class="w-full p-2 border rounded"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="cancel-add-incidence" class="mr-2 bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Añadir</button>
                    </div>
                </form>
            </div>
        `;
        document.body.appendChild(incidenceModal);

        document.getElementById("cancel-add-incidence").addEventListener("click", () => {
            document.body.removeChild(incidenceModal);
        });

        document.getElementById("add-incidence-form").addEventListener("submit", (e) => {
            e.preventDefault();
            const name = document.getElementById("incidence-name").value;
            const description = document.getElementById("incidence-description").value;
            addIncidence(elementId, { name, description });
            document.body.removeChild(incidenceModal);
        });
    }

    function addIncidence(elementId, incidenceData) {
        fetch(`/api/map/elements/${elementId}/incidences`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(incidenceData),
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === "success") {
                alert("Incidencia añadida correctamente.");
                loadIncidences(elementId);
            } else {
                alert(`Error: ${result.message}`);
            }
        })
        .catch(error => {
            console.error("Error al añadir la incidencia", error);
            alert("Error al añadir la incidencia.");
        });
    }

    function deleteIncidence(incidenceId, elementId) {
        fetch(`/api/map/incidences/${incidenceId}`, {
            method: "DELETE",
            headers: { "Content-Type": "application/json" }
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === "success") {
                alert("Incidencia eliminada correctamente.");
                loadIncidences(elementId);
            } else {
                alert(`Error: ${result.message}`);
            }
        })
        .catch(error => {
            console.error("Error al eliminar la incidencia", error);
            alert("Error al eliminar la incidencia.");
        });
    }

    function toggleIncidenceStatus(incidenceId, elementId) {
        fetch(`/api/map/incidences/${incidenceId}/status`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                alert('Estado de la incidencia cambiado correctamente.');
                loadIncidences(elementId);
            } else {
                alert(result.message || 'Error al cambiar el estado de la incidencia');
            }
        })
        .catch(error => {
            console.error("Error al cambiar el estado de la incidencia", error);
            alert("Error al cambiar el estado de la incidencia.");
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
                removeElementMarker(elementId);
            } else {
                alert(`Error: ${result.message}`);
            }
        })
        .catch(error => {
            console.error('Error al eliminar el elemento', error);
            alert('Error al eliminar el elemento.');
        });
    }

    function removeElementMarker(elementId) {
        for (const zoneId in markers) {
            for (const typeId in markers[zoneId]) {
                const markerIndex = markers[zoneId][typeId].findIndex(marker => marker.getElement().dataset.elementId == elementId);
                if (markerIndex !== -1) {
                    const marker = markers[zoneId][typeId][markerIndex];
                    marker.remove();
                    markers[zoneId][typeId].splice(markerIndex, 1);
                    const zone = zonesData.zones.find(z => z.id == zoneId);
                    const type = zone.elementTypes.find(t => t.id == typeId);
                    const elementIndex = type.elements.findIndex(el => el.id == elementId);
                    if (elementIndex !== -1) {
                        type.elements.splice(elementIndex, 1);
                    }
                    return;
                }
            }
        }
    }

    async function fetchElementTypes() {
        try {
            const response = await fetch("/api/map/elementtypes");
            if (!response.ok) throw new Error("Error fetching element types");
            elementTypes = await response.json();
        } catch (error) {
            console.error(error);
            elementTypes = [];
        }
    }

    async function fetchTreeTypes() {
        try {
            const response = await fetch("/api/map/treetypes");
            if (!response.ok) throw new Error("Error fetching tree types");
            treeTypes = await response.json();
        } catch (error) {
            console.error(error);
            treeTypes = [];
        }
    }

    function showNewElementModal(zone, point) {
        selectedZone = { id: zone.id, point: point };
        createElementType.innerHTML = "";
        elementTypes.forEach((t) => {
            const option = document.createElement("option");
            option.value = t.id;
            option.text = t.name;
            createElementType.appendChild(option);
        });

        const selectedType = elementTypes.find(t => t.id === parseInt(createElementType.value));
        if (selectedType.requiresTreeType) {
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

    async function saveZone(newZone) {
        try {
            const response = await fetch("/api/map/zones", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(newZone),
            });

            const result = await response.json();

            loadZones();

            tempMarkers.forEach((marker) => marker.remove());
            tempMarkers = [];

            isCreating = false;
            zonePoints = [];
            finishButton.classList.add("hidden");
            createButton.classList.remove("text-gray-300");
            createButton.classList.add("text-gray-700");
            createButton.removeAttribute("disabled");
            elementButton.classList.remove("text-gray-300");
            elementButton.classList.add("text-gray-700");
            elementButton.removeAttribute("disabled");

            alert("Zona creada exitosamente.");

        } catch (error) {
            console.error(error);
            alert(`Error al crear la zona: ${error.message}`);
        }
    }

    function reloadMap() {
        clearMap();
        loadZones();
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

    fetchElementTypes();
    fetchTreeTypes();
});
