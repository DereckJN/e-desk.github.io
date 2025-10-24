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
import LabelIcon from '@mui/icons-material/Label';
import RuleIcon from '@mui/icons-material/Rule';

import CategoryService from '../../services/CategoryService';

export default function ListCategories() {
  const [data, setData] = useState(null);
  const [error, setError] = useState('');
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    CategoryService.getAll()
      .then((res) => {
        setData(res.data); // Espera [{ id_categoria, nombre_categoria, descripcion, estado, id_sla, sla? }]
        setLoaded(true);
      })
      .catch((err) => {
        setError(err?.message || 'Error al cargar categorías');
        setLoaded(true);
      });
  }, []);

  if (!loaded) return <p>Cargando...</p>;
  if (error) return <p>Error: {error}</p>;
  if (!data || data.length === 0) return <p>Sin categorías</p>;

  const colorByEstado = (e) => {
    const v = (e || '').toLowerCase();
    if (v.includes('activo')) return 'success';
    if (v.includes('inactivo')) return 'default';
    return 'info';
  };

  return (
    <Grid container sx={{ p: 2 }} spacing={3}>
      {data.map((item) => (
        <Grid size={4} key={item.id_categoria}>
          <Card>
            <CardHeader
              sx={{
                p: 1.5,
                backgroundColor: (t) => t.palette.secondary.main,
                color: (t) => t.palette.common.white,
                textAlign: 'center',
              }}
              title={item.nombre_categoria}
              subheader={item.sla?.descripcion || `SLA: ${item.id_sla || '—'}`}
            />
            <CardContent>
              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                <LabelIcon fontSize="small" /> {item.descripcion || 'Sin descripción'}
              </Typography>
              <Typography variant="body2" color="text.secondary" sx={{ display: 'flex', alignItems: 'center', gap: 1, mt: 1 }}>
                <RuleIcon fontSize="small" /> SLA: {item.sla?.descripcion || item.id_sla || '—'}
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
              <Tooltip title="Detalle de la categoría">
                <IconButton
                  component={Link}
                  to={`/categories/${item.id_categoria}`}
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
