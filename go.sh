#!/usr/bin/env bash
# Emakina Symfony installer
# The purpose of this script is to execute everything needed to start working on a Symfony website


# Install a fresh Symfony from current code version
do_install() {

    composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader --working-dir=/app

    php bin/console doctrine:database:drop --force
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate -n

    php bin/console assets:install public

    go_clear_cache

    echo ""
    echo "Install finished"
}

# Update Symfony site to current code version
do_update() {

    composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader --working-dir=/app

    php bin/console doctrine:migrations:migrate -n

    php bin/console assets:install public

    go_clear_cache

    echo ""
    echo "Update finished"
}

# Clear cache
go_clear_cache() {
    php bin/console c:c --env=dev
    php bin/console c:c --env=prod
}

# (re)load fixtures
do_fixtures_reload() {

    php bin/console doctrine:database:drop --force
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate -n

    php bin/console doctrine:fixtures:load -n

    echo ""
    echo "Fixtures reloaded"
}

# Helptext
display_usage() {
    echo ""
    echo "Available options are:"
    echo ""
    echo "-u|--update: Apply all necessary updates"
    echo "-i|--install: Install or reinstall from scratch (Warning: destructive operation, flushes all content!)"
    echo "-c|--cache: Clear all caches"
    echo "-f|--fixtures: Load or reload fixtures (Warning: destructive operation, replaces most content)"
    echo ""
}


# Variables defaults
start=$SECONDS
update=false
install=false
clearCache=false
reloadFixtures=false

# Color Constants
SUCCESS='\x1b[32m' # Green
NC='\033[0m' # No color

# No arguments => display helptext
if [[ $# -eq 0 ]] ; then
    display_usage
    exit 0
fi

# Read all arguments and mark tasks to execute
while [[ $# -gt 0 ]]; do
    key="$1"
    case "$key" in
        # Install environment
        -i|--install)
        install=true
        ;;
        # Update environment
        -u|--update)
        update=true
        ;;
        # Clear cache
        -c|--cache)
        clearCache=true
        ;;
        # Enable fixtures
        -f|--fixtures)
        reloadFixtures=true
        ;;
        # Helptext if option is invalid
        -h|--help)
        display_usage
        ;;
        # Error for unknown options
        *)
        echo "Unknown option '$key'. Use lando go -h for help"
        ;;
    esac
    # Shift after checking all the cases to get the next option
    shift
done

# Tasks are always executed in the same orderer, whatever the order of parameters

# Install
if $install ; then
    do_install

    echo ""
    echo -e "${SUCCESS}Installation done.${NC}"
fi

# Update
if $update ; then
    do_update

    echo ""
    echo -e "${SUCCESS}Update done.${NC}"
fi

# Clear cache
if $clearCache ; then
    go_clear_cache

    echo ""
    echo -e "${SUCCESS}Cache cleared.${NC}"
fi

# Reload fake content
if $reloadFixtures ; then
    do_fixtures_reload

    echo ""
    echo -e "${SUCCESS}Fixtures reloaded.${NC}"
fi

# Display total execution time
duration=$(( SECONDS - start ))

echo ""
echo -e "${SUCCESS}Done in ${duration} seconds.${NC}"
