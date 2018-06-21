# Installation

You must first install dependencies using composer:

```
$ make install
```

Then update (if necessary) parameters in the `.env` file.

And start the services using:

```
$ make start
```

Setup the database schema using:

```
$ make setup_db
```

And you're all set to browse the api on `http://localhost:8080`.

# Tests

Run tests using:

```
make test
```

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
