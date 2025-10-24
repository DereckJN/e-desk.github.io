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
import ArrowRightIcon from '@mui/icons-material/ArrowRight';

import TicketService from '../../services/TicketService';

export default function DetailTicket() {
  const { id } = useParams();
  const [data, setData] = useState(null);
  const [loaded, setLoaded] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    TicketService.getById(id)
      .then((res) => {
        setData(res.data);
        setLoaded(true);
      })
      .catch((err) => {
        setError(err?.message || 'Error al cargar ticket');
        setLoaded(true);
      });
  }, [id]);

  if (!loaded) return <p>Cargando...</p>;
  if (error) return <p>Error: {error}</p>;
  if (!data) return <p>Sin datos</p>;

  return (
    <Container component="main" sx={{ mt: 8, mb: 2 }}>
      <Grid container spacing={2}>
        <Grid item xs={12} md={8}>
          <Typography variant="h4" gutterBottom>
            {data.titulo || `Ticket #${data.id_ticket}`}
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Prioridad: <Box component="span" fontWeight="bold">{data.prioridad || '—'}</Box>
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Estado: <Box component="span" fontWeight="bold">{data.estado || '—'}</Box>
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Categoría: {data.categoria?.nombre_categoria || data.nombre_categoria || '—'}
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Cliente: {data.cliente?.correo || data.usuario_cliente?.correo || '—'}
          </Typography>

          <Typography variant="subtitle1" gutterBottom>
            Técnico asignado: {data.tecnico?.correo || data.asignacion?.tecnico_correo || 'Sin asignar'}
          </Typography>

          <Typography variant="body1" sx={{ mt: 2 }}>
            {data.descripcion}
          </Typography>

          <Box sx={{ mt: 3 }}>
            <Typography variant="subtitle2">Fechas</Typography>
            <Typography variant="body2">Creación: {data.fecha_creacion || '—'}</Typography>
            <Typography variant="body2">1ra respuesta: {data.fecha_primera_respuesta || '—'}</Typography>
            <Typography variant="body2">Resolución: {data.fecha_resolucion || '—'}</Typography>
            <Typography variant="body2">Cierre: {data.fecha_cierre || '—'}</Typography>
          </Box>

          {/* SLA opcional si viene por join o por la categoría */}
          {(data.sla || data.categoria?.sla) && (
            <Box sx={{ mt: 2 }}>
              <Typography variant="subtitle2">SLA</Typography>
              <Typography variant="body2">
                {data.sla?.descripcion || data.categoria?.sla?.descripcion || '—'}
              </Typography>
              <Typography variant="body2">
                Límite respuesta: {data.fecha_limite_respuesta || '—'}
              </Typography>
              <Typography variant="body2">
                Límite resolución: {data.fecha_limite_resolucion || '—'}
              </Typography>
            </Box>
          )}
        </Grid>

        {/* Historial (tabla historial_tickets) si el backend lo envía como array */}
        {Array.isArray(data.historial) && data.historial.length > 0 && (
          <Grid item xs={12} md={4}>
            <Typography variant="h6" gutterBottom>Historial</Typography>
            <List dense sx={{ width: '100%', bgcolor: 'background.paper' }}>
              {data.historial.map((h) => (
                <ListItemButton key={h.id_historial}>
                  <ListItemIcon><ArrowRightIcon /></ListItemIcon>
                  <ListItemText
                    primary={`${h.estado_anterior} → ${h.estado_nuevo}`}
                    secondary={h.fecha_cambio}
                  />
                </ListItemButton>
              ))}
            </List>
          </Grid>
        )}

        {/* Etiquetas (via categoria_etiqueta o por ticket si lo decides) */}
        {Array.isArray(data.etiquetas) && data.etiquetas.length > 0 && (
          <Grid item xs={12}>
            <Typography variant="h6" gutterBottom>Etiquetas</Typography>
            <List dense sx={{ width: '100%', maxWidth: 600, bgcolor: 'background.paper' }}>
              {data.etiquetas.map((e) => (
                <ListItemButton key={e.id_etiqueta}>
                  <ListItemIcon><ArrowRightIcon /></ListItemIcon>
                  <ListItemText primary={e.nombre_etiqueta} />
                </ListItemButton>
              ))}
            </List>
          </Grid>
        )}
      </Grid>
    </Container>
  );
}
