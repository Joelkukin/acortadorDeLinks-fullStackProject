export default {
  getLinksAsync : {
    uri: `/links`,
    fetchData: {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${token}`
      }
    },
    setError,
    setRespServidor: setLinks
  },

borrarLink  :  {
  uri: `/links/delete/${link_alias}`,
  fetchData: {
    method: 'DELETE',
    headers: {
      'Authorization': `Bearer ${token}`
    }
  },
  setError,
  setRespServidor: setLinks
},
actualizarLink : {
  uri: `/links`,
  fetchData: {
    method: 'PUT',
    headers: {
      'Authorization': `Bearer ${token}`
    }
  },
  setError,
  setRespServidor: setLinks
}

}