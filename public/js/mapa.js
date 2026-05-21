const map = L.map('map-local').setView([-21.20474, -47.81238], 16);

const layer = L.tileLayer(
    'https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png',
    {
        attribution: '&copy; Stadia Maps'
    }
);

layer.addTo(map);

const marker = L.marker([-21.20474, -47.81238]).bindPopup('Psicólogo Neuropsicólogo Terapia Cognitivo Comportamental Daniel Lataro De Robbio');

marker.addTo(map);