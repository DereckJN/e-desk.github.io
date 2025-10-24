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
import EmailIcon from '@mui/icons-material/Email';
import PersonIcon from '@mui/icons-material/Person';

import TechnicianService from '../../services/TechnicianService';

export default function ListTechnicians() {
  const [data, setData] = useState(null);
  const [error, setError] = useState('');
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    TechnicianService.getAll()
      .then((res) => {
        setData(res.data); // Espera [{ id_usuario, correo, estado, rol:{descripcion}, fecha_creacion, ... }]
        setLoaded(true);
      })
      .catch((err) => {
        setError(err?.message || 'Error al cargar técnicos');
        setLoaded(true);
      });
  }, []);

  if (!loaded) return <p>Cargando...</p>;
  if (error) return <p>Error: {error}</p>;
  if (!data || data.length === 0) return <p>Sin técnicos</p>;

  const colorByEstado = (e) => {
    const v = (e || '').toLowerCase();
    if (v.includes('activo')) return 'success';
    if (v.includes('inactivo')) return 'default';
    return 'info';
  };

  return (
    <Grid container sx={{ p: 2 }} spacing={3}>
      {data.map((item) => (
        <Grid size={4} key={item.id_usuario}>
          <Card>
            <CardHeader
              sx={{
                p: 1.5,
                backgroundColor: (t) => t.palette.secondary.main,
                color: (t) => t.palette.common.white,
                textAlign: 'center',
              }}
              title={item.nombre || item.correo || `Técnico #${item.id_usuario}`}
              subheader={item.fecha_creacion || ''}
            />
            <CardContent>
              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                <EmailIcon fontSize="small" /> {item.correo}
              </Typography>
              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1, mt: 1 }}>
                <PersonIcon fontSize="small" /> Rol: {item.rol?.descripcion || 'Técnico'}
              </Typography>
              <Chip size="small" label={item.estado || '—'} color={colorByEstado(item.estado)} sx={{ mt: 1 }} />
            </CardContent>
            <CardActions
              disableSpacing
              sx={{
                backgroundColor: (t) => t.palette.action.focus,
                color: (t) => t.palette.common.white,
              }}
            >
              <Tooltip title="Detalle del técnico">
                <IconButton
                  component={Link}
                  to={`/technicians/${item.id_usuario}`}
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
