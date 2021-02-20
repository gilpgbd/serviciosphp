import {
  recibe
} from "../lib/servicios.js";
import {
  cod,
  muestraError
} from "../lib/util.js";
import {
  iniciaSesión,
  noAutorizado
} from "./seguridad.js";

/** @type {HTMLUListElement} */
const lista = document.
  querySelector("#lista");
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
      consulta();
    } else {
      noAutorizado();
    }
  } else {
    iniciaSesión();
  }
}
async function consulta() {
  try {
    /** @type {import("./tipos.js").Usuario[]} */
    const usuarios =
      await recibe(fetch(
        "srv/usuarios.php"));
    let html = "";
    if (usuarios.length > 0) {
      for (const u of usuarios) {
        const parámetros =
          new URLSearchParams();
        parámetros.append("id", u.cue);
        const avatar = cod(u.avatar);
        const cue = cod(u.cue);
        const pasatiempo = cod(u.pasatiempo);
        const roles = u.roles.split(",").map(cod).join("<br>");
        html += /* html */
          `<li>
            <a class="fila conImagen"
href="usuario.html?${parámetros}">
              <span class="marco">
                <img src="${avatar}"
                  alt="Falta el Avatar">
              </span>
              <span class="texto">
                <strong
                    class="primario">
                  ${cue}
                </strong>
                <span
                    class="secundario">
                  ${pasatiempo}<br>
                  ${roles}
                </span>
              </span>
            </a>
          </li>`;
      }
    } else {
      html += /* html */
        `<li class="vacio">
              -- No hay usuarios
              registrados. --
            </li>`;
    }
    lista.innerHTML = html;
  } catch (e) {
    muestraError(e);
  }
}
