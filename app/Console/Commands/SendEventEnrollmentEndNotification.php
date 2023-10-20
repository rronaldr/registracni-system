<?php

namespace App\Console\Commands;

use App\Services\Admin\DateFacade;
use App\Services\EmailFacade;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendEventEnrollmentEndNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:enrollment-end-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification to the event author about enrollment_to date end';

    private DateFacade $dateFacade;
    private EmailFacade $emailFacade;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DateFacade $dateFacade, EmailFacade $emailFacade)
    {
        parent::__construct();
        $this->dateFacade = $dateFacade;
        $this->emailFacade = $emailFacade;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info('Running email send event enrollment_to ending notification command');
        $dates = $this->dateFacade->getDatesWithEnrollmentEnding(Carbon::now());

        if ($dates->isEmpty()) {
            info('Stopping email send enrollment_to notification, no events found for given date');

            return 0;
        }

        $this->emailFacade->sendEnrollmentEndEmail($dates);

        return 0;
    }
}
