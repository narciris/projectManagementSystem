# projectManagementSystem

## 🧩 Caso de uso: Sistema de Gestión de Proyectos para Freelancers
🎯 Objetivo
Desarrollar una aplicación web donde freelancers puedan:

Registrarse e iniciar sesión.

Crear y administrar proyectos.

Subir archivos relacionados a cada proyecto.

Consultar, editar y eliminar sus proyectos.

## 📚 Tecnologías
Backend: PHP (usando patrón MVC,PDO)

Frontend: Angular 15+

Base de datos: MySQL

Autenticación: JWT

## 🧠 Requisitos funcionales
👤 Autenticación (Login/Register)
Registro: nombre, email, contraseña.

Login: email y contraseña.

JWT: Token devuelto y usado en llamadas posteriores.

## 📁 Proyectos (CRUD)
Campos: id, titulo, descripcion, fecha_inicio, fecha_entrega, estado, user_id.

Operaciones:

Crear proyecto (POST)

Ver lista de proyectos del usuario (GET)

Ver detalle de un proyecto (GET /id)

Editar proyecto (PUT)

Eliminar proyecto (DELETE)

📎 Archivos (Manejo de archivos)
Subir uno o varios archivos por proyecto.

Ver lista de archivos adjuntos a un proyecto.

Descargar o eliminar archivo.

Validación por tipo de archivo (PDF, imágenes, docs).