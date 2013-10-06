<?php namespace DevAddiction\Website\Console;

use Illuminate\Console\Command;
use DevAddiction\Website\Documents\DocumentCollection;

class DocsRefreshCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'refresh:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the documentation cache';

    /**
     * Document collection instance.
     *
     * @var \DevAddiction\Website\Documents\DocumentCollection
     */
    protected $documents;

    /**
     * Create a new basset command instance.
     *
     * @param  \DevAddiction\Website\Documents\DocumentCollection  $documents
     * @return void
     */
    public function __construct(DocumentCollection $documents)
    {
        parent::__construct();

        $this->documents = $documents;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->comment('Refreshing documentation cache...');

        $this->documents->forgetCollectionCache() and $this->documents->registerCollectionCache();

        $this->info('Documentation cache has been successfully refreshed.');
    }

}
