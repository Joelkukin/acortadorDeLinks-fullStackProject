import React, { useState, useEffect } from 'react';
import TablaCrud from '../components/TablaCrud';
import ajaxReact from '../controllers/ajax';
import { Button } from '@mui/material';

function LinksManager() {
  const [links, setLinks] = useState([]);
  const [token, setToken] = useState(localStorage.getItem('token'));
  const [error, setError] = useState(null);
  const [originalLinks, setOriginalLinks] = useState([]);

  useEffect(() => {
    ajaxReact({ // al solicitar los datos a la api, se guardan en los estados 
      setRespServidor: (data) => {
        setLinks(data);
        setOriginalLinks(JSON.parse(JSON.stringify(data))); // Copia profunda
      },
      uri: `/links`,
      fetchData: {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`
        }
      },
      setError
    })
  }, []);

  const saveChanges = async () => {
    console.log("saveChanges Clicked");
    setLinks(prevState => {
      prevState.push({
        link_src: "alias",
        link_target: "Link de destino",
        owner: "Joelkukin",
        qr_img: null
      })
      return
    })
  };

  const closeSession = () => {
    console.log("cerrar sesion clicked")
    localStorage.removeItem('token');
    window.location.href = "/login"
  };


  return (
    <>
      <Button onClick={closeSession}>Cerrar Sesion</Button>
      <h1 style={{ marginTop: '0em' }}>Link Manager</h1>
      {error ? (
        <p style={{ color: 'red' }}>{error}</p>
      ) : (
        <TablaCrud data={links} dataHandler={setLinks} />
      )}
      <Button onClick={saveChanges}>Guardar Cambios</Button>

    </>
  );
}


export default LinksManager;