import {
  realiza, recibe
} from "../lib/servicios.js";
import {
  muestraError
} from "../lib/util.js";


export function
  iniciaSesión() {
  location.href = "inicia.html";
}

/**
 * @param {string[]} roles
 * @returns {Promise<boolean>} */
export async function
  tieneRol(roles) {
  const usuario =
    await recibe(fetch(
      "srv/sesion.php"));
  if (usuario && usuario.cue) {
    const rolIds = new Set(
      usuario.rolIds || []);
    for (const rol of roles) {
      if (rolIds.has(rol)) {
        return true;
      }
    }
    alert("No autorizado.");
    location.href = "index.html";
  } else {
    iniciaSesión();
  }
  return false;
}

export async function
  terminaSesión() {
  try {
    await realiza(fetch(
      "srv/termina.php"));
    iniciaSesión();
  } catch (e) {
    muestraError(e);
  }
}

/**
 * @returns {Promise<Set<string>>}
 */
export async function
  cargaRoles() {
  try {
    /**@type {string[]} */
    const roles =
      await recibe(fetch(
        "srv/sesionRoles.php"));
    return new Set(roles || []);
  } catch (e) {
    muestraError(e);
    return new Set();
  }
}
