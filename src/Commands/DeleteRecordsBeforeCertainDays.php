<?php

namespace OTIFSolutions\LaravelTracker\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use OTIFSolutions\Laravel\Settings\Models\Setting;
use OTIFSolutions\LaravelTracker\Models\{UserSession, RequestData, UserActivity, MiscData};

class DeleteRecordsBeforeCertainDays extends Command {

    protected $hidden = true;
    protected $signature = 'clear:records';
    protected $description = 'Will keep the records of certain days, and removes the rest';

    public function handle() {

        $keepDataExceptDays = Setting::get('keep_except') ?? Setting::set('keep_except', 10);

        if (UserSession::exists()) {
            UserSession::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (UserActivity::exists()) {
            UserActivity::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users activities data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (RequestData::exists()) {
            RequestData::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users request data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (MiscData::exists()) {
            RequestData::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users request data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        return 0;
    }

}
