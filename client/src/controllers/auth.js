// auth.js
export const checkAuth = async (casoTrue, casoFalse) => {
  // verifico que token hay en el localstorage
  const token = localStorage.getItem('token');
  console.log(token)
  if (!token) {
    return casoFalse();
  }

  // verifico que token sea válido
  const url_api = `http://${process.env.BACKEND_API_URL}/login`;
  let pass = false;

  try {
    const response = await fetch(url_api, {
      method: 'POST',
      headers: { 
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
      },
    });
    const data = await response.json();

    // si el servidor responde que és valido, se define que el usuario está autenticado
    if (response.ok) {
      casoTrue();
    } else {
      casoFalse();
    }

  } catch (error) {
    // Maneja el error de una manera que no cause un ciclo de renderizado
    console.log(error);
    casoFalse();
  }

  return pass;
};