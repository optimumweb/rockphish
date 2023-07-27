<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;

class ReportCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:campaign:report {campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Produce campaign report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaignUuid = $this->argument('campaign');

        if (! isset($campaignUuid)) {
            $this->error("You must supply a campaign UUID");
            return Command::INVALID;
        }

        $campaign = Campaign::where('uuid', $campaignUuid)->first();

        if (! isset($campaign)) {
            $this->error("No campaign with UUID '{$campaignUuid}'");
            return Command::INVALID;
        }

        $hooked = collect();
        $opened = collect();
        $unopened = collect();

        foreach ($campaign->emails as $email) {
            if (isset($email->hooked_at)) {
                $hooked->push($email->target);
            } elseif (isset($email->opened_at)) {
                $opened->push($email->target);
            } else {
                $unopened->push($email->target);
            }
        }

        $hookedCount = $hooked->count();
        $openedCount = $opened->count();
        $unopenedCount = $unopened->count();

        $this->line("Hooked ({$hookedCount})");
        foreach ($hooked as $target) {
            $this->line($target);
        }

        $this->line(str_repeat('-', 20));

        $this->line("Opened ({$openedCount})");
        foreach ($opened as $target) {
            $this->line($target);
        }

        $this->line(str_repeat('-', 20));

        $this->line("Unopened ({$unopenedCount})");
        foreach ($unopened as $target) {
            $this->line($target);
        }
    }
}
