import { useState, useEffect } from 'react';
import { 
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  TextField,
  TableContainer,
  Table,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
  Button 
} from '@mui/material';
import ajaxReact from '../controllers/ajax';
/* 
 * Quiero separar el modelo de la vista
 * Quiero que al recibir los datos, éstos ya tengan 
 * 
 * 
 * 
 * 
 * 
*/




function TablaCrud({ data , dataHandler}) {
  const [datos, setDatos] = [data, dataHandler];
  const [editarItem, setEditarItem] = useState(null);
  const [token, setToken] = useState(localStorage.getItem('token'));
  
  const [error, setError] = useState(null);
  const [popupVisible, setPopupVisible] = useState(false);
  const [isAdding, setIsAdding] = useState(false);

  
  /* useEffect(() => {
    if (datos.length === 0) {
      setDatos(data);
    }
  }, [datos]); */

/* Agregar un boton que al clickearlo abra un popup como de editar y que al darle aceptar, se cree un nuevo elemento en la tabla y se guarde en la base de datos */

  const handleEditar = (item) => {
    setEditarItem(item);
    setPopupVisible(true);
  };

  /* console.log('array de objetos: ', data)
  console.log('datos: ', datos) */


  const handleBorrar = (item) => { // se le pasa el item del conjunto de items que se pidió a la api
    const nuevosDatos = datos.filter((dato) => dato.id !== item.id); // quitamos el item recibido, de los datos que nos dió la api
    setDatos([...nuevosDatos]);
    ajaxReact({
      uri: `/links/delete/${item.link_src}`,
      fetchData: {
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${token}`
        }
      },
      setError,
      setRespServidor: setDatos
    })
    console.log("Fila eliminada correctamente");
  };

  const handleAgregar = () => {
    setEditarItem({
      id: '',
      link_src: '',
      link_target: '',
      owner: '',
      qr_img: ''
    });
    setIsAdding(true);
    setPopupVisible(true);
  };

  const handleAceptarCambiosFila = () => {
    if (isAdding) {
      // Lógica para agregar un nuevo elemento
      ajaxReact({
        uri: '/links/create',
        fetchData: {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(editarItem)
        },
        setError,
        setRespServidor: (nuevoItem) => {
          setDatos([...datos, nuevoItem]);
        }
      });
      setPopupVisible(false);
    } else {// buscamos en el state el objeto a actualizar
      const nuevosDatos = datos.map((dato) => {
        if (dato.id === editarItem.id) { 
          console.log("editarItem: ",editarItem)
          // aca guardamos los cambios en la api

          let http = {
            uri: `/links/modify/${editarItem.link_src}`,
            fetchData: {
              method: 'PUT',
              headers: {
                'Authorization': `Bearer ${token}`
              },
              body: JSON.stringify({
                link_src: editarItem.link_src,
                link_target: editarItem.link_target,
                owner: editarItem.owner,
                qr_img: editarItem.qr_img
              })
            },
            setError,
            setRespServidor: setDatos
          }
          console.log("solicitud enviada: ",http)
          ajaxReact(http)
          return { ...dato, ...editarItem }; // Actualizamos el objeto con los cambios realizados
        }
        return dato;
      });
    }
    setDatos(nuevosDatos); // Actualizamos el estado datos con los cambios
    setPopupVisible(false);
    setIsAdding(false);
    console.log("Cambios guardados correctamente");
  };

  const handleCancelarCambiosFila = () => {
    setPopupVisible(false);
    console.log("Cambios descartados");
  };

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setEditarItem((prevItem) => ({ ...prevItem, [name]: value })); // aca cambiamos el valor de la propiedad del state correspondiente al input modificado
  };

  return (
    <div style={{ width: '100vw'}}>
      <TableContainer sx={{margin: '0 auto', backgroundColor: '#ffffff', borderRadius: '10px', boxShadow: '0 0 10px rgba(0, 0, 0, 0.2)', overflowX: 'auto', maxWidth: 950}}>
        <Table sx={{ minWidth: 650  }} aria-label="simple table">
          <TableHead>
            <TableRow sx={{ backgroundColor: '#f0f0f0' }}>
              <TableCell sx={{ fontWeight: 'bold', padding: '1em' }}>ID</TableCell>
              <TableCell sx={{ fontWeight: 'bold', padding: '1em' }}>Alias</TableCell>
              <TableCell sx={{ fontWeight: 'bold', padding: '1em' }}>URL Destino</TableCell>
              <TableCell sx={{ fontWeight: 'bold', padding: '1em' }}>Propietario</TableCell>
              <TableCell sx={{ fontWeight: 'bold', padding: '1em' }}>Imagen QR</TableCell>
              <TableCell sx={{ fontWeight: 'bold', padding: '1em' }}>Acciones</TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {datos.map((item) => {
              
              return(
                <TableRow key={item.id} sx={{ '&:hover': { backgroundColor: '#f5f5f5' } }}>
                  <TableCell sx={{ padding: '1em' }}>{item.id}</TableCell>
                  <TableCell sx={{ padding: '1em' }}>{item.link_src}</TableCell>
                  <TableCell sx={{ padding: '1em' }}>
                    <a href={
                      "http://"+item.link_target
                    }>{
                      item.link_target
                    }</a>
                  </TableCell>
                  <TableCell sx={{ padding: '1em' }}>{item.owner}</TableCell>
                  <TableCell sx={{ padding: '1em' }}>{item.qr_img}</TableCell>
                  <TableCell sx={{ padding: '1em' }}>
                    
                    <Button 
                    onClick={() => handleEditar(item)}>Editar</Button>
                    <Button 
                    onClick={() => handleBorrar(item)} sx={{ marginRight: '1em' }}>Borrar</Button>
                  </TableCell>
                </TableRow>
              )
            }
            )}
          </TableBody>
        </Table>
      </TableContainer>

      <Button 
        variant="contained"
        onClick={handleAgregar} 
        sx={{ margin: '1em auto', display: 'block' }}
      >
        Agregar Nuevo Elemento
      </Button>

      <Dialog open={popupVisible} onClose={handleCancelarCambiosFila}>
       <DialogTitle>Editar fila</DialogTitle>
       <DialogContent>
       <TextField
         label="ID"
         name="id"
         value={editarItem?.id || ''}
         onChange={handleInputChange}
       />
         <br />
         <TextField
           label="Alias"
           name="link_src"
           value={editarItem?.link_src || ''}
           onChange={handleInputChange}
         />
         <br />
         <TextField
           label="URL Destino"
           name="link_target"
           value={editarItem?.link_target || ''}
           onChange={handleInputChange}
         />
         <br />
         <TextField
           label="Propietario"
           name="owner"
           value={editarItem?.owner || ''}
           onChange={handleInputChange}
         />
         <br />
         <TextField
           label="Imagen QR"
           name="qr_img"
           value={editarItem?.qr_img || ''}
           onChange={handleInputChange}
         />
       </DialogContent>
       <DialogActions>
         <button variant="contained"
         onClick={handleAceptarCambiosFila}>Aceptar</button>
         <button variant="contained"
         onClick={handleCancelarCambiosFila}>Cancelar</button>
       </DialogActions>
     </Dialog>
    </div>
  );
}

export default TablaCrud;