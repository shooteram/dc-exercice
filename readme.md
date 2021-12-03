## derniercri.io / exercice

### Getting started
```shell
$ git clone git@github.com:shooteram/dc-exercice.git
$ cd cdn
$ composer install
```

### Commands
There is a command to fetch and save the news in the database
```shell
$ php bin/console app:import-news
```

### Front
It was a requirement to choose between Vue and React; for this project, I chose React.

The previously saved news articles are now available under our very own symfony instance which makes it easier to deal with potential issues regarding distant servers' latency, uptime sla, cors, quota; plus, it let us format data how we want.

Overall, it's just less cumbersome to use the same origin for our api calls.

### API
The API I'm using is from [newsapi.org](https://newsapi.org)

It has a free tier: a hundred requests per day; which is far more than enough since I'm caching each request for an hour.

The only downside is that they do not provide the complete content of the fetched news.
