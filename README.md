# Sistema de inventario

Evaluación Técnica de Programación del Grupo Castores.

## Dependencias

* [PHP >= 8.1](https://www.php.net)
* [MariaDB/MySQL >= 5.1](https://mariadb.org)
* [Extensiones de PHP requeridas](https://codeigniter.com/user_guide/intro/requirements.html)
* [Composer >= 2.0.14](https://getcomposer.org)

## Instalación

Ingresa a la carpeta del proyecto:

    cd inventario-castores

Instala las dependencias del proyecto:

    composer install --no-dev

Copia el archivo `env` a `.env` para configurar la aplicación:

    cp env .env

Edita el archivo de configuración `.env` y descomente cada opción requerida:

    CI_ENVIRONMENT = development

    database.default.hostname = localhost
    database.default.database = inventario
    database.default.username = root
    database.default.password = root
    database.default.DBDriver = MySQLi
    database.default.DBPrefix =
    database.default.port = 3306

> Ajuste cada opción señalada en base a su configuración.

## Base de datos

El archivo `SCRIPTS/database.sql` contiene el script para crear la base de datos de la aplicación.

* [Diagrama relacional de la base de datos.](https://drive.google.com/file/d/1vTed8ghK5EeRyqZ5mkTiN1dQWNctJI5B/view?usp=sharing)

## Ejecución

    php spark serve

* <http://localhost:8080>

## Dependencias de desarrollo (opcional)

Dependencias:

* [Node.js - Entorno de ejecución para JavaScript.](https://nodejs.org)
* [npm - Gestor de dependencias de Node.js para JavaScript.](https://www.npmjs.com)

Instala las dependencias de desarrollo:

    composer install
    npm install

## Comandos de desarrollo

Ejecuta CodeIgniter Coding Standard:

    composer run linter

Compila Tailwind CSS:

    npm run tailwindcss

Ejecuta StandardJS:

    npm run standard

## Herramientas utilizadas

* [CodeIgniter 4 - Framework de desarrollo de aplicaciones web basado en PHP.](https://codeigniter.com)
* [CodeIgniter Coding Standard - Guías de estilo para CodeIgniter.](https://github.com/CodeIgniter/coding-standard)
* [Tailwind CSS - Framework de CSS basado en utilidades.](https://tailwindcss.com)
* [daisyUI - Biblioteca de componentes para Tailwind CSS.](https://daisyui.com)
* [StandardJS - Guía de estilos JavaScript, con linter y corrección automática de código.](https://standardjs.com)
* [Visual Studio Code - Editor de código fuente.](https://code.visualstudio.com)
* [Intelephense - Extensión para Visual Studio Code que incluye herramientas productivas para desarrollar con PHP.](https://github.com/bmewburn/vscode-intelephense)
* [Tailwind CSS IntelliSense - Extensión para Visual Studio Code que incluye herramientas de ayuda para Tailwind CSS.](https://github.com/tailwindlabs/tailwindcss-intellisense)
* [draw.io - Aplicación web para desarrollar diagramas.](https://app.diagrams.net)
* [Composer - Gestor de dependencias para PHP.](https://getcomposer.org)

## Licencia

    Sistema de inventario -- Evaluación Técnica de Programación del Grupo Castores.

    Copyright (C) 2024  Ricardo García Jiménez <ricardogj08@riseup.net>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

    ========================================================================

    The MIT License (MIT)

    Copyright (c) 2014-2019 British Columbia Institute of Technology
    Copyright (c) 2019-2024 CodeIgniter Foundation

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
