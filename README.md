# Yii2-user-purse

[![Build Status](https://travis-ci.org/jarrus90/yii2-user-purse.svg?branch=master)](https://travis-ci.org/jarrus90/yii2-user-purse)

> **NOTE:** Module is in initial development. Anything may change at any time.

## Contributing to this project

Anyone and everyone is welcome to contribute. Please take a moment to review the [guidelines for contributing](CONTRIBUTING.md).

## License

Yii2-user-purse is released under the BSD-3-Clause License. See the bundled [LICENSE.md](LICENSE.md) for details.

##Requirements

YII 2.0

##Usage

1) Install with Composer

~~~php

"require": {
    "jarrus90/yii2-user-purse": "1.*",
},

php composer.phar update

~~~


## Restrict and split frontend and backend applications

```
'modules' => [
    'user-purse' => [
        'as frontend' => 'jarrus90\UserPurse\filters\FrontendFilter',
    ],
],
```
```
'modules' => [
    'user-purse' => [
        'as backend' => 'jarrus90\UserPurse\filters\BackendFilter',
    ],
],
```