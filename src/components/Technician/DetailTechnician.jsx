import { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';

import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';
import Box from '@mui/material/Box';
import List from '@mui/material/List';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import Grid from '@mui/material/Grid';
import StarIcon from '@mui/icons-material/Star';
import ArrowRightIcon from '@mui/icons-material/ArrowRight';

import TechnicianService from '../../services/TechnicinService';

export default function DetailTechnician() {
  const { id } = useParams(); // id_usuario del técnico
  const [data, setData] = useState(null);
  const [loaded, setLoaded] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    TechnicianService.getById(id)
      .then((res) => {
        setData(res.data);
        setLoaded(true);
      })
      .catch((err) => {
        setError(err?.message || 'Error al cargar técnico');
        setLoaded(true);
      });
  }, [id]);

  if (!loaded) return <p>Cargando...</p>;
  if (error) return <p>Error: {error}</p>;
  if (!data) return <p>Sin datos</p>;

  return (
    <Container component="main" sx={{ mt: 8, mb: 2 }}>
      <Grid container spacing={2}>
        <Grid item xs={12}>
          <Typography variant="h4" gutterBottom>
            {data.nombre || data.correo || `Técnico #${data.id_usuario}`}
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Correo: {data.correo}
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Rol: {data.rol?.descripcion || '—'}
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Estado: {data.estado || '—'}
          </Typography>

          <Box sx={{ mt: 2 }}>
            <Typography variant="subtitle2">Fechas</Typography>
            <Typography variant="body2">Creación: {data.fecha_creacion || '—'}</Typography>
            <Typography variant="body2">Actualización: {data.fecha_actualizacion || '—'}</Typography>
            <Typography variant="body2">Último inicio: {data.ultimo_inicio || '—'}</Typography>
          </Box>
        </Grid>

        {/* Especialidades del técnico (join tecnico_especialidad -> especialidad) */}
        {Array.isArray(data.especialidades) && data.especialidades.length > 0 && (
          <Grid item xs={12} md={6}>
            <Typography variant="h6" gutterBottom>Especialidades</Typography>
            <List dense sx={{ width: '100%', bgcolor: 'background.paper' }}>
              {data.especialidades.map((esp) => (
                <ListItemButton key={esp.id_especialidad}>
                  <ListItemIcon><StarIcon /></ListItemIcon>
                  <ListItemText primary={esp.nombre_especialidad} />
                </ListItemButton>
              ))}
            </List>
          </Grid>
        )}

        {/* Asignaciones recientes (tabla asignacion) */}
        {Array.isArray(data.asignaciones) && data.asignaciones.length > 0 && (
          <Grid item xs={12} md={6}>
            <Typography variant="h6" gutterBottom>Asignaciones recientes</Typography>
            <List dense sx={{ width: '100%', bgcolor: 'background.paper' }}>
              {data.asignaciones.map((a) => (
                <ListItemButton key={a.id_asignacion}>
                  <ListItemIcon><ArrowRightIcon /></ListItemIcon>
                  <ListItemText
                    primary={`Ticket #${a.id_ticket}`}
                    secondary={`${a.metodo_asignacion || '—'} · ${a.fecha_asignacion || '—'}`}
                  />
                </ListItemButton>
              ))}
            </List>
          </Grid>
        )}
      </Grid>
    </Container>
  );
}
