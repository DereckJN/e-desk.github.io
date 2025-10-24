import { createTheme } from '@mui/material/styles'; 
export const appTheme= createTheme  ({ 
  palette: { 
    mode: 'light', 
    primary: { 
      main: '#68BEC4', 
    }, 
    secondary: { 
      main: '#F5F7FA', 
    }, 
    primaryLight: { 
        main: "#69B066", 
        contrastText: "#151C15"  
      } 
  }, 
});