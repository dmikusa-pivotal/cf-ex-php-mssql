import logging

_log = logging.getLogger('sqlsrv')



# Extension Methods
def configure(ctx):
    _log.info("SQLSRV configure.")
    pass

def preprocess_commands(ctx):
    _log.info("SQLSRV preprocess.")
    """
    Commands that the build pack needs to run in the runtime container prior to the app starting.
    Use these sparingly as they run before the app starts and count against the time that an application has
    to start up successfully (i.e. if it takes too long app will fail to start).
    Returns list of commands
    """
    commands = [
        [ 'echo "Installing sqlsrv package..."'],
        [ 'PHP_EXT_DIR=$(find /home/vcap/app -name "no-debug-non-zts*" -type d)'],
        [ 'cat /home/vcap/app/.extensions/sqlsrv/sqldb-extensions.ini >> /home/vcap/app/php/etc/php.ini']
    ]
    return commands

def service_commands(ctx):
    _log.info("SQLSRV service.")
    return {}

def service_environment(ctx):
    _log.info("SQLSRV env.")
    return {}

def compile(install):
    _log.info("SQLSRV compile.")
    return 0
