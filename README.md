# My Official Website 👊

This project is built with a [PHP] based PSR complaint framework [Biurad], a high performance framework with expressive, elegant syntax, and great security which was bootstrapped using [Composer].

> :rocket: `master` is automatically deployed to [demo.biurad.studio]

## 🔰 Introduction

This project was is designed with [Biurad] [PHP] framework to provide modern and rapid development to our project, focusing on `Separation of Concerns`, and not a strict complaint framework rule (eg: MVC). With [Biurad] you enjoy maximum customization, and overall flexibility with no limitations. [Biurad] is fast, light, secure and flexible.

## 🔥 Features

-   [PSR-4 Autoloader](https://github.com/composer/composer).
-   [Biurad PHP Framework](https://github.com/biurad/php-sdk).
-   [A Full PSR Http Manager](https://github.com/biurad/http-galaxy).
-   [High Performance Http Router](https://github.com/divineniiquaye/flight-routing).
-   [Nette Dependency Injection Container](https://github.com/nette/di).
-   [Multi Level Caching with Doctrine Cache](https://github.com/biurad/php-cache).
-   Managed servers:
    -   fpm/fastcgi with Apache or nginX.
    -   [Workerman](https://github.com/biurad/php-workerman) - (coming soon).
    -   [Swoole](https://github.com/biurad/php-swoole) - (coming soon).
    -   [Roadrunner](https://github.com/biurad/php-roadrunner) - (coming soon).
-   And MORE ...


## 📦 Getting Started & Installation

For getting started with this project or contributing, you have to follow the below procedure. First navigate to the main directory. Then run below command for getting started with specific part.

```sh
git clone https://github.com/biurad/php-framework.git
cd php-framework

composer install
```

OR

```sh
composer create-project biurad/php-framework my_project
```

Runs the app in the development mode.<br />
Open [http://localhost:8000](http://localhost:8000) to view it in the browser.

```sh
composer serve
```

> Before running `composer serve`, cd into your project directory then run the script

## 📓 Documentation

For in-depth documentation before using this library. Full documentation on advanced usage, configuration, and customization can be found at [docs.biurad.com](https://docs.biurad.com).

## ⏫ Upgrading

Information on how to upgrade to newer versions of this library can be found in the [UPGRADE].

## 🏷️ Changelog

[SemVer](http://semver.org/) is followed closely. Minor and patch releases should not introduce breaking changes to the codebase; See [CHANGELOG] for more information on what has changed recently.

## 🛠️ Maintenance & Support

When a new **major** version is released (`1.0`, `2.0`, etc), the previous one (`0.19.x`) will receive bug fixes for _at least_ 3 months and security updates for 6 months after that new release comes out.

(This policy may change in the future and exceptions may be made on a case-by-case basis.)

**Professional support, including notification of new releases and security updates, is available at [Biurad Commits][commit].**

## 👷‍♀️ Contributing

To report a security vulnerability, please use the [Biurad Security](https://security.biurad.com). We will coordinate the fix and eventually commit the solution in this project.

Contributions to this library are **welcome**, especially ones that:

- Improve usability or flexibility without compromising our ability to adhere to [React].
- Optimize performance
- Fix issues with code and backward compatability.

Please see [CONTRIBUTING] for additional details.

## 🧪 Testing

To run the tests you'll have to start the included node based server first if any in a separate terminal window.

With the server running, you can start testing.

```bash
composer test
```

## 👥 Credits & Acknowledgements

- [Divine Niiquaye Ibok][@divineniiquaye]
- [All Contributors][]

## 🙌 Sponsors

Are you interested in sponsoring development of this project? Reach out and support us on [Patreon](https://www.patreon.com/biurad) or see <https://biurad.com/sponsor> for a list of ways to contribute.

## 📄 License

**biurad/php-framework** is licensed under the BSD-3 license. See the [`LICENSE`](LICENSE) file for more details.

[@divineniiquaye]: https://github.com/divineniiquaye
[commit]: https://commits.biurad.com/php-framework.git
[UPGRADE]: UPGRADE.md
[CHANGELOG]: CHANGELOG.md
[CONTRIBUTING]: ./.github/CONTRIBUTING.md
[All Contributors]: https://github.com/divineniiquaye/php-framework/contributors
[Biurad Lap]: https://team.biurad.com
[email]: support@biurad.com
[message]: https://biurad.com/#contact
[Biurad]: https://framework.biurad.com/php/
[PHP]: https://php.net
[Composer]: https://getcomposer.org/
