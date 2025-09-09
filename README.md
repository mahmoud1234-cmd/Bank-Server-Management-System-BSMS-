# 🏦 BSMS - Bank Server Management System

Une application Laravel complète pour la gestion des serveurs bancaires, conçue pour l'équipe IT de la banque.

## 🎯 Fonctionnalités Principales

### 1. Gestion des Serveurs
- ✅ Ajouter, modifier et supprimer des serveurs
- ✅ Attributs complets : nom, IP, OS, rôle, emplacement, propriétaire, état
- ✅ Niveaux de criticité (low, medium, high, critical)
- ✅ Environnements (production, staging, development, testing)
- ✅ Spécifications techniques détaillées
- ✅ Association aux datacenters

### 2. Gestion des Utilisateurs
- ✅ Authentification Laravel Breeze
- ✅ Rôles et permissions (Admin, Technicien, Auditeur, Manager)
- ✅ Attribution des serveurs aux utilisateurs
- ✅ Gestion des départements et contacts

### 3. Suivi des Incidents & Maintenances
- ✅ Journal des pannes avec suivi complet
- ✅ Planification de maintenances préventives
- ✅ Suivi en temps réel (ouvert, en cours, résolu)
- ✅ Mises à jour d'incidents avec historique
- ✅ Assignation aux techniciens

### 4. Audit et Traçabilité
- ✅ Historique complet des connexions utilisateurs
- ✅ Logs détaillés de toutes les actions
- ✅ Export PDF/Excel pour conformité bancaire
- ✅ Traçabilité des modifications

### 5. Tableau de Bord Avancé
- ✅ Statistiques en temps réel
- ✅ Graphiques et visualisations
- ✅ Alertes automatiques
- ✅ Vue d'ensemble des serveurs critiques
- ✅ Performance des techniciens

## 🏗️ Architecture Technique

### Modèles Principaux
- **Server** : Gestion complète des serveurs
- **User** : Utilisateurs avec rôles et permissions
- **Incident** : Gestion des incidents et pannes
- **MaintenanceTask** : Tâches de maintenance préventive
- **Datacenter** : Gestion des centres de données
- **AuditLog** : Traçabilité et audit
- **IncidentUpdate** : Mises à jour d'incidents

### Base de Données
- **12 serveurs** de test avec différents états
- **3 datacenters** (Principal, Secondaire, Développement)
- **8 utilisateurs** avec différents rôles
- **Relations complètes** entre toutes les entités

## 🚀 Installation

### Prérequis
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js (pour les assets)

### Installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd BSMS
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**
```bash
# Modifier .env avec vos paramètres de base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bank_servers
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migration et seeding**
```bash
php artisan migrate:fresh --seed
```

6. **Compilation des assets**
```bash
npm run build
```

7. **Démarrer le serveur**
```bash
php artisan serve
```

## 👥 Utilisateurs de Test

| Email | Mot de passe | Rôle | Département |
|-------|-------------|------|-------------|
| admin@banque.fr | password | Admin | IT Management |
| tech.senior@banque.fr | password | Technicien | Infrastructure |
| tech.junior@banque.fr | password | Technicien | Infrastructure |
| manager@banque.fr | password | Manager | IT Management |
| auditor@banque.fr | password | Auditeur | Audit & Compliance |
| network@banque.fr | password | Technicien | Réseau |
| security@banque.fr | password | Technicien | Sécurité |
| dc.manager@banque.fr | password | Manager | Datacenter |

## 📊 Données de Test

### Serveurs Créés
- **SRV-DB-PRINCIPAL** : Base de données principale (critique)
- **SRV-APP-WEB** : Application web principale (critique)
- **SRV-SECURITY-FW** : Firewall principal (critique)
- **SRV-BACKUP-STORAGE** : Stockage de sauvegarde (élevé)
- **SRV-DB-SECONDAIRE** : Base de données secondaire (critique)
- **SRV-APP-WEB-SEC** : Application web secondaire (élevé)
- **SRV-MONITORING** : Serveur de monitoring (maintenance)
- **SRV-LEGACY-APP** : Application legacy (hors service)
- **SRV-DEV-WEB** : Serveur de développement
- **SRV-TEST-DB** : Base de données de test
- **SRV-AD-DOMAIN** : Contrôleur de domaine AD
- **SRV-EXCHANGE** : Serveur Exchange

### Datacenters
- **Datacenter Principal** : Paris (500 serveurs, sécurité critique)
- **Datacenter Secondaire** : Lyon (300 serveurs, sécurité élevée)
- **Datacenter de Développement** : Marseille (100 serveurs, sécurité moyenne)

## 🔐 Sécurité et Conformité

### Rôles et Permissions
- **Admin** : Accès complet à toutes les fonctionnalités
- **Manager** : Gestion des équipes et rapports
- **Technicien** : Gestion des serveurs et incidents
- **Auditeur** : Consultation et export des données

### Audit Trail
- Toutes les actions sont loggées
- Traçabilité complète des modifications
- Export pour conformité bancaire
- Historique des connexions

## 📈 Tableau de Bord

### Statistiques en Temps Réel
- Nombre total de serveurs
- Pourcentage de serveurs en panne
- Incidents ouverts et critiques
- Tâches de maintenance planifiées

### Visualisations
- Répartition par système d'exploitation
- Répartition par rôle
- Évolution des incidents (30 derniers jours)
- Planification des maintenances (30 prochains jours)

### Alertes Automatiques
- Serveurs critiques en panne
- Incidents critiques non assignés
- Maintenances en retard
- Actualisation toutes les 30 secondes

## 🔧 API Endpoints

### Dashboard
- `GET /dashboard` - Tableau de bord principal
- `GET /dashboard/chart-data` - Données pour graphiques
- `GET /dashboard/alerts` - Alertes en temps réel

### Serveurs
- `GET /servers` - Liste des serveurs
- `POST /servers` - Créer un serveur
- `GET /servers/{id}` - Détails d'un serveur
- `PUT /servers/{id}` - Modifier un serveur
- `DELETE /servers/{id}` - Supprimer un serveur

### Incidents
- `GET /incidents` - Liste des incidents
- `POST /incidents` - Créer un incident
- `POST /incidents/{id}/assign` - Assigner un incident
- `POST /incidents/{id}/update-status` - Mettre à jour le statut

### Maintenance
- `GET /maintenance-tasks` - Liste des tâches
- `POST /maintenance-tasks` - Créer une tâche
- `POST /maintenance-tasks/{id}/approve` - Approuver une tâche
- `POST /maintenance-tasks/{id}/complete` - Terminer une tâche

## 📋 Fonctionnalités Avancées

### Gestion des Incidents
- Catégorisation (hardware, software, network, security, etc.)
- Niveaux de sévérité (low, medium, high, critical)
- Priorités (low, medium, high, urgent)
- Impact sur les services
- Cause racine et mesures préventives

### Maintenance Préventive
- Types de maintenance (preventive, corrective, emergency, etc.)
- Fenêtres de maintenance
- Approbations requises
- Checklists de tâches
- Suivi des durées

### Rapports et Exports
- Rapports de serveurs
- Rapports d'incidents
- Rapports de maintenance
- Logs d'audit
- Export PDF/Excel

## 🎨 Interface Utilisateur

### Design Moderne
- Interface responsive avec Tailwind CSS
- Mode sombre/clair
- Composants réutilisables
- Navigation intuitive

### Expérience Utilisateur
- Actions rapides depuis le dashboard
- Filtres et recherche avancés
- Notifications en temps réel
- Formulaires optimisés

## 🔄 Workflow Typique

1. **Surveillance** : Le dashboard affiche l'état des serveurs en temps réel
2. **Détection** : Un incident est détecté ou déclaré
3. **Assignation** : L'incident est assigné à un technicien
4. **Résolution** : Le technicien met à jour le statut et résout l'incident
5. **Audit** : Toutes les actions sont tracées pour la conformité

## 📝 Conformité Bancaire

### Exigences Répondues
- ✅ Traçabilité complète des actions
- ✅ Gestion des accès utilisateurs
- ✅ Historique des modifications
- ✅ Rapports d'audit
- ✅ Export des données
- ✅ Sécurité des données

### Standards
- Conformité aux standards bancaires
- Audit trail complet
- Gestion des permissions granulaires
- Sauvegarde et récupération

## 🚀 Déploiement

### Production
```bash
# Optimisation pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### Environnement
- Configuration par environnement
- Variables d'environnement sécurisées
- Logs d'erreurs
- Monitoring des performances

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📞 Support

Pour toute question ou support :
- Email : support@banque.fr
- Documentation : `/docs`
- Issues : GitHub Issues

---

**BSMS** - Une solution complète pour la gestion des serveurs bancaires 🏦
