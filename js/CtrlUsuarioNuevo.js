import {
  configuraSubmit
} from "../lib/servicios.js";
import {
  tieneRol
} from "./seguridad.js";
import {
  checksRoles,
  selectPasatiempos
} from "./usuarios.js";

/** @type {HTMLFormElement} */
const forma = document["forma"];
/** @type {HTMLUListElement} */
const listaRoles = document.
  querySelector("#listaRoles");

protege();
async function protege() {
  if (await tieneRol(
    ["Administrador"])) {
    selectPasatiempos(
      forma.pasatiempoId, "");
    checksRoles(listaRoles, []);
    configuraSubmit(forma,
      "srv/usuarioAgrega.php",
      "usuarios.html");
  }
}
