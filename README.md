# Eat&Drink - Backend Laravel

Ce projet est le backend de la plateforme Eat&Drink, permettant la gestion des exposants, des stands, des produits et des commandes pour un événement culinaire. Il inclut :
- Authentification et gestion des rôles (admin, entrepreneur, participant)
- Sécurisation des accès (policies, middleware)
- Validation des formulaires et messages d’erreur en français
- Documentation des routes backend (voir ci-dessous)
- Notifications email (log)

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Documentation API Backend

## Authentification

| Méthode | URL           | Description                | Rôle(s)         |
|---------|---------------|----------------------------|-----------------|
| POST    | /login        | Connexion                  | Tous            |
| POST    | /register     | Inscription entrepreneur   | Public          |
| POST    | /logout       | Déconnexion                | Authentifié     |

## Gestion des Stands

| Méthode | URL                | Description                        | Rôle(s)                | Paramètres attendus                |
|---------|--------------------|------------------------------------|------------------------|------------------------------------|
| GET     | /stands            | Liste des stands (perso/admin)     | Admin, Entrepreneur    | -                                  |
| GET     | /stands/create     | Formulaire création stand          | Admin, Entrepreneur    | -                                  |
| POST    | /stands            | Créer un stand                     | Admin, Entrepreneur    | nom_stand, description             |
| GET     | /stands/{id}       | Détail d'un stand                  | Admin, Entrepreneur    | -                                  |
| GET     | /stands/{id}/edit  | Formulaire édition stand           | Admin, Entrepreneur    | -                                  |
| PUT     | /stands/{id}       | Modifier un stand                  | Admin, Entrepreneur    | nom_stand, description             |
| DELETE  | /stands/{id}       | Supprimer un stand                 | Admin, Entrepreneur    | -                                  |

## Gestion des Produits

| Méthode | URL                   | Description                        | Rôle(s)                | Paramètres attendus                |
|---------|-----------------------|------------------------------------|------------------------|------------------------------------|
| GET     | /produits             | Liste des produits                 | Admin, Entrepreneur    | -                                  |
| GET     | /produits/create      | Formulaire création produit        | Admin, Entrepreneur    | -                                  |
| POST    | /produits             | Créer un produit                   | Admin, Entrepreneur    | nom, description, prix, image, stand_id |
| GET     | /produits/{id}        | Détail d'un produit                | Admin, Entrepreneur    | -                                  |
| GET     | /produits/{id}/edit   | Formulaire édition produit         | Admin, Entrepreneur    | -                                  |
| PUT     | /produits/{id}        | Modifier un produit                | Admin, Entrepreneur    | nom, description, prix, image, stand_id |
| DELETE  | /produits/{id}        | Supprimer un produit               | Admin, Entrepreneur    | -                                  |

## Gestion des Commandes

| Méthode | URL                      | Description                        | Rôle(s)                | Paramètres attendus                |
|---------|--------------------------|------------------------------------|------------------------|------------------------------------|
| GET     | /commandes               | Liste des commandes                | Admin, Entrepreneur    | -                                  |
| GET     | /commandes/create        | Formulaire création commande       | Admin, Entrepreneur    | -                                  |
| POST    | /commandes               | Créer une commande                 | Admin, Entrepreneur    | stand_id, produits[], quantites[]  |
| GET     | /commandes/{id}          | Détail d'une commande              | Admin, Entrepreneur    | -                                  |
| GET     | /commandes/{id}/edit     | Formulaire édition commande        | Admin, Entrepreneur    | -                                  |
| PUT     | /commandes/{id}          | Modifier une commande              | Admin, Entrepreneur    | détails_commande, statut, notes    |
| DELETE  | /commandes/{id}          | Supprimer une commande             | Admin, Entrepreneur    | -                                  |

## Gestion des demandes d'entrepreneurs (Admin)

| Méthode | URL                        | Description                        | Rôle(s)      | Paramètres attendus                |
|---------|----------------------------|------------------------------------|--------------|------------------------------------|
| GET     | /admin/demandes            | Liste des demandes en attente      | Admin        | -                                  |
| POST    | /admin/demandes/{id}/statut| Approuver/Rejeter une demande     | Admin        | statut (approuve/rejete), motif    |

## Vitrine publique & commandes visiteurs

| Méthode | URL                        | Description                        | Rôle(s)      | Paramètres attendus                |
|---------|----------------------------|------------------------------------|--------------|------------------------------------|
| GET     | /public/stands             | Liste des stands approuvés         | Public       | -                                  |
| GET     | /public/stands/{id}        | Détail d'un stand                  | Public       | -                                  |
| GET     | /public/produits/search    | Recherche de produits              | Public       | search                            |
| GET     | /public/stats              | Statistiques publiques             | Public       | -                                  |

## Statuts et rôles

- **Rôles** : admin, entrepreneur (en_attente, approuve), participant (public)
- **Statuts de commande** : en_attente, confirmee, en_preparation, livree, annulee

---

**Pour toute question sur un endpoint, voir le contrôleur correspondant dans `app/Http/Controllers/`**
