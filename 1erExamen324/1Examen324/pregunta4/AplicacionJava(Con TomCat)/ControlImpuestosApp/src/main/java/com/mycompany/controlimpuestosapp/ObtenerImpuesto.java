package com.mycompany.controlimpuestosapp;

import java.io.IOException;
import java.io.PrintWriter;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

@WebServlet(name = "ObtenerImpuesto", urlPatterns = {"/ObtenerImpuesto"})
public class ObtenerImpuesto extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/plain;charset=UTF-8"); // Cambiar a text/plain para respuesta simple
        String codigoCatastral = request.getParameter("codigo"); // Obtener el código catastral
        String tipoImpuesto = obtenerTipoImpuesto(codigoCatastral); // Obtener el tipo de impuesto

        try (PrintWriter out = response.getWriter()) {
            out.println(tipoImpuesto); // Devolver el tipo de impuesto
        }
    }

    private String obtenerTipoImpuesto(String codigoCatastral) {
        if (codigoCatastral != null && !codigoCatastral.isEmpty()) {
            char primerDigito = codigoCatastral.charAt(0); // Obtener el primer dígito
            switch (primerDigito) {
                case '1': return "Alto";   // Si empieza con 1
                case '2': return "Medio";  // Si empieza con 2
                case '3': return "Bajo";   // Si empieza con 3
                default: return "Desconocido"; // Si no coincide con 1, 2 o 3
            }
        } else {
            return "Código catastral inválido"; // Mensaje para código nulo o vacío
        }
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    @Override
    public String getServletInfo() {
        return "Servlet para obtener tipo de impuesto basado en código catastral";
    }
}
