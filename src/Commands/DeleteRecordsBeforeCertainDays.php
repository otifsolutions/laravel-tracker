<?php

namespace OTIFSolutions\LaravelTracker\Commands;

use Illuminate\Console\Command;
use OTIFSolutions\LaravelTracker\Models\OtifUser;
use OTIFSolutions\LaravelTracker\Models\OtifUserActivity;

class DeleteRecordsBeforeCertainDays extends Command {

    protected $hidden = true;

    protected $signature = 'clear:records';

    protected $description = 'Will keep the records of certain days, and removes the rest';

    public function handle() {

        // if user has given this key from anywhere else, this will be overritten
        $keepDataExceptDays = Setting::get('keep_except') ?? Setting::set('keep_except', 10);

        if (OtifUser::exists()) {
            OtifUser::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (OtifUserActivity::exists()) {
            OtifUserActivity::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users activities before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        return 0;
    }

}
