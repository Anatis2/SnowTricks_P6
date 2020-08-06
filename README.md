# SnowTricks_P6

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c5f0556642de4e68855bad1c9920f6fa)](https://app.codacy.com/manual/Anatis2/SnowTricks_P6?utm_source=github.com&utm_medium=referral&utm_content=Anatis2/SnowTricks_P6&utm_campaign=Badge_Grade_Dashboard)

Site communautaire pour l'apprentissage du snowboard (projet 6 du parcours de développeur d'applications PHP/Symfony de OpenClassrooms)


Etapes d'installation
========================

1) Installez les librairies, en tapant la commande "php bin/console composer install"

2) Si besoin, modifiez les données de configuration du .env (notamment le nom d'utilisateur et le mot de passe, dans DATABASE_URL)

3) Créez la base de données, en tapant la commande "php bin/console doctrine:database:create"

4) Créez le schéma de la base de données, grâce à la commande "php bin/console make:migration"

5) Insérez les données de test, avec la commande "php bin/console doctrine:fixtures:load"


Informations de connexion pour faire des tests
=================================================

1) Compte administrateur :
     * Login : admin@admin.fr
     * Mot de passe : admin
     
2) Comptes utilisateur :
     * Login de l'utilisateur 1 : user@user.fr
     * Mot de passe de l'utilisateur 1 : user
     
     * Login de l'utilisateur 2 : user2@user2.fr
     * Mot de passe de l'utilisateur 2 : user2
     
     