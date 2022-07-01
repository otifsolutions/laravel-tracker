<?php

namespace OTIFSolutions\LaravelTracker\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use OTIFSolutions\Laravel\Settings\Models\Setting;
use OTIFSolutions\LaravelTracker\Models\ActivitySummary;
use OTIFSolutions\LaravelTracker\Models\NovaSession;
use OTIFSolutions\LaravelTracker\Models\RequestData;
use OTIFSolutions\LaravelTracker\Models\UserActivity;

class DeleteRecordsBeforeCertainDays extends Command {

    protected $hidden = true;

    protected $signature = 'clear:records';

    protected $description = 'Will keep the records of certain days, and removes the rest';

    public function handle() {

        // if user has given this key from anywhere else, this will be overritten
        $keepDataExceptDays = Setting::get('keep_except') ?? Setting::set('keep_except', 10);

        if (NovaSession::exists()) {
            NovaSession::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            // $this->info('Users data before ' . $keepDataExceptDays . ' days removed');
            // $this->newLine();
        }

        if (UserActivity::exists()) {
            UserActivity::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            // $this->info('Users activities before ' . $keepDataExceptDays . ' days removed');
            // $this->newLine();
        }

        if (RequestData::exists()) {
            RequestData::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            // $this->info('Users data before ' . $keepDataExceptDays . ' days removed');
        }

        if (ActivitySummary::exists()) {
            ActivitySummary::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            // $this->info('Users data before ' . $keepDataExceptDays . ' days removed');
        }

        return 0;
    }

}
