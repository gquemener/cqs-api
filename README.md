# Installation

You must first install dependencies using composer:

```
$ docker run --rm -ti -v "$PWD":/app --user "$(id -u):$(id -g)" -w /app composer
```

Then start the docker services with:

```
$ docker-compose up -d
```

And setup the database schema using:

```
$ docker-compose exec web bin/console doctrine:schema:create
```

You're all set to browse the api on `http://localhost:8080`.


# Directories structure

```
src
├── Acme                   # Only proprietary code goes here
│   ├── Application        # The 2nd layer of the architecture (only knows itself and the Domain layer)
│   │   ├── Command        #     The commands
│   │   ├── CommandHandler #     The command handlers
│   │   └── EventListener  #     The event listeners listening to domain events
│   ├── Domain             # The 1st layer describing the data and rules of the business (mapped to Doctrine for conviniency)
│   │   ├── Program        #     A first entity
│   │   │   └── Events     #       with its related domain events
│   │   └── User           #     A second entity
│   └── Infrastructure     # The 3rd layer containing implementations of interfaces described in the domain layer.
│                          # The rest of the directories contains vendor specific code
├── Controller             # Some symfony controllers
├── DomainEvent            # A suite of classes allowing to raise domain events from our domain events 
│   └── Dispatcher         #     and dispatch them in the Symfony application
├── EventListener          # Some HttpKernel related event listeners
└── Prooph                 # Some Prooph related plugins
```
