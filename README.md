# CTRNF Sheet

## Introduction

CTRNF Sheet is a web application planned to be used as a desktop application.

If you are a player of Crash Team Racing: Nitro-Fueled, it allows you to list all your best times.

Here's the list of the features (v0.1.0):

- Store your best time (with the times of the 3 seperated laps if wanted), your best lap and your best first lap on each track.
- Store your console rank on each track and tell if your objective has been attained.
- Show and tell if you beat N. Tropy's and Oxide's times on each track.
- Calculate your best theoric time based on your best lap and best first lap on each track, with how far your best time is.
- Search and tell how far your best time and best lap are from the world records (taken from [crashteamracing.com](https://crashteamracing.com)).
- Show or hide any column you want from the table.
- Switch between english and french translations.

## Usage on a local web server

- Download or clone this repository in the corresponding directory.
- Update composer packages.
   - `composer update`
- Update npm packages.
   - `npm update`
- Launch it.

## Usage on desktop

The desktop version uses [cztomczak/phpdesktop](https://github.com/cztomczak/phpdesktop).

- Download the latest release desktop archive.
- Extract its content in the directory you want.
- Start `ctrnf-sheet.exe`.

## Used libraries

### From composer

- [symfony/var-dumper](https://github.com/symfony/var-dumper)
- [softius/php-cross-domain-proxy](https://github.com/softius/php-cross-domain-proxy)

### From NPM

- [axios/axios](https://github.com/axios/axios)

## Notes

No framework have been used, all of the code have been done from scratch.

As this application is destined to be used as a desktop one, security issues have not been checked. No distant server is related, the app uses a local SQLite database.