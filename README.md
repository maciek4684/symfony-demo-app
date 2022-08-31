# The purpose of this repository

This repository is an example of the PHP/Symfony/Programming features I use as a Symfony developer.  
I am allowed to present an excerpt from the codebase of the application that was created
to help students learning programming concepts.

## Tech stack

This is a Symfony project with the following components:

* Symfony 6.1
* PHP 8.1
* Caddy server
* Docker
* PostgreSQL

## Symfony features

This project uses the following Symfony features:

* API Platform (core features of the system are also available via API access)
* Messenger (testing student submissions is managed asynchronously, solutions are added to the queue and processed by workers)
* Doctrine
* Twig/JQuery
* EasyAdmin (configured for admin access)
* Translations (3 languages: German, English and Polish)
* Fixtures
* Voters
* Authenticators
  * Login form (online app) 
  * Api token (api access)

## Programming concepts

* CQRS pattern: asynchronously processing of student submissions using Messenger
* Strategy pattern: multiple strategies for evaluation of student submissions, depending on a type of submission
  (examples: code in a browser IDE, uploaded text file with code, uploaded .zip file with code, .zip code for executing in docker containers)
  or a code language (Java, C#, Python)
* DTO's/Data transformers for processing in/out API communication
* Events
    * Dispatching events
    * Event listener
    * Event subscribers

## Application provides:

* Web access: where users can log in and access programming tasks using the online IDE
* REST API access: with the purpose of enabling users the communication directly from the local IDE

# How to start

Download the code in this repository.

## Update th hosts file

The default host name for this application exposed by the Caddy server is `demo.local`. Certificates 
are issued for the host name, so pay attention to this part of the configuration.

The host name is defined in `.env` file, feel free to adjust to your requirements. If you are running docker 
containers on your (local) machine, you can change the host name to `localhost`.

The host name may be changed later, rebuild will not be necessary. You may change it any time.

Modify the `/ect/hosts` (Linux) `C:\Windows\System32\drivers\etc` (Windows) hosts file by adding the 

`x.x.x.x demo.local` 

(or your preferred name) line, where x.x.x.x is the IP number of the machine on which
you started docker containers - it may be 127.0.0.1, if running on local machine or any other IP, if running
on an external (virtual) machine.

You should be able to see how this application works by executing:

1. `docker compose build` to build or `docker compose build --pull --no-cache` to build fresh images
2. `docker compose up` to start the application
3. Open `https://demo.local` (or your preferred name) and accept certificate to use the application (this app uses https by default)

## App users

There are 3 users defined:

1. Email: `admin@example.com` password: `P@ssw0rd` API token: `admintoken`
2. Email: `user1@example.com` password: `pass1` API token: `user1token`
3. Email: `user2@example.com` password: `pass2` API token: `user2token`

API access `/api` is available for each of these users with token authorization. Use provided tokens or generate a new one using the admin panel.

# Learn to code with a hands-on experience

This repository is an excerpt of a deployed application created to help students 
learning programming concepts.

## This Symfony projects uses the dunglas/docker repository

Read [Symfony Docker](docker.md)
