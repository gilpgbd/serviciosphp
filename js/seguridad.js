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

export function noAutorizado() {
  //Despliega un cuadro de alerta.
  alert("No autorizado.");
  // Abre la página index.html.
  location.href = "index.html";
}

/**
 * @param {string[]} roles
 * @returns {Promise<boolean>} */
export async function
  tieneRol(roles) {
  const usuario =
    await recibe(fetch(
      "srv/sesion.php?" +
      params));
  if (usuario && usuario.cue) {
    const rolIds = new Set(
      usuario.rolIds || []);
    for (const rol of roles) {
      if (roles.has(rol)) {
        return true;
      }
    }
    noAutorizado();
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
