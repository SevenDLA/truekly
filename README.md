<hr>

<p align="center">
    <img src="public/images/truekly.png" width="500" alt="Truekly Logo">
</p>

<hr>

<p align="center">
    La plataforma de intercambio de servicios basada en trueque y créditos virtuales.
</p>

<hr>
<br>

# 💱 **Truekly**

Bienvenido a **Truekly**, la plataforma donde el **trueque** de habilidades y servicios se encuentra con la innovación de los **Tokenskills**, una moneda digital que facilita las transacciones entre usuarios. Si no puedes intercambiar directamente tus habilidades, no te preocupes, los **Tokenskills** permiten realizar cualquier transacción de manera rápida, sencilla y segura.

## Características Clave

**Truekly** ofrece una experiencia única con estas funcionalidades:

- 🤝 **Intercambio Directo de Servicios:** ¿Sabes frontend y alguien necesita aprender backend? ¡Intercámbialo! Truekly te permite negociar habilidades entre usuarios sin intermediarios ni dinero real.

- 💰 **Tokenskills:** Tu moneda dentro de Truekly. Acumula Tokenskills ofreciendo tus servicios y utilízalos para adquirir otros servicios o incluso venderlos a otros usuarios.

- 🎯 **Interfaz Intuitiva:** Truekly está diseñada para ser extremadamente fácil de usar, permitiendo a los usuarios gestionar tanto los servicios que ofrecen como los Tokenskills con un par de clics.

- 🔄 **Sistema de Trueque Flexible:** Fomenta el intercambio directo de conocimientos. Si no es posible un trueque directo, puedes utilizar **Tokenskills** como alternativa, haciendo las transacciones aún más accesibles.

## Innovaciones

**Truekly** implementa varias características innovadoras que mejoran la experiencia del usuario:

- 🏆 **Trueque Directo:** Truekly fomenta la economía del intercambio, sin necesidad de intermediarios ni dinero real. ¡Negocia servicios y conocimientos de forma directa!

- 💸 **Venta de Tokenskills:** Si no necesitas utilizar tus Tokenskills de inmediato, puedes venderlos a otros usuarios a un precio más bajo, ayudando a aquellos que necesiten obtener créditos de forma más económica.

- 👨‍💻 **Comisión por Transacción:** Truekly obtiene una pequeña comisión sobre las transacciones realizadas entre los usuarios, lo que asegura la sostenibilidad a largo plazo de la plataforma.

## Futuras Implementaciones

**Truekly** no se detiene aquí y tenemos grandes planes para el futuro:

- 🚨 **Alertas de Servicios:** Los usuarios podrán configurar alertas personalizadas para recibir notificaciones sobre nuevos servicios que coincidan con sus necesidades.

- 📱 **Aplicación Móvil:** Estamos desarrollando una versión móvil para que puedas gestionar tus servicios y Tokenskills desde cualquier lugar, de forma rápida y cómoda.

- 📝 **Sistema de Valoraciones:** Los usuarios podrán dejar valoraciones sobre los servicios que recibieron, lo que ayudará a crear una red de confianza y a mejorar la calidad del intercambio.

---

## 🚀 Requisitos previos

### 🐘 PHP 8.1 y extensiones

Instala PHP y sus extensiones:

```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php php-cli php-mbstring php-xml php-bcmath php-curl php-zip unzip curl -y
````

Confirma la instalación:

```bash
php -v
```

---

### 📦 Composer

Instala Composer:

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

Verifica la instalación:

```bash
composer --version
```

---

### 🐬 MySQL

Instala MySQL y la extensión de PHP:

```bash
sudo apt install mysql-server php-mysql -y
```

---

### 🟢 Node.js y npm

Instala Node.js:

```bash
sudo apt install nodejs npm -y
```

Verifica las versiones:

```bash
node -v
npm -v
```

---

### 🧬 Git

Instala Git:

```bash
sudo apt install git -y
```

Confirma la instalación:

```bash
git --version
```

---

## ⚙️ Instalación del proyecto

1. Configura la base de datos:

```sql
sudo mysql

CREATE DATABASE truekly;
CREATE USER 'truekly'@'localhost' IDENTIFIED BY 'DawSegundo77+';
GRANT ALL PRIVILEGES ON *.* TO 'truekly'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

2. Clona el repositorio:

```bash
git clone https://github.com/SevenDLA/truekly.git
```

3. Accede al directorio del proyecto:

```bash
cd truekly
```

4. Otorga permisos a los archivos:

```bash
sudo chmod 777 -R ./*
```

5. Instala las dependencias:

```bash
composer install
npm install
npm run build
```

6. Copia el archivo de entorno:

```bash
cp .env.example .env
```

7. Genera la clave de aplicación:

```bash
php artisan key:generate
```

8. Ejecuta las migraciones y seeders:

```bash
php artisan migrate:refresh --seed
```

9. Enlaza el almacenamiento para imágenes:

```bash
php artisan storage:link
```

10. Inicia el servidor local:

```bash
php artisan serve
```

Accede a la app en: **[http://127.0.0.1:8000](http://127.0.0.1:8000/)**

---

## Documentos
- [Fase de Diseño](https://github.com/user-attachments/files/20027627/Truekly.pdf)

- [Diagrama de Clases](https://github.com/user-attachments/files/20027564/DiagramaDeClases.pdf)

- [Casos de Uso](https://github.com/user-attachments/files/20027562/CasoUsos.pdf)

- [Test Unitarios](https://github.com/user-attachments/files/20128250/Test.Unitarios.pdf)

---

> Hecho por Darren Angelo Lajara Corpuz y Seven de León Amador
