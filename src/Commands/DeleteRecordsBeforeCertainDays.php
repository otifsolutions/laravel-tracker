<?php

namespace OTIFSolutions\LaravelTracker\Commands;

use Illuminate\Console\Command;

class DeleteRecordsBeforeCertainDays extends Command {

    protected $hidden = true;

    protected $signature = 'clear:records';

    protected $description = 'Will keep the records of certain days, and removes the rest';

    public function handle() {


        // logic goes here to remove old records


        return 0;
    }

}
