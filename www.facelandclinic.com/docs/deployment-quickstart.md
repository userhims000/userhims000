# Deployment Quickstart

When deploying Faceland we need to setup some things beforehand. First off, we need 3 files:

1. An `SSH config` file that will be put in `~/ssh/config`;
2. Your private key used to connect to the Bastion host that will be put in `~/ssh/id_bastion_rsa`;
3. The private key of the user `www` at the Faceland server that will be put in `~/ssh/id_faceland_deployment_rsa`.

Now that we have these 3 files, create a file named `.env.container` next to the file `.env` that already exists. Edit this
new file and add the three environment variables listed below with their values pointing to the locations of the 3 files
mentioned above:

```
DOCKER_SSH_CONFIG_FILE=
DOCKER_DEPLOYMENT_BASTION_SSH_KEY_FILE=
DOCKER_DEPLOYMENT_SSH_KEY_FILE=
```

When you did that, your `.env.container` should look something like this:

```
DOCKER_SSH_CONFIG_FILE=/home/myuser/.ssh/faceland/sshconfig
DOCKER_DEPLOYMENT_BASTION_SSH_KEY_FILE=/home/myuser/.ssh/faceland/id_bastion_rsa
DOCKER_DEPLOYMENT_SSH_KEY_FILE=/home/myuser/.ssh/faceland/id_faceland_deployment_rsa
```

Now to make your Docker container aware of the new environment variables, run `docker-compose` with the `--env-file` option,
like so: `docker-compose --env-file=.env.container up -d`

That's it!
