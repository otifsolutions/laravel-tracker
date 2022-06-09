<?php

namespace OTIFSolutions\LaravelTracker\Commands;

use Illuminate\Console\Command;

class RemoveOldData extends Command {

    protected $signature = 'remove:old';

    protected $description = 'Will keep the data of certain previous days from now and removes the rest';

    public function handle() {

        // this command is scheduled
        // logic goes here


        return 0;
    }
}
