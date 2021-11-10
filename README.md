Bolt 5 - The Elephpant Experience
================================

Hello. This is an example repository on how to build widgets and overall use Bolt CMS for developers.



### Handy information

Set up the database, create the first user and add fixtures (dummy content):

```bash
bin/console bolt:setup
```

Run Bolt using the built-in webserver, Symfony CLI, Docker or your own
preferred webserver:

```bash
bin/console server:start
```

or…

```bash
symfony server:start -d
symfony open:local
```

Finally, open the new installation in a browser. If you've used one of the
commands above, you'll find the frontpage at http://127.0.0.1:8000/ \
The Bolt admin panel can be found at http://127.0.0.1:8000/bolt

Log in using the credentials you created when setting up the first user.