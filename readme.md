# Delayed Webhook
> Showcase solution for Lemonade Home Assignment 

## Table of Contents
* [General Info](#general-information)
* [Technologies Used](#technologies-used)
* [Features](#features)
* [Screenshots](#screenshots)
* [Setup](#setup)
* [Usage](#usage)
* [Room for Improvement](#room-for-improvement)
* [Acknowledgements](#acknowledgements)
* [Contact](#contact)
<!-- * [License](#license) -->


## General Information
- Project Delayed Webhook consist of API and worker to implement delayed webhook shoot 
- This is a showcase implementation. The goal is to show Symfony API best practices, following SOLID and DRY principles.
- If that task would be real world task - there would be no need to split all the logic into layers and the best solution would be 100 LOC in 5 files. 
<!-- You don't have to answer all the questions - just the ones relevant to your project. -->

## Assumptions
- There would be many types of webhook Timers
- The application required to be used in some internal environment without external access
- The authentication is not required
- API should be scalable, so there can be many instances of API
- Workers should be scalable, so there can be many instances of worker
- Required timers indexes are ordered numbers: [1,2,3,4,5], so the easiest way to achieve that would be using Mysql, but it's critically redundant to use Mysql just because of indexes!
- The second thought about database was MongoDb, because it's easy to use, but we are not required to store many TB (or PB) of data
- The third thought was Redis, and I have no doubts. This is the best choice in my opinion to store small data like {id: 1, url: "example.com"} and it has INCR command which is perfect for our indexes
- How can I implement delay? Yes, I thought about cron :D, but then I imagined how 100 cron workers will try to get same job, of course we can use locks, but maybe there is more sophisticated solution 
- Queue with delay option. Fortunately we already have message bus in symfony framework, so it's my best option
- There is no requirements for "backoff" strategy, so I use 1 retry after 1000ms delay if Timer url is not reachable

## Technologies Used
- PHP - version 8.0
- Symfony - version 5.3
- symfony/messenger - version 5.3


## Features
List the ready features here:
- Awesome feature 1
- Awesome feature 2
- Awesome feature 3


## Screenshots
![Example screenshot](./img/screenshot.png)
<!-- If you have screenshots you'd like to share, include them here. -->


## Setup
What are the project requirements/dependencies? Where are they listed? A requirements.txt or a Pipfile.lock file perhaps? Where is it located?

Proceed to describe how to install / setup one's local environment / get started with the project.


## Usage
How does one go about using it?
Provide various use cases and code examples here.

`write-your-code-here`

## Room for Improvement
Include areas you believe need improvement / could be improved. Also add TODOs for future development.

Room for improvement:
- Improvement to be done 1
- Improvement to be done 2

To do:
- Feature to be added 1
- Feature to be added 2


## Acknowledgements
Give credit here.
- This project was inspired by...
- This project was based on [this tutorial](https://www.example.com).
- Many thanks to...


## Contact
Created by [@flynerdpl](https://www.flynerd.pl/) - feel free to contact me!


<!-- Optional -->
<!-- ## License -->
<!-- This project is open source and available under the [... License](). -->

<!-- You don't have to include all sections - just the one's relevant to your project -->