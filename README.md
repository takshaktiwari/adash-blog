# Introduction

An extension for blog post for `takshak/adash` package. Get your blog ready in just couple of minutes, just follow the simple steps.

## Installation

Require the package with composer

    composer require takshak/adash-blog


Run the command to setup the table, pages, models and all

    php artisan adash-blog:install

---

After running the above command, routes will be published to both sides in admin and front routes in admin.php and web.php respectively. Tables will be migrated and seeded as well.
Default configuration file used by Adash (site.php) will be used by this blog as well.
