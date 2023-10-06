# TODOLIST

this repo is the base for the TODOLIST API and the TODOLIST web app

technologies used:

-   PHP 8.0
-   Laravel 8
-   PHP Unit 9
-   Laravel Mix 6
-   Vue 3
-   Bootstrap 5

## Getting Started

Prerequisites:

-   VS Code
-   Docker
-   VS Code "Remote - Containers" extension

This repo utilizes VS Code dev containers to quickstart an dev environment, to start developing clone this repo using (current dev branch is wip-L8)

```bash
git clone -b wip-L8 https://github.com/Kyrpychenko/ToDoList-mbd.git
```

or alternatively, if that fails with some sort of "access denied" or "not found" (also see Known Errors/Bugs, GitHub Authetification)

```bash
git clone -b wip-L8 git@github.com:Kyrpychenko/ToDoList-mbd.git
```

Then open the newly created root folder of the local repo in VS Code. This can be done from the same console using

```bash
cd ToDoList-mbd
code .
```

When opening the cloned repo in VS Code, it will ask to reopen the folder in container, proceed so. If it doesnt ask, use this command using the VS Code command palette: `>open folder in container` to open the root folder of the repo using the dev container.

the first start of the container can take some minutes as all docker images need to be downloaded first.

on first start several things need to be executed, to install php and js dependencies, set the environment and setup the database. This should automatically be executed on container creation. If any of these fail try them manually again starting with the failing command.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

## How to Run

to start the application run the following in two parallel terminals, in order to compile the javascript and to serve the backend:

```bash
npm run watch-poll
```

```bash
php artisan serve
```

after running these commands the backend is available (as should be prompted by VS Code) at `http://localhost:8000`.

the frontend is available at `http://localhost:3000`, port 3000 essentially just proxies request to port 8000, so it requires the backend server to run. the server at port 3000, however, supports auto reload after recompiling, so port 3000 might be more useful for developing, as after every change to the source files the front end is recompiled and the browser is automatically reloaded to reflect the changes, while the server at port 8000 needs to be manually reloaded to reflect the changes (which also can be useful when working on design extensively tho)

### developing the cypress end to end test

the cypress setup is a bit fiddly, since cypress opens an electron window. we need to run an x server on the host were developing for this window to show up.

1. Install VcXsrv from https://sourceforge.net/projects/vcxsrv/ on the Windows host
2. Run VcXsrv's XLaunch program on the host. Use the default settings, but make sure to uncheck Native opengl and check Disable access control

in order for this to work the dev container needs to have the following env options:

```json
    "containerEnv": {
        "DISPLAY": "host.docker.internal:0.0",
        "LIBGL_ALWAYS_INDIRECT": "0"
    }
```

adapted from: https://github.com/cypress-io/cypress-documentation/issues/2956#issuecomment-704115471

## Dev Setup Debugging

generally the setup for development is just the automized creation of 2 docker containers, for which the configuration can be found in `.devcontainer`. the main part for setting up the php/npm container can be found in `.devcontainer/Dockerfile`, all commands found there must succeed for the container to properly start. so a first debugging step, after looking at the docker build logs of course, is to comment out the `RUN` commands, try to start the dev container with less commands, and running the commands one by one manually.

### Xdebug

using the run configuration "Listen for XDebug" in VS Code the Laravel application can be debugged. Breakpoints in .php files can be set, and currently active requests can be seen, inside blade files, however, breakpoints dont work.

## Known Errors/Bugs

### GitHub Authetification

On windows the authentification just works, given the GitHub account one is logged in with has access rights to the SportButlerAPI repo. On Mac it doesnt seem to work automatically (which might also depend on the way of cloning the repo, SSH vs HTTPS). If the Repo is accessed through SSH one can create new SSH keys by running `ssh-keygen` leaving everything at its default by pressing enter a few times. the SSH public key, which can be printed in the console by running `cat ~/.ssh/id_rsa.pub` then needs to be added to your personal GitHub account (which must have access to MBDTeam/SportButlerAPI). This can be done on the GitHub Page at `Settings > SSH and GPG keys > New SSH Key`.

### Xdebug

when running in the container `Xdebug: [Step Debug] Could not connect to debugging client. Tried: localhost:9000 (through xdebug.client_host/xdebug.client_port) :-(` is thrown constantly, this happends while the Xdebug client in VS Code is not running, when not debugging this message can be ignored.

## Misc

git branch graphing "git adog"

```bash
git log --all --decorate --oneline --graph
git config --global alias.adog "log --all --decorate --oneline --graph"
git adog
```
