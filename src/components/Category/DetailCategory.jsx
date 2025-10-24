import { useState, useEffect } from 'react';
import { useParams, Link as RouterLink } from 'react-router-dom';

import Container from '@mui/material/Container';
import Typography from '@mui/material/Typography';
import Grid from '@mui/material/Grid';
import Box from '@mui/material/Box';
import List from '@mui/material/List';
import ListItemButton from '@mui/material/ListItemButton';
import ListItemIcon from '@mui/material/ListItemIcon';
import ListItemText from '@mui/material/ListItemText';
import ArrowRightIcon from '@mui/icons-material/ArrowRight';

import CategoryService from '../../services/CategoryService';

export default function DetailCategory() {
  const { id } = useParams(); // id_categoria
  const [data, setData] = useState(null);
  const [loaded, setLoaded] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    CategoryService.getById(id)
      .then((res) => {
        setData(res.data);
        setLoaded(true);
      })
      .catch((err) => {
        setError(err?.message || 'Error al cargar categoría');
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
            {data.nombre_categoria || `Categoría #${data.id_categoria}`}
          </Typography>
          <Typography variant="subtitle1" gutterBottom>
            {data.descripcion}
          </Typography>
          <Typography variant="subtitle1" gutterBottom>
            Estado: {data.estado || '—'}
          </Typography>

          {(data.sla || data.descripcion_sla) && (
            <Box sx={{ mt: 2 }}>
              <Typography variant="subtitle2">SLA</Typography>
              <Typography variant="body2">
                {data.sla?.descripcion || data.descripcion_sla || '—'}
              </Typography>
              <Typography variant="body2">
                Horas respuesta: {data.sla?.horas_respuesta || data.horas_respuesta || '—'}
              </Typography>
              <Typography variant="body2">
                Horas resolución: {data.sla?.horas_resolucion || data.horas_resolucion || '—'}
              </Typography>
            </Box>
          )}
        </Grid>

        {/* Etiquetas asociadas a la categoría */}
        {Array.isArray(data.etiquetas) && data.etiquetas.length > 0 && (
          <Grid item xs={12} md={6}>
            <Typography variant="h6" gutterBottom>Etiquetas</Typography>
            <List dense sx={{ width: '100%', bgcolor: 'background.paper' }}>
              {data.etiquetas.map((e) => (
                <ListItemButton key={e.id_etiqueta}>
                  <ListItemIcon><ArrowRightIcon /></ListItemIcon>
                  <ListItemText primary={e.nombre_etiqueta} />
                </ListItemButton>
              ))}
            </List>
          </Grid>
        )}

        {/* Tickets de la categoría */}
        {Array.isArray(data.tickets) && data.tickets.length > 0 && (
          <Grid item xs={12} md={6}>
            <Typography variant="h6" gutterBottom>Tickets en esta categoría</Typography>
            <List dense sx={{ width: '100%', bgcolor: 'background.paper' }}>
              {data.tickets.map((t) => (
                <ListItemButton
                  key={t.id_ticket}
                  component={RouterLink}
                  to={`/tickets/${t.id_ticket}`}
                >
                  <ListItemIcon><ArrowRightIcon /></ListItemIcon>
                  <ListItemText
                    primary={t.titulo || `Ticket #${t.id_ticket}`}
                    secondary={`Estado: ${t.estado || '—'}`}
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

