import React, { useState, useEffect } from 'react';
import { Box, Card, CardContent, CardHeader, Typography, TextField, Button } from '@mui/material';
import { checkAuth } from '../controllers/auth';

const Login = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState(null);
    
  const handleSubmit = async (event) => {
    event.preventDefault();
    console.log('handle submit ejecutado')
    const url_api = `http://${process.env.BACKEND_API_URL}/login`;
    try {
      const response = await fetch(url_api, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password }),
      });
      const data = await response.json();
      if (data.token) {
        localStorage.setItem('token', data.token);
        // <Navigate to="/" replace />
        window.location.href = "/"
        
      } else {
        setError('Credenciales incorrectas');
      }
    } catch (error) {
      console.log(error);
      setError(error.message);
    }
  };

  return (
    <Box
      sx={{
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        width: '100vw',
      }}
    >
      <Card
        sx={{
          backgroundColor: '#ffffff',
          boxShadow: '0px 0px 10px rgba(0, 0, 0, 0.1)',
          borderRadius: 10,
          padding: 4,
          margin: 3,
        }}
      >
        <CardHeader
          title="Login"
          sx={{
            backgroundColor: '#ffffff',
            borderBottom: '1px solid #dddddd',
          }}
        />
        <CardContent>
          <form onSubmit={handleSubmit}>
            <TextField
              label="Username"
              value={username}
              onChange={(event) => setUsername(event.target.value)}
              sx={{
                width: '100%',
                height: 20,
                backgroundColor: 'white',
                padding: 0,
                marginTop: 3,
                marginBottom: 2,
                fontSize: 16,
              }}
            />
            <br />
            <br />
            <TextField
              label="Password"
              type="password"
              value={password}
              onChange={(event) => setPassword (event.target.value)}
              sx={{
                width: '100%',
                backgroundColor: 'white',
                height: 20,
                padding: 0,
                marginTop: 2,
                marginBottom: 3,
                fontSize: 16,
              }}
            />
            <br />
            <br />
            
            {error && (
              <Typography
                sx={{
                  color: 'red',
                  fontSize: 14,
                  marginBottom: 10,
                }}
              >
                {error}
              </Typography>
            )}
            <Button
              type="submit"
              sx={{
                width: '100%',
                height: 10,
                padding: 5,
                fontSize: 16,
                borderRadius: 5,
                backgroundColor: '#0078d7',
                color: '#ffffff',
                cursor: 'pointer',
              }}
            >
              Login
            </Button>
          </form>
          <p>
            ¿no tienes una cuenta? <a href="/register">Registrate aqui</a>
          </p>
        </CardContent>
      </Card>
    </Box>
  );
};

export default Login;