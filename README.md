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

    - **categories**: If you want to show posts from specific categories, please pass the id / name / slug within the array, default value is `[]`.

- `x-ablog-blog:post-card`: This component can be used to show a post card

    **Parameters**

    - **post**: A blog post model will be passed.

- `x-ablog-blog:sidebar`: Add sidebar to any page with search box, categories, posts, comments, etc.

    **Parameters**

    - **search**: Show the search widget in search box, default value is `true`.

    - **categories**: If you want to see the categories list in sidebar. Pass the number of categories to be shown, if you don't want to show this widget please pass `0`, default value is `8`.

    - **featuredPosts**: Show the featured posts, the limit will be 8 but if you want to disable please pass `0`, default value is `8`.

    - **featuredCategories**: Show the featured posts only from some specific categories. This will be an array which will contain list of, id / name / slug, default value is `[]`.
    

    - **latestCategories**: Show the latest posts, the limit will be 8 but if you want to disable please pass `0`, default value is `8`.

    - **latestPosts**: Show the latests posts only from some specific categories. This will be an array which will contain list of, id / name / slug, default value is `[]`.

    - **recentComments**: Show comments in sidebar if want to disable pass `0` or mention number of comments to be shown, default value is `4`.

    - **sectionCategories**: You can pass the list of categories (id / name / slug), which will be shown in the sidebar with some posts as different widgets, default value is `[]`.

    - **sectionCategoriesPosts**: specify the number of posts to be shown in sectioned categories, default value is `latest`.


### Comments

Comments can be enabled and disabled by toggling the value from config site.php `site.blog.comments`. By disabling the comments, comment section will be removed from blog detail page, latest comments will be removed from blog sidebar and comments management from admin panel

