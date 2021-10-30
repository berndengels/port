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
    protected $signature = 'make:model-export {table} {--f|format=array : output as php-array,csv or json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export database table to a data class file (php array,csv,json)';
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
    protected $argFormat = 'array';
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

        if($this->hasOption('format')) {
            $this->argFormat = $this->option('format');
        }

        $basePath = base_path($this->path);
        $this->makeDirectory($this->path);

        $this->dataClass = Str::singular($this->table).'Data';
        $path = $basePath.'/'.$this->dataClass.'.php';

        if ($this->alreadyExists($path)) {
            $this->error($this->type.' already exists!');
            return false;
        }
        try {
            $this->data = DB::table($this->table)->get()->all();
        }
        catch(QueryException $e) {
            $this->error($e->getMessage());
            return 1;
        }

        switch($this->argFormat) {
            case 'csv':
                $data = $this->getCsvString($this->data);
                break;
            case 'json':
                $data = "'".json_encode($this->data)."'";
                break;
            case 'array':
            default:
                $data = $this->getArrayString($this->data);
                break;
        }

        $stub = $this->buildClass($this->dataClass);
        $this
            ->replaceDataBlock($stub, $data)
            ->replaceNamespace($stub, $this->path)
        ;
        $this->files->put($path, $stub);
        $this->info($this->type.' created successfully.');
        $this->line("<info>Created Data class :</info> $this->dataClass");

        return 0;
    }

    protected function getArrayString(array $data)
    {
        $rows = [];
        foreach($data as $items) {
            $item = [];
            foreach($items as $k => $v) {
                $item[] = " '$k' => '$v'";
            }
            $rows[] = "\t\t[".implode(",", $item)."]";
        }
        return " [\n" . implode(",\n", $rows). "\n\t]";
    }

    protected function getCsvString(array $data)
    {
        $cols = collect(array_keys($data[0]))->map(fn($c)=>"\"$c\"");
        $rows = [];
        $rows[] = $cols->join(',');
        foreach($data as $items) {
            $item = [];
            foreach($items as $k => $v) {
                $v = stripslashes($v);
                $item[] = "\"$v\"";
            }
            $rows[] = implode(",", $item);
        }
        return "<<< CSV\n" . implode("\n", $rows). "\nCSV";
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
