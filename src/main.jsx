import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import App from "./App.jsx";
import { createBrowserRouter } from "react-router-dom";
import { Home } from "./components/Home/Home";
import { RouterProvider } from "react-router";
import { PageNotFound } from "./components/Home/PageNotFound";
import ListTickets from "./components/Ticket/ListTickets";
import { DetailTicket  } from "./components/Ticket/DetailTicket ";
import ListTechnician from "./components/Technician/ListTechnician";
import DetailRental from "./components/Technician/DetailTechnician";
import TableTickets from "./components/Tickets/TableTickets";
const rutas=createBrowserRouter(
  [
    {
      element: <App />,
      children:[
        {
          path:'/',
          element: <Home />
        },
        {
          path: '*',
          element: <PageNotFound />
        },
        {
          path:'/ticket/',
          element: <ListTickets />
        },
        {
          path:'/ticket/:id',
          element: <DetailTicket />
        },
        {
          path:'/ticket-table',
          element: <TableTickets/>
        },
        {
          path:'/technician',
          element: <ListTechnician />
        },
        {
          path:'/technician/:id',
          element: <DetailTechnician />
        },
      ]
    }
  ]
)

createRoot(document.getElementById("root")).render(
  <StrictMode> 
  <RouterProvider router={rutas} /> 
</StrictMode>, 
);