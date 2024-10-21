import { CircularProgress, Box, Typography } from '@mui/material';

function Loading({texto}) {
  return (
    
    <Box
      sx={{
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        width: '100vw',
        backgroundColor: 'rgba(255, 255, 255, 0)',
      }}
    >
      <CircularProgress size={60} thickness={3} sx={{ mr: 2 }} />
      <Typography variant="h5" component="p" sx={{ color: 'primary.main' }}>
        {texto || "Cargando..."}
      </Typography>
    </Box>
  );
}

export default Loading;