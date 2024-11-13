# App For Admin Sports Events

This repository contains all the code developed for the CEM project. 
All changes and updates will occur here as it grows with new features.

## Setup

**Generate the SSL keys**

```
# "symfony console" is equivalent to "bin/console"
# but its aware of your database container
symfony console lexik:jwt:generate-keypair
```

Your keys will land in `config/jwt/private.pem` and `config/jwt/public.pem`
(unless you configured a different path).
