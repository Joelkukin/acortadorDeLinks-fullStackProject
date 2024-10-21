export async function isAuth(){

  let token = localStorage.getItem("token")
  const url_api = `http://${process.env.BACKEND_API_URL}/login`;
  
    try {
      const response = await fetch(url_api, {
        method: 'POST',
        headers: { 
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
      });
      const data = await response.json();
      return data
      /* if (data.pass) {
        pass = true;
      } else {
        window.location.href = '/login';
      } */
    } catch (error) {
      console.log(error);
      // Maneja el error de una manera que no cause un ciclo de renderizado
    }
  
}

async function testIsAuth(){
  console.log(await isAuth())
}
testIsAuth()
