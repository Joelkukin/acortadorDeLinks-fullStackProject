import { useState } from "react";

// retorna una funcion lista para ejecutar

export const ajaxReact = async ({
  uri,
  fetchData,
  setRespServidor = console.log,
  setError = console.error,
}) => {

    try { // preparo la solicitud al servidor
      const url_api = `http://${process.env.BACKEND_API_URL}${uri}`;
      console.log("ajax.js/fetchData: ",fetchData)
      const response = await fetch(url_api, fetchData);
  
      const data = await response;
      
      console.log("fetchdata: ",fetchData)
      console.log("data: ",data)
  
      if (data.ok) {
        (async()=>{
          // si la respuesta del servidor es un json, Muestro la respuesta, sino, muestro el error
          let dataParsed = await data.text()
          console.log(dataParsed)
          esJson(dataParsed)?
            setRespServidor(JSON.parse(dataParsed)):
            setError(dataParsed);
        })()
      } else { // si ocurrió un error al traer los datos del servidor, lo muestro como alerta
        (async()=>{
          console.log(await data.text())
          setError('Ocurrió un error al traer los datos del servidor: '+ await data.text());
  
        })()
      }
    } catch (error) {
      (async()=>{
        console.log(await data.text())
        setError('Ocurrió un error al traer los datos del servidor: '+ await data.text());

      })()
      setError(error.message);
    }
  }

  function esJson(str) {
    // Comprueba si el string empieza con "<"
    if (str.startsWith("<")) {
        return false;
    }
    // Comprueba si el string empieza con "{" o "["
    else if (str.startsWith("{") || str.startsWith("[")) {
        return true;
    }
    // Si no cumple ninguna de las condiciones anteriores, devuelve false
    else {
        return false;
    }
  }
  
export default ajaxReact;