import {
  recibe
} from "../lib/servicios.js";
import {
  cod, muestraError
} from "../lib/util.js";

const SIN_PASATIEMPO = /* html */
  `<option value="">
    -- Sin Pasatiempo --
  </option>`;

/**
 * @param {
    HTMLSelectElement} select
 * @param {string} valor */
export async function
  selectPasatiempos(select,
    valor) {
  valor = valor || "";
  try {
    /**@type {
        import("./tipos.js").
        Pasatiempo[]} */
    const pasatiempos =
      await recibe(fetch(
        "srv/pasatiempos.php"));
    let html = SIN_PASATIEMPO;
    for (const p of pasatiempos) {
      const selected =
        p.id === valor ?
          "selected" : "";
      html += /* html */
        `<option
          value="${cod(p.id)}"
          ${selected}>
        ${cod(p.nombre)}
      </option>`;
    }
    select.innerHTML = html;
  } catch (e) {
    muestraError(e);
  }
}

/**
 * @param {HTMLElement} elemento
 * @param {string[]} valor */
export async function
  checksRoles(elemento, valor) {
  const set =
    new Set(valor || []);
  try {
    /**@type {
        import("./tipos.js").
        Rol[]} */
    const roles =
      await recibe(fetch(
        "srv/roles.php"));
    let html = "";
    if (roles.length > 0) {
      for (const r of roles) {
        const checked =
          set.has(r.id) ?
            "checked" : "";
        html += /* html */
          `<li>
          <label class="fila">
            <input type="checkbox"
                name="rolIds[]"
                value=
                "${cod(r.id)}"
                ${checked}>
            <span class="texto">
              <strong
               class="primario">
                ${cod(r.id)}
              </strong>
              <span
               class="secundario">
              ${cod(
            r.descripcion)}
              </span>
            </span>
          </label>
        </li>`;
      }
    } else {
      html += /* html */
        `<li class="vacio">
        -- No hay roles
        registrados. --
      </li>`;
    }
    elemento.innerHTML = html;
  } catch (e) {
    muestraError(e);
  }
}