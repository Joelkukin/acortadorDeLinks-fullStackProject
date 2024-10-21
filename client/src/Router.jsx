import React, { useState, useEffect } from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import { checkAuth } from "./controllers/auth";
import LinksManager from './pages/LinksManager';
import Loading from './pages/Loading';
import Login from './pages/Login';
import Register from './pages/Register';
import Redirect from './pages/Redirect';
import { useParams } from 'react-router-dom';

import { Button } from '@mui/material';

const Router = () => {
  const [isAuth, setIsAuth] = useState(false);
  const [loading, setLoading] = useState(true);
  

  useEffect(() => {
    (async () => {
      try {
        await checkAuth(()=>setIsAuth(true), ()=>setIsAuth(false));
        setLoading(false);
        console.log("checkAuth ejecutado")
      } catch (error) {
        setError(error);
        setLoading(false);
      }
    })()
  }, []);

  if (loading) {
    return <Loading />;
  }

  if (isAuth) {
    console.log("isAuth")
    return (
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<LinksManager />} />
          <Route path="/linksManager" element={<LinksManager />} />
          <Route path="/login" element={<Navigate to="/" replace />} />
          <Route path="/register" element={<Navigate to="/" replace />} />
          <Route path="a/:id_user/:link_src" element={<Redirect/>} />
        </Routes>
      </BrowserRouter>
    );
  } else {
    console.log("no isAuth")
    return (
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Navigate to="/login" replace />} />
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
        <Route path="/:id_user/:link_src" element={<Redirect/>} />
        </Routes>
      </BrowserRouter>
    );
  }
};

export default Router;