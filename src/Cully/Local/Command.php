<?php

namespace Cully\Local;

class Command {
    /**
     * @var string
     */
    private $lastCommand;
    /**
     * @var int|null
     */
    private $lastExitStatus;
    /**
     * @var string
     */
    private $lastErrorOutput;
    /**
     * @var string
     */
    private $lastStandardOutput;
    /**
     * @var bool
     */
    private $_hasRun = false;

    /**
     * @param string    $command
     * @param string    $cwd        The current working directory for the command. Defaults
     *                              to getcwd().
     * @param array     $env        An assoc. array of environment variables to pass
     *                              to the command (e.g. env_var_name => value)
     *
     * @return  boolean   True if the command was run.  False if it wasn't.  This is not
     *                    an indicator of whether the command was successful, just that it
     *                    executed.  There is a chance that false can be returned, and the
     *                    command still executed.  In this case we just to don't for sure
     *                    if it executed.
     */
    public function exec($command, $cwd=null, array $env=[]) {
        /*
         * Setup
         */

        // cwd
        if( $cwd === null ) $cwd = getcwd();

        // set up pipes for reading and writing for the command
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin
            1 => array("pipe", "w"),  // stdout
            2 => array("pipe", "w"),  // stderr
        );

        /*
         * Run the command
         */

        $process = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

        // failed for some reason
        if(!is_resource($process)) return false;

        /*
         * Get the output
         */

        $standardOutput = stream_get_contents($pipes[1]);
        $errorOutput = stream_get_contents($pipes[2]);

        /*
         * Close everything down
         */

        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitStatus = proc_close($process);

        if($exitStatus === -1) return false;


        /*
         * Store what we found
         */

        $this->_hasRun = true;
        $this->lastCommand = $command;
        $this->lastExitStatus = $exitStatus;
        $this->lastStandardOutput = $standardOutput;
        $this->lastErrorOutput = $errorOutput;

        return true;
    }

    /**
     * @return bool
     */
    public function hasRun() {
        return $this->_hasRun;
    }

    /**
     * Whether the last command succeeded.  Will return FALSE if no
     * command has been executed (we haven't succeeded because we
     * haven't tried).
     *
     * A successful command is one that has an exit code of 0.
     *
     * @return bool
     */
    public function success() {
        return ($this->hasRun() && $this->getExitStatus() === 0);
    }

    /**
     * Whether the last command failed.  This will return FALSE if no
     * command has been executed (we haven't failed because we haven't
     * tried).
     *
     * @return bool
     */
    public function failure() {
        // if haven't run, then we haven't failed
        if(!$this->hasRun()) return false;
        // otherwise, if we didn't succeed, we failed
        else return !$this->success();
    }

    /**
     * The last command executed.
     *
     * @return string
     */
    public function getCommand() {
        return $this->lastCommand;
    }

    /**
     * Will be null if a command hasn't been executed, or if the
     * last executed command didn't return an exit code.
     *
     * @return int|null
     */
    public function getExitStatus() {
        return $this->lastExitStatus;
    }

    /**
     * @return string
     */
    public function getOutput() {
        return $this->lastStandardOutput;
    }

    /**
     * @return string
     */
    public function getError() {
        return $this->lastErrorOutput;
    }
}
