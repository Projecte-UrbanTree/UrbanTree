<div id="map" class="relative">
    <!-- Button to open the filter panel -->
    <button id="openMore" class="absolute z-10 bottom-5 right-5 p-2 bg-blue-500 text-white rounded-full">
        <img id="plusIcon" src="/assets/images/More.png" alt="+" class="w-8 h-8 transition-transform duration-300">
    </button>
    <!-- First Panel -->
    <div id="firstPanel" class="absolute z-10 bottom-0 right-20 bg-white shadow-lg sm:w-64 h-2/5 p-5 hidden rounded-xl flex flex-col justify-between">
        <button class="text-xl text-left" id="openFiltersZones">
            <span class="text-lg font-semibold">Filter Zone</span>
        </button>
        <button class="text-xl text-left" id="openFiltersElements">
            <span class="text-lg font-semibold">Filter Element</span>
        </button>
        <button class="text-xl text-left" id="openZones">
            <span class="text-lg font-semibold">Add Zones</span>
        </button>
        <button class="text-xl text-left" id="openElements">
            <span class="text-lg font-semibold">Add Elements</span>
        </button>
    </div>

    <!-- Zones Panel -->
    <div id="filterPanelZones" class="absolute z-10 bottom-0 right-[calc(64px*5.2)] bg-white shadow-lg sm:w-64 h-1/4 p-5 hidden rounded-xl">
        <div class="space-y-2" id="zonesContainer">
            <!-- Here we will add the zones -->
        </div>
        <button class="absolute z-10 bottom-5 right-5 p-2 bg-blue-500 text-white rounded-full">
            <span class="material-icons">Apply</span>
        </button>
    </div>

    <!-- Elements Panel -->
    <div id="filterPanelElements" class="absolute z-10 bottom-0 right-[calc(64px*5.2)] bg-white shadow-lg sm:w-64 h-1/4 p-5 hidden rounded-xl">
        <div class="space-y-2" id="elementsContainer">
            <!-- Here we will add the elements -->
            <button class="absolute text-xl top-1/3" id="openFiltersElements">
                <span class="text-lg font-semibold">Elements</span>
            </button>
        </div>
        <button class="absolute z-10 bottom-5 right-5 p-2 bg-blue-500 text-white rounded-full">
            <span class="material-icons">Apply</span>
        </button>
    </div>

    <!-- Add Zones Panel -->
    <div id="secondPanel" class="absolute z-10 bottom-0 right-[calc(64px*5.2)] bg-white shadow-lg sm:w-64 h-1/4 p-5 hidden rounded-xl">
        <span>Zones</span>
    </div>
    <!-- Add Elements Panel -->
    <div id="thirdPanel" class="absolute z-10 bottom-0 right-[calc(64px*5.2)] bg-white shadow-lg sm:w-64 h-1/4 p-5 hidden rounded-xl">
        <span>Elements</span>
    </div>
    <div class="absolute bottom-5 inset-x-0 flex justify-center items-center">
        <!-- Mensaje para Zonas -->
        <div id="zoneMessage" class="hidden flex items-center bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-lg w-2/3 max-w-lg z-10">
            <svg class="h-6 w-6 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 17h0a4.978 4.978 0 01-1.5-.215m1.5.215a4.978 4.978 0 001.5-.215m-3 0a4.978 4.978 0 00-1.5-.215h0a4.978 4.978 0 00-1.5.215m3-10a4.978 4.978 0 011.5.215m-1.5-.215A4.978 4.978 0 0010.5 6.785m2.5 0A4.978 4.978 0 0113 6.215M12 17h0a4.978 4.978 0 01-1.5-.215m1.5.215a4.978 4.978 0 001.5-.215" />
            </svg>
            <span>Por favor pon puntos dónde quieres crear la zona.</span>
        </div>

        <!-- Mensaje para Elementos -->
        <div id="elementMessage" class="hidden flex items-center bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-lg w-2/3 max-w-lg z-10">
            <svg class="h-6 w-6 mr-2 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 17h0a4.978 4.978 0 01-1.5-.215m1.5.215a4.978 4.978 0 001.5-.215m-3 0a4.978 4.978 0 00-1.5-.215h0a4.978 4.978 0 00-1.5.215m3-10a4.978 4.978 0 011.5.215m-1.5-.215A4.978 4.978 0 0010.5 6.785m2.5 0A4.978 4.978 0 0113 6.215M12 17h0a4.978 4.978 0 01-1.5-.215m1.5.215a4.978 4.978 0 001.5-.215" />
            </svg>
            <span>Por favor seleccione dónde quieres crear el elemento.</span>
        </div>
    </div>
</div>

<script>
    const plusIcon = document.getElementById('plusIcon');
    let isRotated = false;

    const openMoreButton = document.getElementById("openMore");
    const firstPanel = document.getElementById("firstPanel");
    const openElementsButton = document.getElementById("openFiltersElements");
    const filterPanelElements = document.getElementById("filterPanelElements");
    const openAddZonesButton = document.querySelector("#openZones");
    const secondPanel = document.getElementById("secondPanel");
    const openAddElementsButton = document.querySelector("#openElements");
    const thirdPanel = document.getElementById("thirdPanel");
    const filterPanelZones = document.querySelector("#filterPanelZones");

    const Panels = [firstPanel, filterPanelZones, filterPanelElements, secondPanel, thirdPanel];

    function openFilterPanel(panel, isPanelOpen) {
        if (panel) {
            if (!isPanelOpen) {
                panel.classList.remove("hidden");
                return true;
            } else {
                panel.classList.add("hidden");
                return false;
            }
        } else {
            console.error("Panel no encontrado.");
            return false;
        }
    }

    let isFirstPanelOpen = false;
    let isFilterPanelZonesOpen = false;
    let isFilterPanelElementsOpen = false;

    openMoreButton.addEventListener("click", () => {
        rotateIcon();
        isFirstPanelOpen = openFilterPanel(firstPanel, isFirstPanelOpen);
        Panels.forEach(panel => {
            if (panel !== firstPanel) {
                panel.classList.add("hidden");
            }
        });
    });

    function rotateIcon() {
        plusIcon.style.transform = isRotated ? 'rotate(0deg)' : 'rotate(45deg)';
        isRotated = !isRotated;
    }

    if (openAddZonesButton) {
        openAddZonesButton.addEventListener("click", () => {
            showMessage('zone');
        });
    }

    if (openAddElementsButton) {
        openAddElementsButton.addEventListener("click", () => {
            showMessage('element');
        });
    }

    function showMessage(type) {
        Panels.forEach(panel => panel.classList.add("hidden"));
        rotateIcon();
        isFirstPanelOpen = false;

        const zoneMessage = document.getElementById('zoneMessage');
        const elementMessage = document.getElementById('elementMessage');

        zoneMessage?.classList.add('hidden');
        elementMessage?.classList.add('hidden');

        if (type === 'zone') {
            zoneMessage?.classList.remove('hidden');
        } else if (type === 'element') {
            elementMessage?.classList.remove('hidden');
        }

        setTimeout(() => {
            zoneMessage?.classList.add('hidden');
            elementMessage?.classList.add('hidden');
        }, 5000);
    }
</script>

<script>
    // Initialize the map
    mapboxgl.accessToken = '<?= getenv("MAPBOX_TOKEN") ?>';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-streets-v12', // Style of the map
        projection: 'globe', // Display the map as a globe, since satellite-v9 defaults to Mercator
        zoom: 12,
        center: [-0.3763, 39.4699]
    });

    map.addControl(new mapboxgl.NavigationControl()); // Zoom in or out with the cursor

    map.on('style.load', () => {
        map.setFog({}); // Set the default atmosphere style
    });

    // Create a blue dot with a vision cone
    function createBlueDot() {
        const el = document.createElement('div');
        el.className = 'blue-dot';
        el.style.width = '12px';
        el.style.height = '12px';
        el.style.backgroundColor = '#007AFF';
        el.style.border = '2px solid white';
        el.style.borderRadius = '50%';
        el.style.boxShadow = '0 0 5px rgba(0, 122, 255, 0.5)';
        return el;
    }

    let blueDotMarker;
    let visionConeLayer;

    navigator.geolocation.watchPosition(
        (position) => {
            const { latitude, longitude } = position.coords;
            const userLocation = [longitude, latitude];
            const userOrientation = 45; // Angle of the vision cone in degrees

            // Create or update the blue dot marker
            if (!blueDotMarker) {
                blueDotMarker = new mapboxgl.Marker({ element: createBlueDot() })
                    .setLngLat(userLocation)
                    .addTo(map);
            } else {
                blueDotMarker.setLngLat(userLocation);
            }

            // Create or update the vision cone
            const radius = 0.07; // Radius of the cone in kilometers
            const coneCoordinates = [];
            for (let i = -30; i <= 30; i++) {
                const angle = (userOrientation + i) * (Math.PI / 180);
                const dx = radius * Math.cos(angle);
                const dy = radius * Math.sin(angle);
                coneCoordinates.push([userLocation[0] + dx / 111, userLocation[1] + dy / 111]);
            }
            coneCoordinates.push(userLocation);

            const visionConeData = {
                type: 'Feature',
                geometry: {
                    type: 'Polygon',
                    coordinates: [coneCoordinates]
                }
            };

            if (!map.getSource('vision-cone')) {
                map.addSource('vision-cone', {
                    type: 'geojson',
                    data: visionConeData
                });

                map.addLayer({
                    id: 'vision-cone-layer',
                    type: 'fill',
                    source: 'vision-cone',
                    paint: {
                        'fill-color': 'rgba(0, 122, 255, 0.3)',
                        'fill-opacity': 0.5
                    }
                });
            } else {
                map.getSource('vision-cone').setData(visionConeData);
            }

            // Center the map on the current location
            map.flyTo({
                center: userLocation,
                zoom: 15,
                essential: true
            });
        },
        (error) => {
            console.error('Error getting location:', error);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );

    // GeoJSON
    map.on('load', () => {
        // Add source with GeoJSON
        map.addSource('valencia-area', {
            'type': 'geojson',
            'data': {
                'type': 'FeatureCollection',
                'features': [
                    // Zone: Polygon
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Polygon',
                            'coordinates': [
                                [
                                    [-0.379946, 39.472606], // Estación del Norte
                                    [-0.377255, 39.470085], // Mercado Central
                                    [-0.374091, 39.470914], // Plaza Redonda
                                    [-0.372027, 39.472846], // Plaza de la Reina
                                    [-0.374709, 39.475012], // Torres de Serranos
                                    [-0.378901, 39.474073], // Plaza del Ayuntamiento
                                    [-0.379946, 39.472606]  // Close the polygon
                                ]
                            ]
                        },
                        'properties': {
                            'name': 'Historic Center of Valencia',
                            'description': 'One of the most emblematic areas of Valencia, including squares, markets, and historic towers.'
                        }
                    },
                    // Point: Plaza del Ayuntamiento
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [-0.3789, 39.4740]
                        },
                        'properties': {
                            'name': 'Plaza del Ayuntamiento',
                            'description': 'The nerve center of Valencia with iconic views and cultural activities.'
                        }
                    },
                    // Point: Mercado Central
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [-0.377255, 39.470085]
                        },
                        'properties': {
                            'name': 'Mercado Central',
                            'description': 'An iconic market full of fresh products and modernist architecture.'
                        }
                    },
                    // Point: Plaza de la Reina
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [-0.372027, 39.472846]
                        },
                        'properties': {
                            'name': 'Plaza de la Reina',
                            'description': 'A historic square surrounded by cafes and the famous Valencia Cathedral.'
                        }
                    }
                ]
            }
        });

        // Add polygon and point layers
        map.addLayer({
            'id': 'valencia-boundary',
            'type': 'fill',
            'source': 'valencia-area',
            'paint': {
                'fill-color': '#0080ff',
                'fill-opacity': 0.3
            },
            'filter': ['==', '$type', 'Polygon']
        });

        map.addLayer({
            'id': 'valencia-points',
            'type': 'circle',
            'source': 'valencia-area',
            'paint': {
                'circle-radius': 6,
                'circle-color': '#ff5733'
            },
            'filter': ['==', '$type', 'Point']
        });

        // Add custom marker icon
        map.loadImage('/assets/images/Cursor-marker.png', (error, image) => {
            if (error) throw error;
            map.addImage('custom-marker', image);

            map.addLayer({
                'id': 'valencia-points',
                'type': 'symbol',
                'source': 'valencia-area',
                'layout': {
                    'icon-image': 'custom-marker',
                    'icon-size': 0.5 // Adjust the icon size as needed
                },
                'filter': ['==', '$type', 'Point']
            });
        });

        // Event for clicking on the polygon
        map.on('click', 'valencia-boundary', (e) => {
            const coordinates = e.lngLat;
            const properties = e.features[0].properties;

            new mapboxgl.Popup()
                .setLngLat(coordinates)
                .setHTML(`<strong>${properties.name}</strong><p>${properties.description}</p>`)
                .addTo(map);
        });

        // Event for clicking on the points
        map.on('click', 'valencia-points', (e) => {
            const coordinates = e.features[0].geometry.coordinates.slice();
            const properties = e.features[0].properties;

            new mapboxgl.Popup()
                .setLngLat(coordinates)
                .setHTML(`<strong>${properties.name}</strong><p>${properties.description}</p>`)
                .addTo(map);
        });

        // Change the cursor to "pointer" when hovering over points or the zone
        map.on('mouseenter', 'valencia-boundary', () => {
            map.getCanvas().style.cursor = 'pointer';
        });
        map.on('mouseleave', 'valencia-boundary', () => {
            map.getCanvas().style.cursor = '';
        });
        map.on('mouseenter', 'valencia-points', () => {
            map.getCanvas().style.cursor = 'pointer';
        });
        map.on('mouseleave', 'valencia-points', () => {
            map.getCanvas().style.cursor = '';
        });
    });
</script>

<style>
    .blue-dot {
        width: 12px;
        height: 12px;
        background-color: #007AFF;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 122, 255, 0.5);
    }
</style>