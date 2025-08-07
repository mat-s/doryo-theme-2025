# WordPress Boilerplate

Ein modernes WordPress-Entwicklungs-Setup mit Docker, Vite, TypeScript und SCSS.

## 🚀 Features

- **Docker-Stack**: PHP 8.2, MySQL 8.0, phpMyAdmin
- **Modern Build-Tools**: Vite mit HMR, TypeScript, SCSS
- **Code Quality**: ESLint, Prettier, Stylelint, PHP_CodeSniffer
- **Theme**: Hello Elementor Child Theme
- **Plugin Management**: Composer mit wpackagist.org
- **CI/CD Ready**: Vorbereitete GitHub Actions

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
cd wp-content/themes/hello-child
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
- Aktiviere das "Hello Child" Theme

### 5. Entwicklungsserver starten (optional)
```bash
cd wp-content/themes/hello-child
npm run dev
```

## 🌐 URLs

- **WordPress**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **Vite Dev Server**: http://localhost:3000 (HMR für Assets)

## 📁 Projektstruktur

```
project/
├── docker-compose.yml              # Docker-Services
├── Dockerfile.vite                 # Vite Container
├── composer.json                   # PHP Dependencies
├── wp-content/
│   └── themes/
│       └── hello-child/            # Child Theme
│           ├── package.json        # Node Dependencies
│           ├── vite.config.js      # Vite-Konfiguration
│           ├── tsconfig.json       # TypeScript-Config
│           ├── functions.php       # Theme-Funktionen
│           ├── assets/
│           │   ├── js/             # TypeScript-Dateien
│           │   └── scss/           # SCSS-Dateien
│           └── dist/               # Kompilierte Assets
└── uploads.ini                     # PHP-Konfiguration
```

## 🔧 Entwicklungs-Commands

### Theme-Entwicklung
```bash
cd wp-content/themes/hello-child

# Entwicklungsserver mit HMR
npm run dev

# Production Build
npm run build

# Code-Qualität
npm run lint:js          # JavaScript/TypeScript Linting
npm run lint:css         # SCSS Linting
npm run format:js        # JavaScript/TypeScript Formatierung
npm run format:css       # SCSS Formatierung
npm run type-check       # TypeScript Type Checking
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
1. Vite Dev Server läuft auf Port 3000
2. Assets werden live vom Dev Server geladen
3. HMR für sofortige Änderungen
4. Source Maps für Debugging

### Production
1. `npm run build` erstellt optimierte Assets
2. Assets werden mit Hashes versioniert
3. Manifest.json für Asset-Mapping
4. CSS wird extrahiert und optimiert

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

### GitHub Actions (vorbereitet)
1. Erstelle `.github/workflows/deploy.yml`
2. Konfiguriere Server-Credentials als Secrets
3. Push zu main Branch triggert Deployment

### Manuelles Deployment
1. `npm run build` ausführen
2. `composer install --no-dev --optimize-autoloader`
3. Files zum Server übertragen
4. Datenbank synchronisieren

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
- TypeScript-Module in `assets/js/modules/`
- PHP-Funktionen in `functions.php`

### Docker-Anpassungen
- PHP-Konfiguration in `uploads.ini`
- MySQL-Konfiguration in `docker-compose.yml`
- Vite-Konfiguration in `Dockerfile.vite`

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
