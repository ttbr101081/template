<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Aplicación CRUD PHP</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
      *{
  margin: 0;
  padding: 0;
}
header{
  font-family: Helvetica;
  width: 480px;
  margin: 0 auto;
}
ul{
  list-style: none;
}
#menu li>a{
  background-color: grey;
  color: white;
  padding: 10px;
  display: block;
  text-decoration: none;
  min-width: 100px;
}
#menu li>a:hover{
  color: #000;
  background-color: #eaeaea;
}
#menu>li{
  float: left;
  text-align:center
}
#menu>li>ul{
  display: none;
}
#menu>li:hover>ul {
  display:block;
}
    </style>
  </head>
  <body>
    <div class="container">
    <div class="row">
    	<nav>
        <ul id="menu">
          <li><a href="">Inicio</a></li>
          <li><a href="">Cursos</a>
            <ul>
              <li><a href="">Frontend</a></li>
              <li><a href="">Backend</a></li>
              <li><a href="">Mobile</a></li>
            </ul>  
          </li>
          <li><a href="">Tutoriales</a></li>
          <li><a href="">Contacto</a></li>
        </ul>
      </nav>
      </div>
    </div>