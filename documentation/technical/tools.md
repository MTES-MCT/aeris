# Tools

## PHP

We use PHP7 and [composer](getcomposer.org) for dependency management.

## JS

We use [Encore](http://symfony.com/doc/current/frontend.html) for dependency management and building JS/CSS. It requires node and yarn. See app/webpack.config.js

```bash
$ yarn run encore
```

You can build the assets for dev and production with the following parameters:

```bash
$ yarn run encore dev --watch
$ yarn run encore sproduction
```

## CSS

## Python

fabric is used for [deployment](deployment.md), see the dedicated documentation.
