import {
  cargaRoles
} from "../js/seguridad.js";
import {
  muestraError
} from "../lib/util.js";

class MiNav extends HTMLElement {
  connectedCallback() {
    this.innerHTML = /* html */
      `<ul>
        <li>
          <a href="index.html">
            Sesión</a>
        </li>
      </ul>`;
    this.ul =
      this.querySelector("ul");
    this.cambiaUsuario();
  }
  async cambiaUsuario() {
    let html = "";
    const roles =
      await cargaRoles();
    /* Enlaces para solo
     * para clientes. */
    if (roles.has("Cliente")) {
      html += /* html */
        `<li>
          <a href=
"pasatiempos.html">Pasatiempos</a>
          </li>`;
    }
    /* Enlaces para solo
     * para administradores.
     */
    if (roles.has(
      "Administrador")) {
      html += /* html */
        `<li>
          <a href=
      "usuarios.html">Usuarios</a>
        </li>`;
    }
    this.ul.innerHTML += html;
  }
}
customElements.define(
  "mi-nav", MiNav);