import logging

_log = logging.getLogger('sqlsrv')

# Extension Methods
def configure(ctx):
    pass

def preprocess_commands(ctx):
    return ()

def service_commands(ctx):
    return {}

def service_environment(ctx):
    return {}

def compile(install):
    return 0