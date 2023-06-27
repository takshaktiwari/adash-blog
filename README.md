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

## Components

- `x-ablog-blog:post-gallery`: This will be used to display latest / featured blog in different location for websites.

    **Parameters**

    - **type**: Set if you want to get the `latest` or `featured` posts, default value is `latest`.

    - **limit**: Limit the number of posts, default value is `6`. You can specify your own.

    - **orderBy**: Order post by `random`, `latest` or `oldest`, default value id `latest`.

    - **posts**: You can pass your own queried posts. `posts` needs to be type of _Eloquent Collection_ . All other parameters won't work if posts parameters will be passed.

- `x-ablog-blog:post-card`: This component can be used to show a post card

    **Parameters**

    - **post**: A blog post model will be passed.


### Comments

Comments can be enabled and disabled by toggling the value from config site.php `site.blog.comments`. By disabling the comments, comment section will be removed from blog detail page, latest comments will be removed from blog sidebar and comments management from admin panel

