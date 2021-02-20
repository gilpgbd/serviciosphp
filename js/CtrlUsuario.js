import {
  configuraElimina,
  configuraSubmit,
  recibe
} from "../lib/servicios.js";
import {
  muestraError
} from "../lib/util.js";
import {
  muestraUsuarios
} from "./navegacion.js";
import {
  iniciaSesión,
  noAutorizado
} from "./seguridad.js";
import {
  checksRoles,
  selectPasatiempos
} from "./usuarios.js";

const params =
  new URL(location.href).
    searchParams;
const id = params.get("id");
/** @type {HTMLFormElement} */
const forma = document["forma"];
/** @type {HTMLButtonElement} */
const eliminar = document.
  querySelector("#eliminar");
const img = document.
  querySelector("img");
/** @type {HTMLUListElement} */
const listaRoles = document.
  querySelector("#listaRoles");

forma.objId.value = id;

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
      busca();
    } else {
      noAutorizado();
    }
  } else {
    iniciaSesión();
  }
}

async function busca() {
  try {
    /**
     * @type {
        import("./tipos.js").
                Usuario} */
    const usuario =
      await recibe(fetch(
        "srv/usuario.php?" +
        params));
    forma.cue.value = id || "";
    forma.nombre.value = usuario.nombre || "";
    img.src = usuario.avatar;
    selectPasatiempos(
      forma.pasatiempoId,
      usuario.pasatiempoId)
    checksRoles(
      listaRoles, usuario.rolIds);
    configuraSubmit(forma,
      "srv/usuarioModifica.php",
      "usuarios.html");
    configuraElimina(eliminar,
      "Confirma la eliminación",
      `srv/usuarioElimina?${params}`,
      "usuarios.html");
  } catch (e) {
    muestraError(e);
    muestraUsuarios();
  }
}