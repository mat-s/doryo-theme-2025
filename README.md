# WordPress Doryo Theme

Ein modernes WordPress-Theme-Setup mit Docker, SCSS und Vanilla JavaScript.

## 🚀 Features

- **Docker-Stack**: PHP 8.2, MySQL 8.0, phpMyAdmin
- **Modern CSS**: SCSS mit 7-1 Architektur
- **Vanilla JavaScript**: Keine komplexen Build-Tools
- **Code Quality**: Stylelint, Prettier, PHP_CodeSniffer
- **Theme**: Doryo Theme (Hello Elementor Child Theme)
- **Plugin Management**: Composer mit wpackagist.org
- **Elementor Integration**: Custom Hero Unit Widget

## 📋 Voraussetzungen

- Docker und Docker Compose
- Node.js 18+
- Composer

## 🛠 Installation

### 1. Repository klonen
```bash
git clone <repository-url>
cd <project-name>
```

### 2. Dependencies installieren
```bash
# PHP Dependencies
composer install

# Node.js Dependencies (im Theme-Ordner)
cd wp-content/themes/doryo-theme
npm install
cd ../../..
```

### 3. Docker-Umgebung starten
```bash
docker-compose up -d
```

### 4. WordPress einrichten
- Besuche http://localhost:8080
- Folge der WordPress-Installation
- Aktiviere das "Doryo Theme"

### 5. Assets builden
```bash
cd wp-content/themes/doryo-theme
npm run build
```

## 🌐 URLs

- **WordPress**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

## 📁 Projektstruktur

```
project/
├── docker-compose.yml              # Docker-Services
├── composer.json                   # PHP Dependencies
├── wp-content/
│   └── themes/
│       └── doryo-theme/            # Doryo Theme
│           ├── package.json        # Node Dependencies
│           ├── functions.php       # Theme-Funktionen
│           ├── Widgets/            # Custom Elementor Widgets
│           │   ├── WidgetManager.php
│           │   └── HeroUnitWidget.php
│           ├── assets/
│           │   ├── js/             # JavaScript-Dateien
│           │   └── scss/           # SCSS-Dateien (7-1 Architektur)
│           └── dist/               # Kompilierte Assets (CSS + JS)
└── uploads.ini                     # PHP-Konfiguration
```

## 🔧 Entwicklungs-Commands

### Theme-Entwicklung
```bash
cd wp-content/themes/doryo-theme

# Production Build
npm run build

# Watch-Modus für Entwicklung
npm run watch

# Nur CSS builden
npm run build:css

# Nur JavaScript builden  
npm run build:js

# CSS Watch-Modus
npm run watch:css

# JavaScript Watch-Modus
npm run watch:js

# Code-Qualität
npm run lint:css         # SCSS Linting
npm run format:css       # SCSS Formatierung
```

### PHP-Entwicklung
```bash
# PHP Linting
composer run phpcs

# PHP Code-Formatierung
composer run phpcbf

# Tests ausführen
composer run test
```

## 🔌 Inkludierte Plugins

### Free Plugins (via Composer)
- WordPress SEO (Yoast)
- Classic Editor
- Duplicate Post
- Enable Media Replace
- Post Types Order
- Regenerate Thumbnails
- Simple Revisions Delete

### Premium Plugins (manuell installieren)
- ACF Pro
- Elementor Pro
- WPML
- Real Cookie Banner
- WP Migrate Pro

## 🎨 Asset-Workflow

### Entwicklung
1. `npm run watch` für automatisches Rebuilding
2. SCSS wird zu komprimiertem CSS kompiliert
3. JavaScript wird direkt kopiert
4. Dateien werden in `dist/` Ordner erstellt

### Production
1. `npm run build` erstellt optimierte Assets
2. CSS wird komprimiert und mit Source Maps
3. JavaScript wird in `dist/` kopiert
4. WordPress lädt Assets aus `dist/` Ordner

## 🎨 SCSS-Architektur (7-1 Pattern)

```
assets/scss/
├── abstracts/          # Variablen, Functions, Mixins
├── vendors/           # Third-party CSS (Normalize.css)
├── base/              # Reset, Typography, etc.
├── layout/            # Header, Footer, Grid, etc.
├── components/        # Buttons, Forms, etc. 
├── pages/             # Page-spezifische Styles
└── themes/            # Theme-spezifische Overrides
```

## 🗃 Datenbank

### Entwicklungsdaten
- **Host**: localhost:3306
- **Database**: wordpress
- **User**: wordpress
- **Password**: wordpress123

### Backup/Restore
```bash
# Backup erstellen
docker exec wp_db mysqldump -u root -prootpassword123 wordpress > backup.sql

# Backup wiederherstellen
docker exec -i wp_db mysql -u root -prootpassword123 wordpress < backup.sql
```

## 🚀 Deployment

### Manuelles Deployment
1. `npm run build` ausführen
2. `composer install --no-dev --optimize-autoloader`
3. Files zum Server übertragen
4. Datenbank synchronisieren

## 🎛 Custom Elementor Widgets

### Hero Unit Widget
- **Titel & Untertitel** mit individueller Formatierung
- **Call-to-Action Button** mit Icon-Unterstützung
- **Hero-Bild** mit Responsive-Unterstützung
- **Flag/Label System** für Badges
- **Blob-Hintergrund** mit konfigurierbaren Farben

### Widget-Verwendung
1. Im Elementor-Editor verfügbar unter "Doryo Widgets"
2. Drag & Drop auf die Seite
3. Konfiguration über das Elementor-Panel
4. Live-Vorschau während der Bearbeitung

## 🔒 Sicherheit

### Entwicklung
- Debug-Modus ist aktiviert
- Error-Logging ist eingeschaltet
- Alle Passwörter sind Standard-Entwicklungspasswörter

### Production
- Debug-Modus deaktivieren
- Sichere Passwörter setzen
- SSL-Zertifikate installieren
- Security-Plugins aktivieren

## 🛠 Anpassungen

### Theme-Anpassungen
- SCSS-Variablen in `assets/scss/abstracts/_variables.scss`
- JavaScript-Module in `assets/js/main.js`
- PHP-Funktionen in `functions.php`
- Custom Widgets in `Widgets/` Ordner

### Docker-Anpassungen
- PHP-Konfiguration in `uploads.ini`
- MySQL-Konfiguration in `docker-compose.yml`

## 📝 Lizenz

Dieses Projekt ist unter der [MIT Lizenz](LICENSE) lizenziert.

## 🤝 Contributing

1. Fork das Repository
2. Erstelle einen Feature-Branch
3. Committe deine Änderungen
4. Pushe den Branch
5. Erstelle einen Pull Request

## 📧 Support

Bei Fragen oder Problemen erstelle bitte ein [Issue](issues) im Repository.
