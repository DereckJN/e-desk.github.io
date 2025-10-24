import { CssBaseline, ThemeProvider } from '@mui/material'; 

export default function App() { 
    return ( 
        <ThemeProvider theme={appTheme}> 
          <CssBaseline enableColorScheme /> 
          <Layout> 
            <Outlet /> 
          </Layout> 
        </ThemeProvider> 
    ); 
  } import { Outlet } from 'react-router-dom';
import Layout from './components/Layout';
import { appTheme } from './theme';