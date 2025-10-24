import React, { useEffect, useState } from 'react';
import Card from '@mui/material/Card';
import CardHeader from '@mui/material/CardHeader';
import CardContent from '@mui/material/CardContent';
import CardActions from '@mui/material/CardActions';
import Grid from '@mui/material/Grid2';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import Chip from '@mui/material/Chip';
import Tooltip from '@mui/material/Tooltip';
import { Link } from 'react-router-dom';
import InfoIcon from '@mui/icons-material/Info';
import PriorityHighIcon from '@mui/icons-material/PriorityHigh';
import AssignmentTurnedInIcon from '@mui/icons-material/AssignmentTurnedIn';

import TicketService from '../../services/TicketService';

export default function ListTickets() {
  const [data, setData] = useState(null);
  const [error, setError] = useState('');
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    TicketService.getAll()
      .then((res) => {
        setData(res.data);       // Espera [{ id_ticket, titulo, prioridad, estado, fecha_creacion, ... }]
        setLoaded(true);
      })
      .catch((err) => {
        setError(err?.message || 'Error al cargar tickets');
        setLoaded(true);
      });
  }, []);

  if (!loaded) return <p>Cargando...</p>;
  if (error) return <p>Error: {error}</p>;
  if (!data || data.length === 0) return <p>Sin tickets</p>;

  const colorByPrioridad = (p) => {
    const v = (p || '').toLowerCase();
    if (v.includes('alta')) return 'error';
    if (v.includes('media')) return 'warning';
    if (v.includes('baja')) return 'success';
    return 'default';
    };

  const colorByEstado = (e) => {
    const v = (e || '').toLowerCase();
    if (v.includes('abierto')) return 'info';
    if (v.includes('en_proceso') || v.includes('proceso')) return 'warning';
    if (v.includes('resuelto')) return 'success';
    if (v.includes('cerrado')) return 'default';
    return 'default';
  };

  return (
    <Grid container sx={{ p: 2 }} spacing={3}>
      {data.map((item) => (
        <Grid size={4} key={item.id_ticket}>
          <Card>
            <CardHeader
              sx={{
                p: 1.5,
                backgroundColor: (t) => t.palette.secondary.main,
                color: (t) => t.palette.common.white,
                textAlign: 'center',
              }}
              title={item.titulo || `Ticket #${item.id_ticket}`}
              subheader={item.fecha_creacion || ''}
            />
            <CardContent>
              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                <PriorityHighIcon fontSize="small" /> Prioridad:
                <Chip size="small" label={item.prioridad || '—'} color={colorByPrioridad(item.prioridad)} />
              </Typography>
              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1, mt: 1 }}>
                <AssignmentTurnedInIcon fontSize="small" /> Estado:
                <Chip size="small" label={item.estado || '—'} color={colorByEstado(item.estado)} />
              </Typography>
              {item.categoria?.nombre_categoria && (
                <Typography variant="body2" sx={{ mt: 1 }}>
                  Categoría: <b>{item.categoria.nombre_categoria}</b>
                </Typography>
              )}
            </CardContent>
            <CardActions
              disableSpacing
              sx={{
                backgroundColor: (t) => t.palette.action.focus,
                color: (t) => t.palette.common.white,
              }}
            >
              <Tooltip title="Detalle del ticket">
                <IconButton
                  component={Link}
                  to={`/tickets/${item.id_ticket}`}
                  aria-label="Detalle"
                  sx={{ ml: 'auto' }}
                >
                  <InfoIcon />
                </IconButton>
              </Tooltip>
            </CardActions>
          </Card>
        </Grid>
      ))}
    </Grid>
  );
}
