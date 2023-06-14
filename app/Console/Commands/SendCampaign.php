<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;

class SendCampaign extends Command
{
    protected $signature = 'app:campaign:send {campaign}';

    protected $description = 'Sends campaign emails to targets.';

    public function handle()
    {
        $campaignUuid = $this->argument('campaign');
        $campaign = Campaign::where('uuid', $campaignUuid)->first();

        if (! isset($campaign)) {
            $this->error("No campaign with UUID '{$campaignUuid}'");
            return Command::FAILURE;
        }

        $targetsCount = $campaign->targets->count();

        if ($targetsCount > 0) {
            if ($this->confirm("Proceed to send campaign to {$targetsCount} targets?")) {
                $sent = 0;
                $errors = 0;

                foreach ($campaign->targets as $target) {
                    try {
                        $email = $campaign->emails()->make([
                            'target' => $target,
                        ]);
                        $email->saveOrFail();
                        $email->send();

                        $sent++;

                        $this->info("Email '{$email}' sent to '{$target}'");
                    } catch (\Exception $e) {
                        $errors++;
                        $this->error("Email '{$email}' could not be sent to '{$target}': {$e}");
                    }
                }

                $this->line("Result: {$sent} sent / {$errors} errors");

                return $errors > 0 ? Command::FAILURE : Command::SUCCESS;
            }
        } else {
            $this->error("No targets for Campaign '{$campaign}'");
            return Command::FAILURE;
        }
    }
}
