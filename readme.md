## derniercri.io / exercice

### Getting started
```shell
$ git clone git@github.com:shooteram/dc-exercice.git
$ cd cdn
$ composer install
```

### Notes

#### API
The API I'm using is from [newsapi.org](https://newsapi.org)

It has a free tier: a hundred requests per day; which is far more than enough since I'm caching each request for an hour.

The only downside is that they do not provide the complete content of the fetched news.

#### Commands
There is a command to fetch and save the news in the database
```shell
$ php bin/console app:import-news
```
