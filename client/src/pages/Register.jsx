// Register.js
import React, { useState } from 'react';
import dotenv from 'dotenv';
import { Box, Card, CardContent, CardHeader, Typography, TextField, Button, Select, MenuItem, InputLabel } from '@mui/material';

const Register = () => {
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [nombre, setNombre] = useState('');
  const [partner, setPartner] = useState('');
  const [tipo, setTipo] = useState(''); // Agregué este estado para el tipo
  const [error, setError] = useState(null);

  const handleSubmit = async (event) => {
    event.preventDefault();

    if (password !== confirmPassword) {
      setError('Las contraseñas no coinciden');
      return;
    }

    const url_api = `http://${process.env.BACKEND_API_URL}/register`;
    console.log(url_api);
    try {
      const body = {
        username,
        password,
        nombre,
        partner,
        mail: email,
        tipo,
      };
      const response = await fetch(url_api, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body),
      });
      const data = await response.json();
      console.log(data);
      if (data.status) {
        // Envio al usuario a la página de login
        window.location.href = '/login';
      } else {
        setError('Error al registrar usuario: '+data.message);
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
          title="Registro"
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
                marginTop: 2 + 1,
                marginBottom: 1 + 1,
                fontSize: 16,
              }}
            />
            <br />
            <br />
            <TextField
              label="Email"
              value={email}
              onChange={(event) => setEmail(event.target.value)}
              sx={{
                width: '100%',
                backgroundColor: 'white',
                height: 20,
                padding: 0,
                marginTop: 1 + 1,
                marginBottom: 2 + 1,
                fontSize: 16,
              }}
            />
            <br />
            <br />
            <TextField
              label="Password"
              type="password"
              value={password}
              onChange={(event) => setPassword(event.target.value)}
              sx={{
                width: '100%',
                backgroundColor: 'white',
                height: 20,
                padding: 0,
                marginTop: 1 + 1,
                marginBottom: 2 + 1,
                fontSize: 16,
              }}
            />
            <br />
            <br />
            <TextField
              label="Confirm Password"
              type="password"
              value={confirmPassword}
              onChange={(event) => setConfirmPassword(event.target.value)}
              sx={{
                width: '100%',
                backgroundColor: 'white',
                height: 20,
                padding: 0,
                marginTop: 1 + 1,
                marginBottom: 2 + 1,
                fontSize: 16,
              }}
            />
            <br />
            <br />
            <TextField
              label="Nombre"
              value={nombre}
              onChange={(event) => setNombre(event.target.value)}
              sx={{
                width: '100%',
                backgroundColor: 'white',
                height: 20,
                padding: 0,
                marginTop: 1 + 1,
                marginBottom: 2 + 1,
                fontSize: 16,
              }}
            />
            <br />
            <br />
            <InputLabel id="label-tipo-usuario">Tipo</InputLabel>
            <Select
              labelId="label-tipo-usuario"
              id='tipo-usuario'
              label="tipo"
              value={tipo}
              onChange={(event) => setTipo(event.target.value)}
              
              sx={{
                width: '100%',
                
                padding: 0,
                marginTop: 1 + 1,
                marginBottom: 2 + 1,
                fontSize: 16,
              }}
            >
              <MenuItem value="usuario">Usuario</MenuItem>
              <MenuItem value="partner">Partner</MenuItem>
            </Select>
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
              Registrar
            </Button>
          </form>
        </CardContent>
      </Card>
    </Box>
  );
};

export default Register;