import {
  configuraSubmit, recibe
} from "../lib/servicios.js";
import {
  iniciaSesión,
  noAutorizado
} from "./seguridad.js";

/** @type {HTMLFormElement} */
const forma = document["forma"];

protege();
async function protege() {
  const usuario =
    await recibe(fetch(
      "srv/sesion.php"));
  if (usuario && usuario.cue) {
    const roles = new Set(
      usuario.rolIds || []);
    if (roles.
      has("Cliente")) {
      configuraSubmit(forma,
        "srv/pasatiempoAgrega.php",
        "pasatiempos.html");
    } else {
      noAutorizado();
    }
  } else {
    iniciaSesión();
  }
}