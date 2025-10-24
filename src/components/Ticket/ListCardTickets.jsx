// src/components/Ticket/ListCardTickets.jsx
import React from 'react';
import PropTypes from 'prop-types';

import Card from '@mui/material/Card';
import CardHeader from '@mui/material/CardHeader';
import CardContent from '@mui/material/CardContent';
import CardActions from '@mui/material/CardActions';
import Grid from '@mui/material/Grid2';
import Typography from '@mui/material/Typography';
import IconButton from '@mui/material/IconButton';
import Chip from '@mui/material/Chip';
import Tooltip from '@mui/material/Tooltip';

import InfoIcon from '@mui/icons-material/Info';
import PriorityHighIcon from '@mui/icons-material/PriorityHigh';
import AssignmentTurnedInIcon from '@mui/icons-material/AssignmentTurnedIn';
import LabelImportantIcon from '@mui/icons-material/LabelImportant';
import PersonAddIcon from '@mui/icons-material/PersonAdd';

import { Link } from 'react-router-dom';

ListCardTickets.propTypes = {
  data: PropTypes.array,             // [{ id_ticket, titulo, prioridad, estado, fecha_creacion, categoria? }]
  showAssign: PropTypes.bool,        // si true, muestra botón "Asignarme"
  onAssign: PropTypes.func,          // callback(id_ticket)
};

export default function ListCardTickets({ data = [], showAssign = false, onAssign }) {
  // Colores para chips
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

  if (!data || data.length === 0) {
    return <Typography sx={{ p: 2 }}>Sin tickets</Typography>;
  }

  return (
    <Grid container sx={{ p: 2 }} spacing={3}>
      {data.map((item) => (
        <Grid size={4} key={item.id_ticket}>
          <Card>
            <CardHeader
              sx={{
                p: 1.2,
                backgroundColor: (t) => t.palette.secondary.main,
                color: (t) => t.palette.common.white,
              }}
              style={{ textAlign: 'center' }}
              title={item.titulo || `Ticket #${item.id_ticket}`}
              subheader={item.fecha_creacion || ''}
            />

            <CardContent>
              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                <PriorityHighIcon fontSize="small" />
                Prioridad:
                <Chip size="small" label={item.prioridad || '—'} color={colorByPrioridad(item.prioridad)} />
              </Typography>

              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1, mt: 1 }}>
                <AssignmentTurnedInIcon fontSize="small" />
                Estado:
                <Chip size="small" label={item.estado || '—'} color={colorByEstado(item.estado)} />
              </Typography>

              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1, mt: 1 }}>
                <LabelImportantIcon fontSize="small" />
                Categoría:
                <b>{item?.categoria?.nombre_categoria || item.nombre_categoria || '—'}</b>
              </Typography>

              {/* Si en algún momento manejas importe/costo del ticket, descomenta:
              <Typography variant="h6" align="right" gutterBottom sx={{ mt: 1 }}>
                ₡{item.importe}
              </Typography>
              */}
            </CardContent>

            <CardActions
              disableSpacing
              sx={{
                backgroundColor: (theme) => theme.palette.action.focus,
                color: (theme) => theme.palette.common.white,
              }}
            >
              {showAssign && (
                <Tooltip title="Asignarme este ticket">
                  <span>
                    <IconButton
                      aria-label="Asignarme"
                      onClick={() => onAssign && onAssign(item.id_ticket)}
                      disabled={!onAssign}
                    >
                      <PersonAddIcon />
                    </IconButton>
                  </span>
                </Tooltip>
              )}

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
