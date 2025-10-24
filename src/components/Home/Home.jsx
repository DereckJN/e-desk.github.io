import React from 'react'; 
import Container from '@mui/material/Container'; 
import Typography from '@mui/material/Typography'; 
export function Home() { 
  return ( 
    <Container sx={{ p: 2 }} maxWidth="sm"> 
      <Typography 
        component="h1" 
        variant="h2" 
        align="center" 
        color="text.primary" 
        gutterBottom 
      > 
        Sistema de creacion de tickets
           </Typography> 
      <Typography variant="h5" align="center" color="text.secondary"> 
        Crea tickets para recibir soporte en diferentes areas de la empresa. 
      </Typography> 
    </Container> 
  ); 
} 