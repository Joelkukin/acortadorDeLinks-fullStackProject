import { useParams } from 'react-router-dom';
import { useEffect } from 'react';
import ajaxReact from '../controllers/ajax';
import Loading from '../pages/Loading';

function Redirect() {
  const { id_user, link_src } = useParams();

  useEffect(() => {
    ajaxReact({
      method: 'GET',
      uri: `/${id_user}/${link_src}`,
      setRespServidor: (link) => {
        if (link && link[0] && link[0].link_target) {
          // Redirige a la URL almacenada en link_target
          window.location.href = link[0].link_target;
        } else {
          // Si no hay un link válido, redirige a una página de error
          window.location.href = '/error';
        }
      },
      setError: (error) => {
        console.error(error);
        window.location.href = '/error';
      }
    });
  }, [id_user, link_src]);

  return <Loading texto="Redirigiendo..."/>;
}

export default Redirect;