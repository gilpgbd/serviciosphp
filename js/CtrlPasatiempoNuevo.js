import {
  configuraSubmit, recibe
} from "../lib/servicios.js";
import {
  tieneRol
} from "./seguridad.js";

/** @type {HTMLFormElement} */
const forma = document["forma"];

protege();
async function protege() {
  if (await tieneRol(["Cliente"])) {
      configuraSubmit(forma,
        "srv/pasatiempoAgrega.php",
        "pasatiempos.html");
  }
}
