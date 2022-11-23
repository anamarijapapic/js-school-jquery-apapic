*README.md note:*

1. Search and replace `{{ TO-DO }}` with appropriate content.
2. Delete this note.

# About this repo

This repo contains the complete source code for the {{ TO-DO }} website as well as all the necessary tools for development.

# Getting started

## Requirements

You should have the following installed with respective minimal versions:

- [Docker](https://www.docker.com/community-edition) 18.06 bundled with docker-compose
- [NodeJS](https://nodejs.org/en/) 8.x LTS bundled with npm
- [PHP Composer](https://getcomposer.org/download/) 1.7

## Getting started

1. Install and update all the requirements above
2. Clone the repo: `git clone {{ TO-DO }}`
3. Copy `.env.example` to `.env` and edit config if needed
4. Install all JS dependencies by running: `npm install`
5. Append the line `127.0.0.1    {{ TO-DO }}.test` to your `/etc/hosts` file
6. Generate your local certificate by running: `npm run addcert`
7. Do a initial build of the website by running: `npm run build:wordpress`
8. Build and start the local web server for the first time: `docker-compose up`
9. Open [https://{{ TO-DO }}.test/](https://{{ TO-DO }}.test/) in your browser
10. Work with the code in the `src` directory.

# Working with the dev environment

## About

The dev environment is powered by [Docker](https://www.docker.com/community-edition), running in whatever flavour is supported by your OS. The docker containers provide a full stack of services (Nginx, PHP-FPM, MySQL) needed to run the website.
A set of NodeJS based build tools handles assembling a full WordPress install with the help of [Composer](https://getcomposer.org) which manages third party WP plugins via [WPackagist](http://wpackagist.org).

### Directory layout

- `bin` various scripts and tooling
- `db` a recent, gziped copy of the database that acts as a seed the first time you build your DB container
- `docker` container configuration and temp files
- `src` site code, this is where most of the work is done
- `src\html` frontend markup, this is the artifact of the HTML cutup phase and mostly used by FE folks to implement changes
- `src\wp-content` is where our WordPress related code lives
- `public` a build of the site, this gets recreated every time you run a build and its what the web server sees
- `shared` non-versioned files that are shared between the builds

## Useful Docker Commands

- `docker-compose up` starts the docker environment, you can stop it with a single `cmd/ctrl+c`
- `docker-compose build` re-builds all the containers
- `docker-compose stop` stops containers
- `docker-compose down` stops and removes the containers and their volumes
- `docker ps` lists all running containers on the system, useful to track down ones that are unintentionally keeping the ports used.
Note: All commands must be run at the repo root directory.

## Build

All the build commands are listed in the package.json under the "scripts" section. Commands are run by invoking them via npm, eg. `npm run build:wordpress`.
Some commands are verbose out of the box, while others can be passed a flag to provide more detailed output, eg. `npm run build:wordpress -- --verbose`.
Your editor/IDE might make the commands available through its UI by parsing the package.json. Good example is VSCode with its "Run Task" palette.

### Available NPM commands

- `build` creates a build of html/css/js assets only
- `watch` creates a build of html/css/js assets only and keeps rebuilds when changes are detected
- `build:wordpress` creates a development build of the website in `/public`
- `build:wpengine` produces a deployable production build artifact in `/public`
- `deploy:production` same as above but for production
- `deploy:staging` given the right keys are in place runs the git deploy for staging

## Debugging

Server logging is available through the terminal after you run `docker-compose up`. PHP errors are saved in `public/wp-content/debug.log` which doesn't persist between builds.
You can display extended error messages by finding and setting `WP_DEBUG_DISPLAY` constant to `TRUE` in `wp-config.php` - but avoid committing this change for everyone.
XDebug is also available and is pre configured for VSCode.

## Managing the database

A DB administration tool, [PHPMyAdmin](https://www.phpmyadmin.net), is available at http://localhost:8080/.
You can connect to MySQL yourself using the port `3306` on `localhost` from your host. Username and password is `root`.
There is a seed database in the `db` directory, its loaded when you first start up your environment. If, for some reason, you need to go back to a working database follow these steps:

1. Make sure your containers are not running, eg. by running `docker-compose down`
2. Delete the directory `docker/data`, eg. `rm -rf docker/data`
3. Run the containers again with `docker-compose up --build`

# Working with the site repo

## Configuration

Please configure your git email and username by running `git config user.email "your_email@example.com"` and `git config user.name "somebody@converiv.com"`.
Make sure you use the same email as your BitBucket account that has access to this repo and that your host OS keys are configured on the BitBucket account.

## Feature branching

1. New features and larger fixes require that the developer opens a branch. The branch name needs to be prefixed with the Jira issue KEY.
2. Merging these branches into Master requires a pull request on BitBucket and approval of at least one more dev on the team.

## Hotfixes

Small and quick code fixes can be applied to the master branch directly. All commit messages must be prefixed with the Jira issue KEY.

## Deploying

Deploying is handled by Bitbucket Pipelines. Status of builds and deployments can be monitored through the Bitbucket page of the repo.
Deploying your changes to staging is done by merging your feature branch in and pushing the `staging` branch up to the repo.
Production deployments require a Pull Request to be opened for the merge. Merging the PR is handled through the Bitbucket interface.

## Other repo notes

Make sure you do not mix multiple plugin or theme changes in single commits. Eg. do two commits when changing two plugins or a plugin and a theme.
`master` and `staging` branches are always deployable and stable.
When pushing related changes make sure it gets pushed to the proper branch

## DB handling

A lighter, development, version of the DB is supplied with the repo, under the `db` directory and imported on the first run. This SQL dump is being regenerated on a month-to-month basis unless otherwise called for. Full production dumps can be requested separately.

## Adding/Removing Plugins

First party plugins are located in `src/wp-content/plugins` while third party plugins are being managed by [Composer] and are listed in `composer.json`.
When adding or removing third party plugins make sure to update `composer.json`, these plugins should not exist under `src/wp-content`.

# FAQ

Q: **Initial clone fails with "Permission denied (publickey)."**

A: Make sure you have your public key (usually ~/.ssh/id_rsa.pub) on your BitBucket account. You can set it on your `Manage Account` BitBucket page, under the `Security section`, `SSH keys`. Also check with the repo admin to make sure you have access to the repo.
