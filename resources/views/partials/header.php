<!DOCTYPE html>
<html>

<head>
  <title>Liste des fichiers téléversés</title>
</head>
<style>
body {
  font-family: Verdana, Geneva, Tahoma, sans-serif;
}

* {
  box-sizing: border-box;
}

.container {
  max-width: 95%;
  margin: 2rem auto;
}

input[type="file"] {
  display: none;
}

table,
td,
th {
  border-collapse: collapse;
  width: 100%;
  border: black solid 1px;
}

th,
td {
  padding: 10px;
}

th {
  text-align: start;
}

form {
  max-width: 1024px;
  margin: auto;
}

a {
  text-decoration: none;
}

.btn {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  border-radius: 5px;
  box-shadow: 0 0 10px #888888;
  cursor: pointer;
  font-weight: 700;
  margin-top: 1rem;
  font-size: 1.05rem;
}

.btn:hover {
  background-color: #fff;
  color: #4CAF50;
  outline: solid 2px #4CAF50;
}

.btn:active {
  box-shadow: none;
}

.input-group {
  margin-block: 2rem;
  width: 100;
}

.input-group label {
  display: inline-block;
  width: 30%;
}

.input-group input {
  width: 65%;
}

.input-group label,
.input-group input {
  min-height: 2.5rem;
  border-radius: 5px;
}
</style>

<body>
  <div class="container">