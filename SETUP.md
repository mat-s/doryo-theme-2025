# WordPress Docker Boilerplate - Setup Instructions

## 🚀 Quick Start

### 1. Setup ausführen
```bash
# Im HTML-Ordner (Projektverzeichnis)
chmod +x setup.sh
./setup.sh
```

**Oder manuell:**

```bash
# Dependencies installieren
composer install
cd wp-content/themes/hello-child
npm install
cd ../../../

# Docker-Container starten
docker-compose up -d

# Browser öffnen: http://localhost:8080
```

### 2. WordPress einrichten
1. http://localhost:8080 öffnen
2. WordPress-Installation durchführen:
   - **Datenbankname:** `wordpress`
   - **Benutzername:** `wordpress` 
   - **Passwort:** `wordpress123`
   - **Host:** `db`
3. Admin-Account erstellen

### 3. Theme aktivieren
1. WordPress Admin → **Design** → **Themes**
2. **"Hello Child"** Theme aktivieren

## 📦 Premium Plugins Setup

Da Premium-Plugins nicht über Composer verfügbar sind:

### 1. **ACF Pro**
- Plugin-ZIP in `wp-content/plugins/` hochladen
- Lizenzschlüssel eingeben

### 2. **Elementor Pro** 
- Plugin-ZIP in `wp-content/plugins/` hochladen
- Mit Elementor-Account verbinden

### 3. **WPML**
- Core-Plugin und Add-ons hochladen
- Lizenz aktivieren

### 4. **Weitere Premium Plugins**
- Real Cookie Banner
- WP Migrate Pro

## 🛠 Entwicklung

### Assets kompilieren
```bash
cd wp-content/themes/hello-child
npm run dev    # Development mit HMR
npm run build  # Production Build
```

### Code-Qualität
```bash
npm run lint        # JavaScript/TypeScript & SCSS
composer run phpcs  # PHP Code Standards
```

## 🌐 URLs

- **WordPress:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081  
- **Vite Dev Server:** http://localhost:3000

## 🔧 Troubleshooting

### Container-Status prüfen
```bash
docker-compose ps
docker-compose logs
```

### Services neu starten
```bash
docker-compose restart
# Oder für komplette Neuerstellung:
docker-compose down
docker-compose up -d --build
```

### Port-Konflikte
Falls Ports belegt sind, in [`docker-compose.yml`](docker-compose.yml ) ändern:
```yaml
ports:
  - "8090:80"  # WordPress
  - "8091:80"  # phpMyAdmin  
  - "3001:3000" # Vite
```

### MySQL-Probleme
```bash
# MySQL-Volume zurücksetzen (Vorsicht: löscht Daten!)
docker-compose down
docker volume rm html_db_data
docker-compose up -d
```

### Vite-Server Probleme
```bash
# Vite-Container neu bauen
docker-compose build vite
docker-compose up -d
```

## ⚙️ Customization

### **CSS-Variablen:** 
`wp-content/themes/hello-child/assets/scss/abstracts/_variables.scss`

### **TypeScript-Config:**
`wp-content/themes/hello-child/tsconfig.json`

### **Vite-Config:**
`wp-content/themes/hello-child/vite.config.js`

## 📁 Projektstruktur

Siehe [`structure.txt`](structure.txt ) für detaillierte Übersicht.

---

**Happy Coding! 🚀**
