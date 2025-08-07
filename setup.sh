#!/bin/bash

# WordPress Docker Boilerplate Setup Script

echo "🚀 WordPress Docker Boilerplate Setup"
echo "======================================"

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker ist nicht gestartet. Bitte Docker starten und erneut versuchen."
    exit 1
fi

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "❌ Node.js ist nicht installiert. Bitte Node.js installieren."
    exit 1
fi

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ Composer ist nicht installiert. Bitte Composer installieren."
    exit 1
fi

echo "✅ Alle Abhängigkeiten sind verfügbar"

# Install PHP dependencies
echo "📦 Installiere PHP-Abhängigkeiten..."
composer install

# Install Node.js dependencies
echo "📦 Installiere Node.js-Abhängigkeiten..."
cd wp-content/themes/hello-child
npm install
cd ../../..

# Start Docker containers
echo "🐳 Starte Docker-Container..."
docker-compose up -d

# Wait for services to be ready
echo "⏳ Warte auf Services..."
sleep 30

# Check if WordPress is accessible
echo "🔍 Prüfe WordPress-Verfügbarkeit..."
for i in {1..30}; do
    if curl -f http://localhost:8080 > /dev/null 2>&1; then
        echo "✅ WordPress ist verfügbar!"
        break
    fi
    echo "⏳ Warte auf WordPress... ($i/30)"
    sleep 2
done

echo ""
echo "🎉 Setup erfolgreich abgeschlossen!"
echo ""
echo "🌐 URLs:"
echo "   WordPress:    http://localhost:8080"
echo "   phpMyAdmin:   http://localhost:8081"
echo "   Vite Dev:     http://localhost:3000"
echo ""
echo "📚 Nächste Schritte:"
echo "   1. Öffne http://localhost:8080"
echo "   2. Folge der WordPress-Installation"
echo "   3. Aktiviere das 'Hello Child' Theme"
echo "   4. Für Entwicklung: cd wp-content/themes/hello-child && npm run dev"
echo ""
echo "📖 Weitere Informationen in README.md und SETUP.md"
