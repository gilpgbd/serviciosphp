import {
  recibe
} from "../lib/servicios.js";
import {
  cod,
  muestraError
} from "../lib/util.js";
import {
  tieneRol
} from "./seguridad.js";

/** @type {HTMLUListElement} */
const lista = document.
  querySelector("#lista");
protege();
async function protege() {
  if (await tieneRol(
    ["Cliente"])) {
    consulta();
  }
}
async function consulta() {
  try {
    /** @type {
      import("./tipos.js").
      Pasatiempo[]} */
    const pasatiempos =
      await recibe(fetch(
        "srv/pasatiempos.php"));
    let html = "";
    if (pasatiempos.length > 0) {
      for (const p of
        pasatiempos) {
        const parámetros =
          new URLSearchParams();
        parámetros.
          append("id", p.id);
        const nombre =
          cod(p.nombre);
        html += /* html */
          `<li>
            <a class="fila" href=
  "pasatiempo.html?${parámetros}">
              <strong
                class="primario">
                ${nombre}
              </strong>
            </a>
          </li>`;
      }
    } else {
      html += /* html */
        `<li class="vacio">
              -- No hay
              pasatiempos
              registrados. --
            </li>`;
    }
    lista.innerHTML = html;
  } catch (e) {
    muestraError(e);
  }
}
