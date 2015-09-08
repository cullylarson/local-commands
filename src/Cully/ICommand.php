<?php

namespace Cully;

interface ICommand {
    /**
     * @param string $command
     * @param string|null $cwd  The working directory in which to execute the command
     * @param array $env Any environment variables to set
     * @return void
     */
    public function exec($command, $cwd=null, array $env=[]);
    /**
     * @return bool
     */
    public function hasRun();
    /**
     * Whether the last command succeeded.  Will return FALSE if no
     * command has been executed (we haven't succeeded because we
     * haven't tried).
     *
     * A successful command is one that has an exit code of 0.
     *
     * @return bool
     */
    public function success();
    /**
     * Whether the last command failed.  This will return FALSE if no
     * command has been executed (we haven't failed because we haven't
     * tried).
     *
     * @return bool
     */
    public function failure();
    /**
     * The last command executed.
     *
     * @return string
     */
    public function getCommand();
    /**
     * Will be null if a command hasn't been executed, or if the
     * last executed command didn't return an exit code.
     *
     * @return int|null
     */
    public function getExitStatus();
    /**
     * Standard output from command.
     *
     * @return string
     */
    public function getOutput();
    /**
     * Standard error from the command.
     *
     * @return string
     */
    public function getError();
}
