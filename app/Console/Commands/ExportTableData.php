<?php
namespace App\Console\Commands;

use Illuminate\Support\Collection;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class ExportTableData extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:export {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export database table to a data class file with data property as array';
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Data';

    protected $dataClass;
    /**
     * @var Collection
     */
    protected $data;
    protected $table;
    protected $path = 'database/data';
    protected $model;


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->hasArgument('table')) {
            $this->table = $this->argument('table');
        } else {
            throw new InvalidParameterException('missing parameter for table"');
        }

        $basePath = base_path($this->path);
        $this->makeDirectory($this->path);

        $this->dataClass = ucfirst(Str::camel(Str::singular($this->table)).'Data');
        $path = $basePath.'/'.$this->dataClass.'.php';

/*
        if ($this->files->exists($path)) {
            $this->error($this->dataClass.' already exists!');
            if (! $this->confirm('Do you wish to continue?', true)) {
                $this->info('OK, action canceled');
                return 1;
            }
        }
*/
        try {
            $this->data = DB::table($this->table)->get()->all();
        }
        catch(QueryException $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $data = $this->getArrayString($this->data);

        $stub = $this->buildClass($this->dataClass);
        $this
            ->replaceDataBlock($stub, $data)
            ->replaceNamespace($stub, $this->path);
        $this->files->put($path, $stub);
        $this->info($this->type.' created successfully.');
        $this->line("<info>Created Data class :</info> $this->dataClass");

        return 0;
    }

    protected function getArrayString(array $data)
    {
        if(count($data) < 1) {
            return '[]';
        }
        $rows = [];
        foreach($data as $items) {
            $item = [];
            foreach($items as $k => $v) {
                $v = addcslashes($v,"'");
                $item[] = " '$k' => '$v'";
            }
            $rows[] = "\t\t[".implode(",", $item)."]";
        }
        return " [\n" . implode(",\n", $rows). "\n\t]";
    }

    protected function replaceDataBlock(&$stub, $data)
    {
        $stub = str_replace(['{{data}}','{{ data }}'], $data, $stub);
        return $this;
    }

    /**
     * Specify your Stub's location.
     */
    protected function getStub()
    {
        return  base_path() . '/stubs/export.data.stub';
    }

    protected function getNamespace($name)
    {
        return 'Database\Data';
    }
}
