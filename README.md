# 📱 StageFlow Mobile

**StageFlow Mobile** est l'application native (Android) qui accompagne la prestigieuse plateforme de recrutement et de gestion de stages **StageFlow**. 

Ce projet est développé avec **Laravel** et propulsé par le package expérimental **NativePHP Mobile (v3)**, permettant d'embarquer l'application directement dans un émulateur mobile avec un rendu d'une application native, le tout en exploitant les technologies Web.

---

## 🎯 Architecture et Concepts

Afin de respecter les standards de l'industrie (Architecture Orientée Services / *Separation of Concerns*), ce projet mobile est totalement découplé de l'application Web initiale. 

- **Le Backend (Cerveau)** : Il est hébergé sur un dépôt séparé. Il gère la base de données, la logique complexe (authentification, création), et expose des routes API RESTful.
- **Le Frontend Mobile (Ce projet)** : Il ne possède aucune base de données locale. Ses contrôleurs interrogent l'API Web distante en temps réel via la façade `Http` de Laravel pour afficher les données.

---

## ✨ Fonctionnalités : Expérience "Lecture Seule"

Conformément au cahier des charges mobile, ce projet offre une expérience de consultation fluide (Read-Only) et centralise les données essentielles pour l'étudiant en déplacement :

* 🏠 **Accueil Dynamique** : Statistiques globales de la plateforme et témoignages récupérés via API.
* 💼 **Recherche d'Offres (Exploration)** : Liste complète des opportunités de stages avec description détaillée des postes.
* 📊 **Tableau de Bord Étudiant** : Vue d'ensemble récapitulative de l'activité du candidat une fois son ID renseigné.
* 📋 **Suivi des Candidatures** : Consultation du tunnel de candidature et du statut des offres postulées depuis le Web.

---

## 🛠️ Stack Technique

* **Framework Base** : Laravel 12.x
* **Encapsulation Mobile** : NativePHP / Mobile (v3)
* **Interface Utilisateur** : Preline + TailwindCSS (Vite) + Laravel Blade
* **Communication** : Requêtes HTTP JSON (`Illuminate\Support\Facades\Http`)

---

## 🚀 Installation et Déploiement

### 1. Prérequis Système
* PHP 8.2+
* Composer & NPM
* Android Studio (SDK v33+ et un Émulateur Android configuré)
* **Le projet Backend (`stage_flow` API) allumé simultanément sur le port 8000.**

### 2. Procédure Globale

```bash
# 1. Cloner et entrer dans le dossier
git clone <URL_DE_TON_DEPOT_GITHUB> stage_flow_mobile
cd stage_flow_app

# 2. Installer les dépendances
composer install
npm install

# 3. Installer le module mobile experiental
composer require nativephp/mobile
