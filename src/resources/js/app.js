import "./bootstrap";
import { apiEquipos, apiJugadores, apiPartidos } from "./api";

// Hacer las funciones API disponibles globalmente
window.apiEquipos = apiEquipos;
window.apiJugadores = apiJugadores;
window.apiPartidos = apiPartidos;

// Ejemplo de uso:
// apiEquipos.obtenerTodos().then(equipos => console.log('Equipos:', equipos));
// apiJugadores.obtenerTodos().then(jugadores => console.log('Jugadores:', jugadores));
// apiPartidos.obtenerTodos().then(partidos => console.log('Partidos:', partidos));
