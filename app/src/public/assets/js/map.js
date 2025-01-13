document.addEventListener("DOMContentLoaded", () => {
    const preloader = document.getElementById("preloader");

    const hidePreloader = () => {
        preloader.style.display = "none";
    };

    const zoneButton = document.getElementById("zone-control");
    const elementButton = document.getElementById("element-control");
    const createButton = document.getElementById("create-control");
    const finishButton = document.getElementById("finish-control");

    const cancelZoneButton = document.createElement("button");
    cancelZoneButton.id = "cancel-zone-control";
    cancelZoneButton.className = "hidden text-sm text-gray-700 flex flex-col items-center";
    cancelZoneButton.innerHTML = "<i class='fas fa-times-circle'></i> Cancelar creación";
    document.getElementById("submenu").appendChild(cancelZoneButton);

    let editor_mode = "none";
    let editor_status = "none";

    window.setEditorMode = function (mode) {
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
    };

    createButton.addEventListener("click", () => {
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
        } else if (editor_mode === "zone") {
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
        } else if (editor_mode === "element") {
            editor_status = "create";
            createButton.classList.add("font-semibold", "text-primary");
            alert("Haz clic en el mapa para añadir un elemento.");
        }
    });

    cancelZoneButton.addEventListener("click", () => {
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
    });

    const getNextZoneId = () => {
        if (!zonesData.zones || !zonesData.zones.length) return 1;
        const maxId = Math.max(...zonesData.zones.map((zone) => zone.id));
        return maxId + 1;
    };

    const zonesCollide = (newZonePoints) => {
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
    };

    finishButton.addEventListener("click", async () => {
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

            try {
                const response = await fetch("/api/map/zones", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(newZone),
                });

                const result = await response.json();
                console.log("Zone creation result:", result);

                fetchZones();

                tempMarkers.forEach((marker) => marker.remove());
                tempMarkers = [];

                editor_status = "none";
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
    });

    mapboxgl.accessToken =
        "pk.eyJ1IjoidXJiYW50cmVlIiwiYSI6ImNtNHI4MXNhaTAxc3gybHNpMWp3ejJldHcifQ.d94SBSjOt6Ylu4A8PKPFiQ";

    const map = new mapboxgl.Map({
        container: "map",
        center: [0.5826405437646912, 40.70973485628924],
        style: "mapbox://styles/mapbox/standard-satellite",
        zoom: 15,
    });

    map.on("load", () => {
        fetchZones();
    });

    const inventoryContainer = document.querySelector("#filters");
    let markers = {};
    let zonesData = [];
    let zonePoints = [];
    let tempMarkers = [];
    let selectedZone = null;

    map.on("click", (e) => {
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
    });

    const fetchZones = async () => {
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
    };

    const renderZones = (zones) => {
        inventoryContainer.innerHTML = "";
        if (zones.length === 0) {
            const emptyMessage = document.createElement("p");
            emptyMessage.className = "text-gray-500 text-center mt-4";
            emptyMessage.innerText = "No hay zonas creadas.";
            inventoryContainer.appendChild(emptyMessage);
        } else {
            zones.forEach((zone) => {
                const zoneItem = createZoneItem(zone);
                inventoryContainer.appendChild(zoneItem);
                addZonePolygon(zone);
            });
        }
    };

    const createZoneItem = (zone) => {
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

        const showHideLabel = document.createElement("label");
        showHideLabel.className = "flex items-center space-x-2 cursor-pointer";
        showHideLabel.innerHTML = `
            <input type="checkbox" class="rounded-full border-gray-300" checked>
            <i class="fas fa-eye text-gray-700"></i>
        `;
        const showHideCheckbox = showHideLabel.querySelector("input");
        showHideCheckbox.dataset.zoneId = zone.id;
        showHideCheckbox.addEventListener("change", (e) =>
            handleZoneToggle(e, zone)
        );

        const colorPicker = createColorPicker(zone.id, zone.color);

        zoneControls.appendChild(showHideLabel);
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
    };

    const createElementTypeItem = (zone, type) => {
        const elementTypeItem = document.createElement("div");
        elementTypeItem.className =
            "flex items-center justify-between p-2 bg-gray-50 rounded-lg hover:bg-gray-200 transition ease-in-out duration-300";
        const elementCount = type.elements.length;
        elementTypeItem.innerHTML = `
            <span class="text-gray-700"><i class="${type.icon} text-xl mr-2"></i> ${type.name} (${elementCount} elementos)</span>
            <input type="checkbox" checked class="rounded-full border-gray-300" data-zone-id="${zone.id}" data-type-id="${type.id}">
        `;
        const checkbox = elementTypeItem.querySelector(
            "input[type='checkbox']"
        );
        checkbox.addEventListener("change", (e) =>
            handleElementTypeToggle(e, zone, type)
        );
        return elementTypeItem;
    };

    const handleZoneToggle = (event, zone) => {
        const isChecked = event.target.checked;
        const elementTypesContainer = document.querySelector(
            `#element-types-zone-${zone.id}`
        );
        const zoneItem = event.target.closest(".bg-white");

        let hiddenMessageDiv = zoneItem.querySelector(".zone-hidden-message");

        if (isChecked) {
            elementTypesContainer.style.display = "block";
            const polygonLayerId = `zone-polygon-layer-${zone.id}`;
            map.setLayoutProperty(polygonLayerId, "visibility", "visible");

            if (hiddenMessageDiv) {
                hiddenMessageDiv.remove();
            }

            zone.element_types.forEach((type) => {
                const typeCheckbox = document.querySelector(
                    `input[data-zone-id="${zone.id}"][data-type-id="${type.id}"]`
                );
                if (typeCheckbox.checked) addMarkersForElementType(zone, type);
            });
        } else {
            elementTypesContainer.style.display = "none";
            const polygonLayerId = `zone-polygon-layer-${zone.id}`;
            map.setLayoutProperty(polygonLayerId, "visibility", "none");

            if (!hiddenMessageDiv) {
                hiddenMessageDiv = document.createElement("div");
                hiddenMessageDiv.className =
                    "zone-hidden-message text-gray-700 mt-2 p-4";
                hiddenMessageDiv.innerHTML = "Zona actualmente oculta.";
                zoneItem.insertBefore(hiddenMessageDiv, zoneItem.querySelector(".flex.justify-end.mt-4"));
            }

            removeMarkersForZone(zone);
        }
    };

    const handleElementTypeToggle = (event, zone, type) => {
        if (event.target.checked) {
            addMarkersForElementType(zone, type);
        } else {
            removeMarkersForElementType(zone, type);
        }
    };

    const addMarkersForElementType = (zone, type) => {
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
    };

    const removeMarkersForZone = (zone) => {
        if (markers[zone.id]) {
            Object.values(markers[zone.id])
                .flat()
                .forEach((marker) => marker.remove());
            delete markers[zone.id];
        }
    };

    const removeMarkersForElementType = (zone, type) => {
        if (markers[zone.id] && markers[zone.id][type.id]) {
            markers[zone.id][type.id].forEach((marker) => marker.remove());
            markers[zone.id][type.id] = [];
        }
    };

    const createMarkerElement = (icon, color) => {
        const markerElement = document.createElement("div");
        markerElement.style.cssText = `width: 40px; height: 40px; background-color: ${color}; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid white;`;
        markerElement.innerHTML = `<i class="${icon}" style="color: white; font-size: 20px;"></i>`;
        return markerElement;
    };

    const addZonePolygon = (zone) => {
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
    };

    const addPolygonSourceAndLayer = (
        zone,
        polygonSourceId,
        polygonLayerId
    ) => {
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
    };

    const updateZoneColorInDatabase = async (zoneId, color) => {
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
    };

    const updateZoneColor = (color, zoneId) => {
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
    };

    const hexToRgbaString = (hex, alpha = 1) => {
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
    };

    const createColorPicker = (zoneId, color) => {
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
    };

    window.deleteElement = (elementId) => {
        for (const zone of zonesData.zones) {
            for (const type of zone.element_types) {
                const elementIndex = type.elements.findIndex(
                    (el) => el.id === elementId
                );
                if (elementIndex !== -1) {
                    type.elements.splice(elementIndex, 1);
                    removeMarkersForElementType(zone, type);
                    addMarkersForElementType(zone, type);
                    renderZones(zonesData.zones);
                    alert(`Elemento ${elementId} eliminado exitosamente.`);
                    return;
                }
            }
        }
        console.error(`Elemento con ID ${elementId} no encontrado.`);
    };

    const removeZoneFeatures = (zoneId) => {
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
    };

    window.deleteZone = async (zoneId) => {
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
    };

    const elementModal = document.getElementById("element-modal");
    const elementModalTitle = document.getElementById("element-modal-title");
    const elementModalContent = document.getElementById("element-modal-content");
    const elementModalClose = document.getElementById("element-modal-close");

    elementModalClose.addEventListener("click", () => {
        elementModal.classList.add("hidden");
    });

    function showElementModal(el) {
        elementModalTitle.innerText = `Element ${el.id}`;
        elementModalContent.innerText = `Description: ${el.description || "No description available."}`;
        elementModal.classList.remove("hidden");
    }

    const createElementModal = document.getElementById("create-element-modal");
    const createElementForm = document.getElementById("create-element-form");
    const createElementType = document.getElementById("element-type");
    const createElementDescription = document.getElementById("element-description");
    const createElementTreeType = document.getElementById("element-tree-type");
    const treeTypeContainer = document.getElementById("tree-type-container");
    const createElementCancel = document.getElementById("create-element-cancel");

    let elementTypes = [];
    let treeTypes = [];

    createElementCancel.addEventListener("click", () => {
        createElementModal.classList.add("hidden");
    });

    createElementForm.addEventListener("submit", async (e) => {
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
            } else {
                alert(`Error: ${result.message}`);
            }
        } catch (error) {
            console.error("Create Element Error", error);
        }
    });

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

    createElementType.addEventListener("change", () => {
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
    });

    const toggleInventoryButton = document.getElementById("toggle-inventory");
    const inventorySidebar = document.querySelector(".inventory");
    const mapContainer = document.querySelector(".map");

    toggleInventoryButton.addEventListener("click", () => {
        inventorySidebar.classList.toggle("hidden");
        inventorySidebar.classList.toggle("w-5/6");
        mapContainer.classList.toggle("w-1/6");
    });

    loadElementTypes();
    loadTreeTypes();
});

