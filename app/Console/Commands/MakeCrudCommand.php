<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an CRUD operation';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    protected $controllerPath = 'App\\Http\\Controllers\\Api\\Admin';
    protected $controllerStubPath = '/../../../stubs/crud/controller.stub';
    
    protected $vueFolderPath = 'resources\\js\\views\\pages';
    protected $vueStubPath = '/../../../stubs/crud/vue/';
    protected $vueFiles = ['index','add','edit','view'];
    
    protected $laravelRoutePath = 'routes\\api_admin.php';
    protected $laravelRouteStubPath = '/../../../stubs/crud/routes/api.stub';
    
    protected $vueRoutePath = 'resources\\js\\router\\routes.js';
    protected $vueRouteStubPath = '/../../../stubs/crud/routes/vue.stub';


    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
    **
    * Map the stub variables present in stub to its value
    *
    * @return array
    *
    */
    public function getStubVariables()
    {
        $name = $this->argument('name');
        $nameWithSpaces = Str::replace('_', ' ', Str::snake($name));
        $nameWithSpacesPlural = Str::plural($nameWithSpaces);
        $nameCapitalizeWithSpacesPlural =  Str::title($nameWithSpacesPlural);
        $nameCapitalizeWithDashPlural =  Str::replace(' ','-',$nameCapitalizeWithSpacesPlural);

        return [                                                                    // case: ageGroup ,  specialty  
            'NAME'              => ucwords($nameWithSpaces),                              // Age Group,  Specialty
            'NAMES'             => Str::plural(ucwords($nameWithSpaces)),                 // Age Groups, Specialties
            'NAME_CAP'          => Str::replace(' ', '', ucwords($name)),                 // AgeGroup,   Specialty
            'NAME_CAP_Plur'     => Str::replace(' ', '', Str::plural(ucwords($name))),    // AgeGroups,  Specialties
            'NAME_SML'          => Str::snake($name),                                     // age_group,  specialty
            'NAME_SML_Plur'     => Str::snake(Str::plural($name)),                        // age_groups, specialties
            'NAME_CAP_SNK'      => Str::singular($nameCapitalizeWithDashPlural),          // Age-Group,  Specialty
            'NAME_CAP_SNK_Plur' => $nameCapitalizeWithDashPlural,                         // Age-Groups, Specialties
            'NAME_DASH'         => Str::replace(' ', '-', $nameWithSpaces),               // age-group,  specialty
            'NAME_DASH_Plur'    => Str::plural(Str::replace(' ', '-', $nameWithSpaces)),  // age-groups, specialties
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->makeController();
        $this->makeVues();
        $this->modifyLaravelRoute();
        $this->modifyVueRoute();
    }

    public function makeController()
    {
        $path = $this->getControllerFilePath();

        $this->makeDirectory(dirname($path));
    
        $contents = $this->getControllerStubFile();

        $this->createFile($path, $contents);
    }

    public function makeVues()
    {
        foreach ($this->vueFiles as $filename) {
            
            $path = $this->getVueFilePath($filename);

            $this->makeDirectory(dirname($path));
            
            $contents = $this->getVueStubFile($filename);

            $this->createFile($path, $contents);
        }
    }

    public function modifyLaravelRoute()
    {
        $path = $this->getlaravelRouteFilePath();

        $contents = $this->getlaravelRouteStubFilePath();

        $this->updateFile($path, $contents);
    }

    public function modifyVueRoute()
    {
        $path = $this->getVueRoutePath();

        $contents = $this->getVueRouteStubFilePath();

        $this->updateFile($path, $contents);
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getControllerFilePath()
    {
        return base_path($this->controllerPath) .'\\' .$this->getSingularClassName($this->argument('name')) . 'Controller.php';
    }

    public function getVueFilePath($filename)
    {
        return base_path($this->vueFolderPath) .'\\' .$this->getSingularClassNameSmall($this->argument('name')) .'\\'. $filename.'.vue';
    }

    public function getlaravelRouteFilePath()
    {
        return base_path($this->laravelRoutePath);
    }

    public function getVueRoutePath()
    {
        return base_path($this->vueRoutePath);
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getControllerStubFile()
    {
        return $this->getStubContents(__DIR__ . $this->controllerStubPath, $this->getStubVariables());
    }

    public function getVueStubFile($filename)
    {
        return $this->getStubContents(__DIR__ . $this->vueStubPath . $filename .'.stub', $this->getStubVariables());
    }

    public function getlaravelRouteStubFilePath()
    {
        return $this->getStubContents(__DIR__ . $this->laravelRouteStubPath, $this->getStubVariables());
    }

    public function getVueRouteStubFilePath()
    {
        return $this->getStubContents(__DIR__ . $this->vueRouteStubPath, $this->getStubVariables());
    }

    /**
     * Return the Singular uppercase Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name)
    {
        return ucwords(Str::plural($name));
    }

    /**
     * Return the Singular lowercase Name
     * @param $name
     * @return string
     */
    public function getSingularClassNameSmall($name)
    {
        return Str::snake(Str::plural($name));
    }


    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('[@'.$search.']' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
   
    public function createFile($path, $contents)
    {
        $this->files->put($path, $contents);
        $this->info("File  created: {$path}");
    }

    public function updateFile($path, $contents)
    {
        $this->files->append($path, $contents);
        $this->info("File modified: {$path}");
    }
}
