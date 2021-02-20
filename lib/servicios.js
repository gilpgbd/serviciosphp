import { muestraError } from "./util.js";

/**
 * @param {Promise<Response>} prom
 * @returns {Promise<Object>}
 */
export async function
  recibe(prom) {
  const resp = await prom;
  if (resp.ok) {
    return await resp.json();
  } else if (
    resp.status === 500) {
    throw new Error(
      await resp.text());
  } else {
    throw new Error(
      resp.statusText);
  }
}
/**
 * @param {Promise<Response>} prom
 * @returns {Promise<void>}
 */
export async function
  realiza(prom) {
  const resp = await prom;
  if (resp.ok) {
    return;
  } else if (
    resp.status === 500) {
    throw new Error(
      await resp.text());
  } else {
    throw new Error(
      resp.statusText);
  }
}
/**
 * @param {HTMLFormElement} forma
 * @param {string} urlAcción
 * @param {string} urlÉxito
 */
export function configuraSubmit(forma, urlAcción, urlÉxito) {
  /**
   * @param {{ preventDefault: () => void; }} evt
   */
  forma.addEventListener(
    "submit",
    async evt => {
      try {
        evt.preventDefault();
        const formData =
          new FormData(forma);
        await realiza(fetch(
          urlAcción,
          {
            method: "POST",
            body: formData
          }));
        if (urlÉxito) {
          location.href = urlÉxito;
        }
      } catch (e) {
        muestraError(e);
      }
    });
}
/**
 * @param {HTMLElement} botón
 * @param {string} pregunta
 * @param {string} urlAcción
 * @param {string} urlÉxito
 */
export function configuraElimina(
  botón, pregunta, urlAcción,
  urlÉxito) {
  botón.addEventListener(
    "click",
    async () => {
      try {
        if (confirm(pregunta)) {
          await realiza(fetch(urlAcción));
          if (urlÉxito) {
            location.href = urlÉxito;
          }
        }
      } catch (e) {
        muestraError(e);
      }
    });
}