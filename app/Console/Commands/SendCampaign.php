<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;

class SendCampaign extends Command
{
    protected $signature = 'app:campaign:send {campaign} {--force} {--resend}';

    protected $description = 'Sends campaign emails to targets.';

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

        $targetsCount = $campaign->targets->count();

        if ($targetsCount === 0) {
            $this->error("No targets for Campaign '{$campaign}'");
            return Command::INVALID;
        }

        if ($this->option('force') || $this->confirm("Proceed to send campaign to {$targetsCount} targets?")) {
            $sent = 0;
            $skipped = 0;
            $errors = 0;

            foreach ($campaign->targets as $target) {
                try {
                    $email = $campaign->emails()->firstOrCreate([
                        'target' => $target,
                    ]);

                    if ($this->option('resend') || ! isset($email->sent_at)) {
                        $email->send();
                        $sent++;
                        $this->info("Email '{$email}' sent to '{$target}'");
                    } else {
                        $skipped++;
                        $this->line("Email '{$email}' already sent to '{$target}'");
                    }
                } catch (\Exception $e) {
                    $errors++;
                    $this->error("Email '{$email}' could not be sent to '{$target}': {$e}");
                }
            }

            $this->line("Result: {$sent} sent / {$skipped} skipped / {$errors} errors", $errors > 0 ? 'error' : 'info');

            if ($errors > 0) {
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
