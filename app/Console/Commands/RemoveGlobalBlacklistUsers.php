<?php

namespace App\Console\Commands;

use App\Services\Admin\BlacklistFacade;
use Illuminate\Console\Command;

class RemoveGlobalBlacklistUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blacklist:remove-unblocked-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes users that are not blocked anymore from global blacklist';

    private BlacklistFacade $blacklistFacade;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BlacklistFacade $blacklistFacade)
    {
        parent::__construct();
        $this->blacklistFacade = $blacklistFacade;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info('Running blacklist remove unblocked users command');
        $this->blacklistFacade->removeUnblockedUsers();

        return 0;
    }
}
