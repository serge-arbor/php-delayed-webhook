# Delayed Webhook

> Solution for Lemonade Home Assignment built with **PHP and Symfony**

Project Delayed Webhook is util that provides API for scheduling and shooting a delayed webhook

## Task description

[Home Assignment V2 - Timer.pdf](https://github.com/serge-arbor/php-delayed-webhook/blob/master/timer-home-assignment.pdf)

## Table of Contents

- [Overview](#overview)
- [Assumptions and Design decisions](#assumptions-and-design-decisions)
- [Technologies Used](#technologies-used)
- [Features](#features)
- [Setup](#setup)
- [Development](#development)
- [API documentation](#api-documentation)
- [Room for Improvement](#room-for-improvement)
- [Contact](#contact)

## Overview

- This is a showcase implementation. The goal is to demonstrate coding skills with Symfony API best practices, following SOLID and DRY principles
- If that task would be a real-world task - It's no need to build so scalable code structure and to split all the logic into layers. The short-deadline solution would be much smaller
- **_You can check out my [alternative solution to this Home Assignment](https://github.com/serge-arbor/node-delayed-webhook) built with Node.js and TypeScript, which is more laconic and covered by e2e tests_**

## Assumptions and Design decisions

- The application is required to be used in some local environment without any external access, therefore **the authentication is not required**
- The server should fire the webhook after initializing if the server was down, so I use a queue based on [Symfony bus message](https://symfony.com/doc/current/messenger.html) with Redis persistent store
- The workload is not predicted, so queue workers, HTTP API, and storage instances should be scaled independently. For example, **10 http-api + 100 workers**
- There are no requirements to store TBs of data and to have relations between data, to have transactions and complex joins, so **I choose Redis as a store**
- Timer IDs are required to be consecutive natural numbers. It leads to the synchronization between all the HTTP API instances while processing timer creation requests. **This synchronization has been built on top of the Redis' INCR command** and is a bottleneck of the whole system
- **That bottleneck could be eliminated by using UUID** or other kinds of global pseudo-random IDs instead of ordered natural numbers
- There are no requirements for "back off" strategy, so I use **exponential backoff strategy (3 retries: 1s, 2s, 4s)** if the webhook is not reachable

## Technologies Used

- **PHP 8**
- **Redis**
- **Symfony framework**
- **Symfony Messenger**
- **Swagger OpenAPI**

## Features

- REST API for creating and reading Timer
- Timers are persistent
- Delayed job scheduler
- Http-api and worker instances can be run in parallel and scaled up independently

## Setup

- Download and install the latest [Docker and docker compose](https://www.docker.com/get-started)

## Development

To start the whole system locally in the containerized environment run

```console
docker-compose up --build
```

To run Unit and functional tests:

```console
docker-compose -f docker-compose.test.yaml up --build --abort-on-container-exit
```

**By default, API is running at http://localhost**
If you default port is busy, you can change it in `/docker-compose.yaml` from 80:

```console
ports:
  - 80:80 # http://localhost
```

to 8081 (for example)

```console
ports:
  - 8081:80 # http://localhost:8081/
```

## API documentation

There are two end-points:

- `POST /api/v1/timers`
- `GET /api/v1/timers/:id`

* When the app is running, API documentation is accessible here: http://localhost/api/doc

![drawing](https://i.vgy.me/RV2nzh.png)

## Room for Improvement

- **The bottleneck of this design is ID auto-increment counter** - Redis' INCR. Because there is a point of synchronization between all the http-api workers. If it's acceptable to replace continuous IDs with **UUIDs or other randomized IDs**, it'll allow scaling the number of http-api instances drastically
- Redis could be clustered

## Contact

Created by [@serge-arbor](https://www.linkedin.com/in/serge-arbor) - feel free to contact me!
