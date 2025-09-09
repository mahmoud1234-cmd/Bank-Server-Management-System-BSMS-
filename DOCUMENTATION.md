# 🏦 BSMS - Bank Server Management System
## Documentation Complète du Projet

### 📋 Table des Matières
1. [Vue d'ensemble](#vue-densemble)
2. [Architecture du projet](#architecture-du-projet)
3. [Structure des dossiers](#structure-des-dossiers)
4. [Modèles de données](#modèles-de-données)
5. [Contrôleurs](#contrôleurs)
6. [Vues et interfaces](#vues-et-interfaces)
7. [Routes](#routes)
8. [Base de données](#base-de-données)
9. [Fonctionnalités principales](#fonctionnalités-principales)
10. [Installation et configuration](#installation-et-configuration)
11. [Utilisation](#utilisation)

---

## 🎯 Vue d'ensemble

**BSMS (Bank Server Management System)** est un système complet de gestion d'infrastructure informatique pour environnements bancaires. Il permet la gestion centralisée des serveurs, datacenters, incidents, maintenances et clusters avec un focus sur la sécurité et la conformité bancaire.

### Caractéristiques principales :
- **Framework** : Laravel 12 avec React/Inertia.js
- **Base de données** : MySQL/SQLite
- **Interface** : Tailwind CSS + AdminLTE
- **Sécurité** : Authentification Laravel Breeze, audit trails
- **Conformité** : Logging complet, niveaux de criticité

---

## 🏗️ Architecture du projet

```
BSMS/
├── app/                    # Logique métier Laravel
├── bootstrap/              # Initialisation Laravel
├── config/                 # Configuration système
├── database/               # Migrations, seeders, factories
├── public/                 # Assets publics
├── resources/              # Vues, CSS, JS
├── routes/                 # Définition des routes
├── storage/                # Fichiers temporaires, logs
├── tests/                  # Tests automatisés
└── vendor/                 # Dépendances Composer
```

---

## 📁 Structure des dossiers détaillée

### `/app` - Logique métier
```
app/
├── Console/Commands/       # Commandes Artisan personnalisées
├── Http/
│   ├── Controllers/        # Contrôleurs MVC
│   ├── Middleware/         # Middlewares personnalisés
│   └── Requests/           # Validation des requêtes
├── Models/                 # Modèles Eloquent
└── Providers/              # Fournisseurs de services
```

### `/database` - Gestion des données
```
database/
├── factories/              # Factories pour tests
├── migrations/             # Migrations de base de données
└── seeders/                # Données de test/initialisation
```

### `/resources` - Interface utilisateur
```
resources/
├── css/                    # Styles CSS
├── js/                     # JavaScript/React
└── views/                  # Templates Blade
    ├── auth/               # Pages d'authentification
    ├── clusters/           # Gestion des clusters
    ├── components/         # Composants réutilisables
    ├── datacenters/        # Gestion des datacenters
    ├── incidents/          # Gestion des incidents
    ├── layouts/            # Layouts principaux
    ├── maintenance-tasks/  # Tâches de maintenance
    └── servers/            # Gestion des serveurs
```

---

## 🗃️ Modèles de données

### 1. **Server.php** - Modèle principal des serveurs
```php
// Champs principaux
- name: Nom du serveur
- ip_address: Adresse IP (unique)
- password: Mot de passe chiffré
- operating_system: Système d'exploitation
- role: Rôle du serveur
- status: Actif/Maintenance/Hors service
- critical_level: low/medium/high/critical
- datacenter_id: Référence au datacenter
- cluster_id: Référence au cluster
```

**Relations :**
- `belongsTo(Datacenter::class)` - Appartient à un datacenter
- `belongsTo(Cluster::class)` - Appartient à un cluster
- `hasMany(Incident::class)` - Peut avoir plusieurs incidents
- `hasMany(MaintenanceTask::class)` - Peut avoir plusieurs maintenances
- `belongsToMany(User::class)` - Utilisateurs assignés

### 2. **Datacenter.php** - Centres de données
```php
// Champs principaux
- name: Nom du datacenter
- code: Code unique
- address: Adresse complète
- city, country: Localisation
- capacity: Capacité en serveurs
- status: operational/maintenance/offline
- security_level: Niveau de sécurité
- timezone: Fuseau horaire
```

**Relations :**
- `hasMany(Server::class)` - Contient plusieurs serveurs

### 3. **Incident.php** - Gestion des incidents
```php
// Champs principaux
- title: Titre de l'incident
- description: Description détaillée
- severity: low/medium/high/critical
- status: open/in_progress/resolved/closed
- server_id: Serveur concerné
- reported_by: Utilisateur rapporteur
- assigned_to: Utilisateur assigné
```

### 4. **MaintenanceTask.php** - Tâches de maintenance
```php
// Champs principaux
- title: Titre de la tâche
- description: Description
- scheduled_date: Date programmée
- status: pending/in_progress/completed/cancelled
- priority: low/medium/high/critical
- server_id: Serveur concerné
```

### 5. **Cluster.php** - Gestion des clusters
```php
// Champs principaux
- name: Nom du cluster
- description: Description
- mode: active_active/active_passive
- status: active/inactive/maintenance
```

**Relations :**
- `hasMany(Server::class)` - Contient plusieurs serveurs (nombre pair requis)

### 6. **AuditLog.php** - Journalisation
```php
// Champs principaux
- action: Type d'action
- description: Description de l'action
- user_id: Utilisateur responsable
- server_id: Serveur concerné (optionnel)
- old_values/new_values: Valeurs avant/après
```

---

## 🎮 Contrôleurs

### 1. **ServerController.php** - Gestion des serveurs
**Méthodes principales :**
- `index()` - Liste des serveurs avec filtres
- `create()` - Formulaire de création complet
- `addToSite()` - Formulaire d'ajout rapide (IP, nom, mot de passe)
- `store()` - Création complète d'un serveur
- `storeToSite()` - Ajout rapide avec valeurs par défaut
- `show()` - Détails d'un serveur
- `edit()` - Formulaire de modification
- `update()` - Mise à jour d'un serveur
- `destroy()` - Suppression d'un serveur
- `assignUsers()` - Assignation d'utilisateurs
- `export()` - Export CSV/PDF

### 2. **DatacenterController.php** - Gestion des datacenters
**Méthodes principales :**
- `index()` - Liste des datacenters
- `create()` - Formulaire de création
- `store()` - Création d'un datacenter
- `show()` - Détails avec statistiques des serveurs
- `edit()` - Formulaire de modification
- `update()` - Mise à jour
- `destroy()` - Suppression

### 3. **IncidentController.php** - Gestion des incidents
**Méthodes principales :**
- `index()` - Liste des incidents avec filtres
- `create()` - Formulaire de création
- `store()` - Création d'un incident
- `show()` - Détails de l'incident
- `update()` - Mise à jour du statut
- `resolve()` - Résolution d'incident

### 4. **ClusterController.php** - Gestion des clusters
**Méthodes principales :**
- `index()` - Liste des clusters
- `create()` - Formulaire de création
- `store()` - Création avec validation (nombre pair de serveurs)
- `show()` - Détails du cluster
- `addServer()` - Ajout de serveur au cluster
- `removeServer()` - Retrait de serveur du cluster

### 5. **DashboardController.php** - Tableau de bord
**Méthodes :**
- `index()` - Statistiques générales, graphiques, alertes

---

## 🎨 Vues et interfaces

### Structure des vues Blade

#### **Layouts principaux**
- `app.blade.php` - Layout principal avec navigation
- `navigation.blade.php` - Barre de navigation responsive
- `guest.blade.php` - Layout pour pages publiques

#### **Pages d'authentification** (`/auth`)
- `login.blade.php` - Page de connexion
- `register.blade.php` - Page d'inscription
- `forgot-password.blade.php` - Récupération de mot de passe

#### **Gestion des serveurs** (`/servers`)
- `index.blade.php` - Liste avec filtres et statistiques
- `create.blade.php` - Formulaire complet de création
- `add-to-site.blade.php` - **Formulaire d'ajout rapide** (IP, nom, mot de passe)
- `show.blade.php` - Détails du serveur
- `edit.blade.php` - Formulaire de modification

#### **Gestion des datacenters** (`/datacenters`)
- `index.blade.php` - Liste des datacenters
- `create.blade.php` - Formulaire de création
- `show.blade.php` - Détails avec statistiques
- `edit.blade.php` - Formulaire de modification

#### **Gestion des incidents** (`/incidents`)
- `index.blade.php` - Liste avec filtres par sévérité/statut
- `create.blade.php` - Formulaire de déclaration
- `show.blade.php` - Détails de l'incident

#### **Gestion des clusters** (`/clusters`)
- `index.blade.php` - Liste des clusters
- `create.blade.php` - Formulaire avec validation nombre pair
- `show.blade.php` - Détails et serveurs assignés

---

## 🛣️ Routes

### **Routes principales** (`web.php`)

#### Authentification
```php
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Serveurs - routes spécifiques AVANT resource
    Route::get('/servers/add-to-site', [ServerController::class, 'addToSite']);
    Route::post('/servers/store-to-site', [ServerController::class, 'storeToSite']);
    Route::resource('servers', ServerController::class);
    
    // Autres resources
    Route::resource('datacenters', DatacenterController::class);
    Route::resource('incidents', IncidentController::class);
    Route::resource('clusters', ClusterController::class);
    Route::resource('maintenance-tasks', MaintenanceTaskController::class);
});
```

#### Routes spéciales
- `/servers/add-to-site` - **Ajout rapide de serveur**
- `/test/*` - Routes de diagnostic pour développement

---

## 🗄️ Base de données

### **Migrations principales**

#### 1. **create_servers_table.php**
```sql
CREATE TABLE servers (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    ip_address VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255), -- Ajouté récemment
    operating_system VARCHAR(255),
    role VARCHAR(255),
    status ENUM('Actif','Maintenance','Hors service'),
    datacenter_id BIGINT,
    cluster_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### 2. **create_datacenters_table.php**
```sql
CREATE TABLE datacenters (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(255) UNIQUE,
    address TEXT,
    city VARCHAR(255),
    country VARCHAR(255),
    capacity INTEGER,
    status ENUM('operational','maintenance','offline'),
    security_level ENUM('low','medium','high','critical'),
    timezone VARCHAR(255)
);
```

#### 3. **create_incidents_table.php**
```sql
CREATE TABLE incidents (
    id BIGINT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    severity ENUM('low','medium','high','critical'),
    status ENUM('open','in_progress','resolved','closed'),
    server_id BIGINT,
    reported_by BIGINT,
    assigned_to BIGINT
);
```

#### 4. **create_clusters_table.php**
```sql
CREATE TABLE clusters (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    mode ENUM('active_active','active_passive'),
    status ENUM('active','inactive','maintenance')
);
```

### **Seeders**
- `AdminUserSeeder.php` - Création utilisateur admin par défaut
- `ServerSeeder.php` - Serveurs de test
- `DatacenterSeeder.php` - Datacenters d'exemple
- `ClusterSeeder.php` - Clusters de test

---

## ⚙️ Fonctionnalités principales

### 1. **Gestion des serveurs**
- ✅ **CRUD complet** (Create, Read, Update, Delete)
- ✅ **Ajout rapide au site** avec IP, nom, mot de passe
- ✅ **Filtres avancés** par statut, OS, criticité
- ✅ **Assignation d'utilisateurs**
- ✅ **Export CSV/PDF**
- ✅ **Audit trail** complet

### 2. **Gestion des datacenters**
- ✅ **CRUD complet**
- ✅ **Statistiques d'utilisation**
- ✅ **Gestion de la capacité**
- ✅ **Niveaux de sécurité**
- ✅ **Localisation géographique**

### 3. **Gestion des incidents**
- ✅ **Déclaration d'incidents**
- ✅ **Niveaux de sévérité**
- ✅ **Workflow de résolution**
- ✅ **Assignation d'équipes**
- ✅ **Historique complet**

### 4. **Gestion des clusters**
- ✅ **Création de clusters**
- ✅ **Validation nombre pair de serveurs**
- ✅ **Modes active/active et active/passive**
- ✅ **Gestion des serveurs assignés**

### 5. **Tableau de bord**
- ✅ **Statistiques en temps réel**
- ✅ **Alertes et notifications**
- ✅ **Graphiques de performance**
- ✅ **Vue d'ensemble système**

### 6. **Sécurité et audit**
- ✅ **Authentification Laravel Breeze**
- ✅ **Chiffrement des mots de passe**
- ✅ **Logging complet des actions**
- ✅ **Niveaux d'accès utilisateurs**

---

## 🚀 Installation et configuration

### Prérequis
- PHP 8.2+
- Composer
- Node.js et NPM
- MySQL/SQLite
- Serveur web (Apache/Nginx)

### Installation
```bash
# 1. Cloner le projet
git clone https://github.com/mahmoud1234-cmd/Bank-Server-Management-System-BSMS-.git
cd BSMS

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JavaScript
npm install

# 4. Configuration environnement
cp .env.example .env
php artisan key:generate

# 5. Configuration base de données
# Éditer .env avec vos paramètres DB

# 6. Migrations et seeders
php artisan migrate
php artisan db:seed

# 7. Compilation des assets
npm run build

# 8. Lancer le serveur
php artisan serve
```

### Configuration spécifique
```env
# .env - Configuration principale
APP_NAME="BSMS"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bsms
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📖 Utilisation

### 1. **Connexion**
- Accéder à `http://localhost:8000`
- Se connecter avec les identifiants admin (voir seeders)

### 2. **Ajout rapide de serveur**
1. Aller dans **Serveurs**
2. Cliquer sur **"Ajouter au Site"** (bouton vert)
3. Remplir :
   - Nom du serveur
   - Adresse IP
   - Mot de passe
4. Valider - Le serveur est créé avec des paramètres par défaut

### 3. **Gestion complète des serveurs**
1. **"Nouveau Serveur"** pour création complète
2. Remplir tous les champs (OS, rôle, datacenter, etc.)
3. Assigner des utilisateurs si nécessaire

### 4. **Gestion des incidents**
1. **Incidents** → **Nouveau**
2. Sélectionner le serveur concerné
3. Définir la sévérité et description
4. Assigner à un technicien

### 5. **Création de clusters**
1. **Clusters** → **Nouveau**
2. Choisir un nombre **pair** de serveurs
3. Sélectionner le mode (active/active ou active/passive)

### 6. **Tableau de bord**
- Vue d'ensemble des statistiques
- Alertes en temps réel
- Graphiques de performance
- Incidents critiques

---

## 📁 Fichiers de configuration importants

### **composer.json** - Dépendances PHP
```json
{
    "require": {
        "laravel/framework": "^11.0",
        "laravel/breeze": "^2.0",
        "spatie/laravel-permission": "^6.0"
    }
}
```

### **package.json** - Dépendances JavaScript
```json
{
    "devDependencies": {
        "@vitejs/plugin-react": "^4.2.1",
        "tailwindcss": "^3.4.0",
        "vite": "^5.0.0"
    }
}
```

### **tailwind.config.js** - Configuration CSS
```javascript
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
    ],
    theme: {
        extend: {},
    },
}
```

---

## 🔧 Scripts utiles

### **fix_setup.bat** - Script de réparation Windows
```batch
@echo off
echo Nettoyage et réinstallation BSMS...
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo Installation terminée!
pause
```

### **reinstall_bsms.bat** - Réinstallation complète
```batch
@echo off
echo Réinstallation complète BSMS...
rmdir /s /q vendor
rmdir /s /q node_modules
composer install
npm install
php artisan migrate:fresh --seed
npm run build
echo Réinstallation terminée!
pause
```

---

## 🎯 Points clés du projet

### **Fonctionnalité unique : Ajout rapide de serveur**
- **Route** : `/servers/add-to-site`
- **Vue** : `resources/views/servers/add-to-site.blade.php`
- **Contrôleur** : `ServerController::addToSite()` et `storeToSite()`
- **Particularité** : Formulaire simplifié avec valeurs par défaut automatiques

### **Sécurité bancaire**
- Chiffrement des mots de passe serveur
- Audit trail complet
- Niveaux de criticité
- Gestion des accès utilisateurs

### **Architecture modulaire**
- Séparation claire MVC
- Composants réutilisables
- API REST pour extensions futures
- Tests automatisés

---

## 📞 Support et maintenance

### **Logs système**
- `storage/logs/laravel.log` - Logs Laravel
- Base de données `audit_logs` - Actions utilisateurs

### **Commandes de maintenance**
```bash
# Nettoyage cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Optimisation production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations
php artisan migrate:status
php artisan migrate:rollback
```

### **Débogage**
- Routes de test disponibles : `/test/*`
- Mode debug dans `.env` : `APP_DEBUG=true`
- Logs détaillés activés

---

**Développé par l'équipe BSMS - Système de gestion d'infrastructure bancaire**
*Version actuelle : 1.0 - Dernière mise à jour : Septembre 2025*
