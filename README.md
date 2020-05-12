# Couture-Cavez

## Backend

### On day-1

`$ lando start`

Install Symfony and feed it with fake content (fixtures)

`$ lando go -i -f`

### Then

Anytime you

- start working
- did a git checkout (you changed branch)
- did a git pull
- want to test everything works as expected

If you want to preserve content or local changes:

`$ lando go -u`

If you want to work from a clean one

`$ lando go -i -f`

Xdebug is disabled by default, if you want to enable Xdebug so that you can use the debugger

`$ lando xdebug-on`

If you want to turn it off again to keep things speedy

`$ lando xdebug-off`

## Frontend

All you need to get the front-end up and running is a Node 12 (>= 12.13.0) environment and a Yarn installation (>= 1.21.1).

#### Installation

To install all the dependencies of the project, type `yarn`. All the NPM dependencies should download according the `yarn.lock` file. Avoid using NPM, since it will create another lock file, download other dependency versions and thus create unreproduceable bugs.

### Commands

- `yarn dev`: compiles the files in development mode and build the output in the `public` directory.
- `yarn watch`: compiles the files in development mode with the --watch flag and build the output in the `public` directory.
- `yarn build`: compiles the files in production mode and build the output in the `public` directory.
- `yarn build:stats`: compiles the files in production mode, output the build in `public` but log the entire build process into `stats.json`. Use this to troubleshoot the build if results are not the expected ones.
- `yarn eslint`: runs ESLint against the code base. You can combine it with the output operator to write it to a file too, like so: `yarn eslint > eslint.text` with "eslint.text" as the filename.
- `yarn prettier`: runs Prettier against the code base. Prettier is a code formatter, code will be formatted according the `.prettierrc`file. Use that script in you don't have IDE plugin installed or available. Beware, any Prettier formatting error will show in the ESLint report.
