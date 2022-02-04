# Installation

# Créationn d'une nouvelle application symfony (skelette)
-  symfony new _nameproject --full
 # ou une application symfony
 symfony new --webapp my_project
 # ou un service (api)
 symfony new my_project
 # ou  l'outil composer
 composer create-project symfony/skeleton my_project_directory
    cd my_project_directory
    composer require webapp

## / _nameproject
# Instalation de webpack avec symfony (dans le _nameproject)
- composer require symfonyebpack-encore-bundle

# Installer les commande js du projet
- npm install

# Télécharger bootstrap 
# changer les type de fichier css en scss et c'est tout aussi important de modifier le chemin que donne le  webpackconfig (css -scss) désactiver le commentaire enableSassLoader() , et l'importation des app.js . 

# loader scss de webpack
- npm install sass-loader@9.0.1 -node-sass --save-dev         