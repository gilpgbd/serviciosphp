import {
  configuraElimina,
  configuraSubmit,
  recibe
} from "../lib/servicios.js";
import {
  muestraError
} from "../lib/util.js";
import {
  tieneRol
} from "./seguridad.js";

const params =
  new URL(location.href).
    searchParams;
const id = params.get("id");
/** @type {HTMLFormElement} */
const forma = document["forma"];
/** @type {HTMLButtonElement} */
const eliminar = document.
  querySelector("#eliminar");

forma.objId.value = id;

protege();
async function protege() {
  if (await tieneRol(
    ["Cliente"])) {
    busca();
  }
}
/** Busca y muestra los datos que
 * corresponden al id recibido. */
async function busca() {
  try {
    /**
     * @type {
        import("./tipos.js").
                Pasatiempo} */
    const pasatiempo =
      await recibe(fetch(
        "srv/pasatiempo.php?" +
        params));
    forma.nombre.value =
      pasatiempo.nombre || "";
    configuraSubmit(forma,
      "srv/pasatiempoModifica.php",
      "pasatiempos.html");
    configuraElimina(eliminar,
      "Confirma la eliminación",
      "srv/pasatiempoElimina?" +
      params,
      "pasatiempos.html");
  } catch (e) {
    muestraError(e);
    location.href =
      "pasatiempos.html";
  }
}
