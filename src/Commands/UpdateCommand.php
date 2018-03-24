<?php

namespace Redwine\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Redwine\Models\Settings;

class UpdateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'redwine:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Redwine Admin package';

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {

        $this->info('Updating...');

        $setting = Settings::find(1);

        $setting->value = "1.0.1";

        $setting->save();        

        $this->info('Redwine Admin package successfully updated');
    }
}
