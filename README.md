# Diplomová práce

### Version
1.0.0

### Description
devstack including:
* [Webpack](https://webpack.github.io/) a module bundler
* [Gulp](http://gulpjs.com/) a JavaScript task manager
* [Babel](https://babeljs.io/) a JavaScript compiler
* [Pug](http://jade-lang.com/) a HTML template engine
* [Sass](http://sass-lang.com/) a css preprocessor

### Installation
```sh
$ git clone https://Mansfield92@bitbucket.org/Mansfield92/diplomovaprace.git
```
and
```
$ npm i
```
or
```
$ yarn
```

### Development
```sh
$ gulp
```

### Production
```sh
$ gulp build
```

## Instalační příručka

### Pro úspěšné spuštění dynamické je zapotřebí softwarového vybavení:
* Server Apache s podporou PHP 7
* Databáze MySQL

Na macOS je vhodné použít kompletní balík s názvem MAMP, který obsahuje Apache
s podporou PHP 7 i MySQL databázi. DocumentRoot musí ukazovat na složku „web“. Soubor
s daty pro MySQL databázi se nachází ve složce „sql“. Po importu databáze je potřeba ještě
upravit konfiguraci souboru „web/include/config.db.php” s odpovídajícím názvem databáze,
uživatelem a heslem.

Jelikož v zadání této práce bylo mimo jiné dostupnost této aplikace na heroku.com, můžete
instalaci přeskočit a aplikaci si vyzkoušet přímo na dostupné adrese.

* Adresa - http://vomacko-petr.herokuapp.com/
* Uživatel admin - jméno „admin“, heslo „1234“. Má práva spravovat jiné uživatele
* Uživatel user – jméno „user“ heslo „1234“.

### Instalace a spuštění frontend části.

Po stažení zdrojových kódů je nutné spustit v projektu příkaz „npm install“ nebo „yarn“. Dojde
k instalaci všech balíčků a závislostí. Poté stači do terminálu napsat klíčové slovo „gulp“, které
spustí Browsersync server a připraví sledování souborů pro kompilaci. Pro vyzkoušení vývoje
stačí ve složce „frontend“ upravit soubor s koncovkou „sass“, „js“ nebo „pug“, což povede ke
kompilaci příslušného souboru do verze podporované prohlížečem.
