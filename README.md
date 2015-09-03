# Local Commands

A library for executing local shell commands, with support for exit status,
standard output, and error output.  The reason this exists is that there's
a lot of boiler plate code necessary if you want to get stuff like error
output from a command.

## Install

```
curl -s http://getcomposer.org/installer | php
php composer.phar require cullylarson/local-commands
```

## Usage

1. Create an instance of `Cully\Local\Command`.

    ```
    <?php
    
    $command = new Cully\Local\Command();
    ```

1. Execute your command.

    ```
    <?php
    
    $command->exec("ls");
    ```

1.  At this point, you have access to a few results:

    ```
    <?php
    
    $command->success();       // whether the command succeeded
    $command->failure();       // whether the command failed
    $command->getCommand();    // the last command executed
    $command->getExitStatus(); // the exit status of the last command executed
    $command->getOutput();     // the standard output from the last command
    $command->getError();      // the error output from the last command
    ```
