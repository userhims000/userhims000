# Rokit v2.0.0

Rokit is the front-end startup kit we use at Rodesk to build websites. Rokit will help you build better websites faster than ever.

## Requirements

| Prerequisite    | How to check | How to install                                      |
| --------------- | ------------ | --------------------------------------------------- |
| PHP >= 5.4.x    | `php -v`     | [php.net](http://php.net/manual/en/install.php)     |
| Node.js 0.12.x  | `node -v`    | [nodejs.org](http://nodejs.org/) (Or with Homebrew) |
| gulp >= 3.8.10  | `gulp -v`    | `npm install -g gulp`                               |
| Bower >= 1.3.12 | `bower -v`   | `npm install -g bower`                              |

## Features

-   [Gulp](http://gulpjs.com/) task runner
-   [Autoprefixer](https://github.com/postcss/autoprefixer)
-   [BrowserSync](http://www.browsersync.io/)
-   [Bower](http://bower.io/) Bower package managment
-   [Asset builder](https://github.com/austinpray/asset-builder)
-   [Sketch sync (with sketchtool)](http://bohemiancoding.com/sketch/tool/)

## Quick start

### Latest version of NPM

Working with Rokit requires node.js. We recommend you update to the latest version of npm. Do this with the NPM update command, or use Homebrew to update your node installation.

With NPM

```
npm install -g npm@latest.
```

With Homebrew

```
brew update && brew upgrade node
```

### Install Gulp and Bower (Globally)

Install Gulp

```
npm install -g gulp
```

Install Bower

```
npm install -g bower
```

### Install node_modules and Bower components

Install node_modules

```
npm install
```

Install Bower components

```
bower install
```

## Registred Gulp tasks

### Complete task summary

Run `gulp -T` for a task summary with all tasks or check the main workflow tasks

### Main workflow tasks

-   `gulp` — First run build and then watch task
-   `gulp watch` — Watch changes and compile assets when file changes are made
-   `gulp build` — Compile assets.
-   `gulp build --production` — Compile assets for production (no source maps, assets revisioning).

## Authors

Rokit is created and mainained at [Rodesk](http://rodesk.nl) in Rotterdam.

-   Jasper Rooduijn <jasper.r@rodesk.nl>
-   Tom Harms <tom.harms@rodesk.nl>

## Licence

[MIT Licence](http://opensource.org/licenses/mit-license.php).

## Inspiration

Rokit is inspired on several different kits around the web. See the list below for more information

-   [HTML5 Boilerplate](https://github.com/h5bp/html5-boilerplate)
-   [Sage](https://github.com/roots/sage)
-   [Mobile Detect](https://github.com/serbanghita/Mobile-Detect)
-   [Altair](https://github.com/studiodumbar/altair)
-   [ITCSS](http://itcss.io/)
