import { configuraSubmit, recibe } from "../lib/servicios.js";
import {
  getString,
  muestraError
} from "../lib/util.js";
import {
  cargaRoles,
  iniciaSesión,
  noAutorizado
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
    const usuario =
      await recibe(fetch(
        "srv/sesion.php"));
    if (usuario && usuario.cue) {
      const roles = new Set(
        usuario.rolIds || []);
      if (roles.has(
      "Administrador")) {
      selectPasatiempos(
        forma.pasatiempoId, "");
      checksRoles(listaRoles, []);
      configuraSubmit(forma,
        "srv/usuarioAgrega.php",
        "usuarios.html");
      } else {
      noAutorizado();
    }
  } else {
    iniciaSesión();
  }
}