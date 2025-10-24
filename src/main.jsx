import React from 'react'; 
import { StrictMode } from 'react'; 
import { createRoot } from 'react-dom/client'; 
import './index.css'; 
import { RouterProvider, createBrowserRouter } from 'react-router-dom'; 
import App from './App'; 
 
const router = createBrowserRouter( 
  [ 
    { 
      element: <App />, 
      children: [ 
        { 
          path: '/', 
          element: <NombreComponente />, 
        } 
      ], 
    }, 
  ], 
); 
createRoot(document.getElementById('root')).render( 
  <StrictMode> 
      <RouterProvider router={rutas} /> 
  </StrictMode>, 
); 