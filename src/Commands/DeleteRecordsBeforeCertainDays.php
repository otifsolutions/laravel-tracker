<?php

namespace OTIFSolutions\LaravelTracker\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use OTIFSolutions\Laravel\Settings\Models\Setting;
use OTIFSolutions\LaravelTracker\Models\{MyCookie, UserSession, RequestData, UserActivity, MiscData};

class DeleteRecordsBeforeCertainDays extends Command {

    protected $hidden = true;
    protected $signature = 'clear:records';
    protected $description = 'Will keep the records of certain days, and removes the rest';

    public function handle() {

        $keepDataExceptDays = is_int(Setting::get('keep_except')) ? Setting::get('keep_except') : Setting::set('keep_except', 20, 'int');

        if (Schema::hasTable('user_sessions') && UserSession::exists()) {
            UserSession::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (Schema::hasTable('user_activities') && UserActivity::exists()) {
            UserActivity::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users activities data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (Schema::hasTable('request_data') && RequestData::exists()) {
            RequestData::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users request data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (Schema::hasTable('misc_data') && MiscData::exists()) {
            RequestData::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users miscellaneous data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        if (Schema::hasTable('my_cookies') && MyCookie::exists()) {
            RequestData::whereDate('created_at', '<=', Carbon::now()->subDays($keepDataExceptDays))->delete();
            $this->info('Users cookies data before ' . $keepDataExceptDays . ' days removed');
            $this->newLine();
        }

        return 0;
    }

}
