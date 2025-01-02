// Script for the dropdown menu
const openMoreButton = document.getElementById("openMore");
const firstPanel = document.getElementById("firstPanel");
const openFiltersButton = document.getElementById("openFilters");
const filterPanel = document.getElementById("filterPanel");

// Estados para los paneles
let isFirstPanelOpen = false;
let isFilterPanelOpen = false;

// Mostrar/Ocultar el primer panel
openMoreButton.addEventListener("click", () => {
    if (!isFirstPanelOpen) {
        firstPanel.classList.remove("hidden");
        isFirstPanelOpen = true;
    } else {
        firstPanel.classList.add("hidden");
        filterPanel.classList.add("hidden"); // Ocultar también el filtro si está abierto
        isFirstPanelOpen = false;
        isFilterPanelOpen = false;
    }
});

// Mostrar/Ocultar el panel de filtros
openFiltersButton.addEventListener("click", () => {
    if (!isFilterPanelOpen) {
        filterPanel.classList.remove("hidden");
        isFilterPanelOpen = true;
    } else {
        filterPanel.classList.add("hidden");
        isFilterPanelOpen = false;
    }
});
// --------------------------------------------
// Function of the map
const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/satellite-streets-v12", // Estil del mapa
    projection: "globe", // Display the map as a globe, since satellite-v9 defaults to Mercator
    zoom: 12,
    center: [-0.3763, 39.4699],
});

map.addControl(new mapboxgl.NavigationControl()); // Ampliar o alejar-se con el cursor

map.on("style.load", () => {
    map.setFog({}); // Set the default atmosphere style
});

// The following values can be changed to control rotation speed:

// At low zooms, complete a revolution every two minutes.
const secondsPerRevolution = 240;
// Above zoom level 5, do not rotate.
const maxSpinZoom = 5;
// Rotate at intermediate speeds between zoom levels 3 and 5.
const slowSpinZoom = 3;

let userInteracting = false;
const spinEnabled = true;

function spinGlobe() {
    const zoom = map.getZoom();
    if (spinEnabled && !userInteracting && zoom < maxSpinZoom) {
        let distancePerSecond = 360 / secondsPerRevolution;
        if (zoom > slowSpinZoom) {
            // Slow spinning at higher zooms
            const zoomDif = (maxSpinZoom - zoom) / (maxSpinZoom - slowSpinZoom);
            distancePerSecond *= zoomDif;
        }
        const center = map.getCenter();
        center.lng -= distancePerSecond;
        // Smoothly animate the map over one second.
        // When this animation is complete, it calls a 'moveend' event.
        map.easeTo({ center, duration: 1000, easing: (n) => n });
    }
}

// Pause spinning on interaction
map.on("mousedown", () => {
    userInteracting = true;
});
map.on("dragstart", () => {
    userInteracting = true;
});

// When animation is complete, start spinning if there is no ongoing interaction
map.on("moveend", () => {
    spinGlobe();
});

spinGlobe();

// Location User
if ("geolocation" in navigator) {
    navigator.geolocation.watchPosition(
        (position) => {
            const userCoords = [
                position.coords.longitude,
                position.coords.latitude,
            ];

            // Agrega un marcador o un punto para mostrar la ubicación
            const userMarker = new mapboxgl.Marker({ color: "blue" })
                .setLngLat(userCoords)
                .addTo(map);

            // Centra el mapa en la ubicación del usuario
            map.setCenter(userCoords);
            map.setZoom(15);
        },
        (error) => {
            console.error("Error obteniendo la ubicación:", error);
        },
        {
            enableHighAccuracy: true,
        }
    );
} else {
    alert("La geolocalización no está soportada en este navegador.");
}

// Marker in movement
let userMarker;

navigator.geolocation.watchPosition(
    (position) => {
        const userCoords = [
            position.coords.longitude,
            position.coords.latitude,
        ];

        if (!userMarker) {
            // Crea el marcador si no existe
            userMarker = new mapboxgl.Marker({ color: "blue" })
                .setLngLat(userCoords)
                .addTo(map);
        } else {
            // Actualiza la posición del marcador
            userMarker.setLngLat(userCoords);
        }

        // Opcional: centra el mapa si el usuario se mueve
        map.setCenter(userCoords);
    },
    (error) => {
        console.error("Error obteniendo la ubicación:", error);
    },
    {
        enableHighAccuracy: true,
        maximumAge: 0,
    }
);

//GeoJSON
map.on("load", () => {
    // Agregar fuente con GeoJSON
    map.addSource("valencia-area", {
        type: "geojson",
        data: {
            type: "FeatureCollection",
            features: [
                // Zona: Polígono
                {
                    type: "Feature",
                    geometry: {
                        type: "Polygon",
                        coordinates: [
                            [
                                [-0.379946, 39.472606], // Estación del Norte
                                [-0.377255, 39.470085], // Mercado Central
                                [-0.374091, 39.470914], // Plaza Redonda
                                [-0.372027, 39.472846], // Plaza de la Reina
                                [-0.374709, 39.475012], // Torres de Serranos
                                [-0.378901, 39.474073], // Plaza del Ayuntamiento
                                [-0.379946, 39.472606], // Cierra el polígono
                            ],
                        ],
                    },
                    properties: {
                        name: "Centro Histórico de Valencia",
                        description:
                            "Una de las zonas más emblemáticas de Valencia, que incluye plazas, mercados y torres históricas.",
                    },
                },
                // Punto: Plaza del Ayuntamiento
                {
                    type: "Feature",
                    geometry: {
                        type: "Point",
                        coordinates: [-0.3789, 39.474],
                    },
                    properties: {
                        name: "Plaza del Ayuntamiento",
                        description:
                            "Centro neurálgico de Valencia con vistas icónicas y actividades culturales.",
                    },
                },
                // Punto: Mercado Central
                {
                    type: "Feature",
                    geometry: {
                        type: "Point",
                        coordinates: [-0.377255, 39.470085],
                    },
                    properties: {
                        name: "Mercado Central",
                        description:
                            "Un mercado icónico lleno de productos frescos y arquitectura modernista.",
                    },
                },
                // Punto: Plaza de la Reina
                {
                    type: "Feature",
                    geometry: {
                        type: "Point",
                        coordinates: [-0.372027, 39.472846],
                    },
                    properties: {
                        name: "Plaza de la Reina",
                        description:
                            "Una plaza histórica rodeada de cafeterías y la famosa Catedral de Valencia.",
                    },
                },
            ],
        },
    });

    // Añadir capas de polígono y puntos
    map.addLayer({
        id: "valencia-boundary",
        type: "fill",
        source: "valencia-area",
        paint: {
            "fill-color": "#0080ff",
            "fill-opacity": 0.3,
        },
        filter: ["==", "$type", "Polygon"],
    });

    map.addLayer({
        id: "valencia-points",
        type: "circle",
        source: "valencia-area",
        paint: {
            "circle-radius": 6,
            "circle-color": "#ff5733",
        },
        filter: ["==", "$type", "Point"],
    });

    // Evento para clic en el polígono
    map.on("click", "valencia-boundary", (e) => {
        const coordinates = e.lngLat;
        const properties = e.features[0].properties;

        new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(
                `<strong>${properties.name}</strong><p>${properties.description}</p>`
            )
            .addTo(map);
    });

    // Evento para clic en los puntos
    map.on("click", "valencia-points", (e) => {
        const coordinates = e.features[0].geometry.coordinates.slice();
        const properties = e.features[0].properties;

        new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(
                `<strong>${properties.name}</strong><p>${properties.description}</p>`
            )
            .addTo(map);
    });

    // Cambiar el cursor a "pointer" al pasar por los puntos o la zona
    map.on("mouseenter", "valencia-boundary", () => {
        map.getCanvas().style.cursor = "pointer";
    });
    map.on("mouseleave", "valencia-boundary", () => {
        map.getCanvas().style.cursor = "";
    });
    map.on("mouseenter", "valencia-points", () => {
        map.getCanvas().style.cursor = "pointer";
    });
    map.on("mouseleave", "valencia-points", () => {
        map.getCanvas().style.cursor = "";
    });
});
