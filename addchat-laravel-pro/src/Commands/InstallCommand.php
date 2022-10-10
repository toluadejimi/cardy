<?php

namespace Classiebit\Addchat\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageServiceProviderLaravel5;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Classiebit\Addchat\AddchatServiceProvider;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addchat:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Addchat Pro package';

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null],
        ];
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    public function fire(Filesystem $filesystem)
    {
        return $this->handle($filesystem);
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        $this->info('Initiate the installation process...');

        // verify installation
        // get domain name
        $domain      = parse_url(request()->root())['host']; 
        $s_host      = \Request::ip(); 
        $license_key = $this->ask('Enter Your license_key');
        if($this->confirm('Do you wish to continue?'))
        {
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->request('POST', 'https://cblicense.classiebit.com/verifyl', [
                'form_params' => [
                    'domain'        => $domain,
                    's_host'        => $s_host,
                    'code'          => "CBADLPRO01",
                    'license_key'   => $license_key
                ]
            ]);
            $response = json_decode($response->getBody()->getContents());
            if(!empty($response))
            {   
                if($response->status)
                {
                    $this->info('License verified, installing...');
                    $this->install($filesystem);
                }
                else
                {
                    $this->info('License verification failed.');
                }    
            }
            else
            {
                $this->info('License verification failed.');
            }    
        }
        else
        {
            $this->info('Installation abort.');
        }
    }

    
    private function install(Filesystem $filesystem)
    {
        $this->info('Initiate the installation process...');

        // 1. Publish the core assets defined in the AddchatServiceProvider
        $this->info('1. Publishing Addchat core assets: config & languages');
        $this->call('vendor:publish', ['--provider' => AddchatServiceProvider::class]);

        // 2. Run Addchat migrations
        $this->info('2. Migrating the Addchat database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);
        
        // ---- Check if everything good so far ----
        $this->info('---- Dumping the autoloaded files and reloading all new files ----');
        $composer = $this->findComposer();
        $process = new Process([$composer.' dump-autoload']);
        // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setTimeout(null); 
        $process->setWorkingDirectory(base_path())->run();

        // 3. Add Addchat Route
        $this->info('3. Adding Addchat routes to your application routes/web.php');
        $routes_contents = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($routes_contents, 'Addchat::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                "\n\nAddchat::routes();\n"
            );
        }

        // 4. Add storage symlink
        $this->info('4. Adding the storage symlink to your public folder');
        $this->call('storage:link');
        
        // Finish
        $this->info('Congrats! Addchat Laravel Pro installed successfully. Good Luck :)');
    }    
}
