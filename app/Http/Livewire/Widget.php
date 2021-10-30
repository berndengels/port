<?php
namespace App\Http\Livewire;

use Livewire\Component;

class Widget extends Component
{
    /** @var string */
    public $position;
    public $title;
    public $content;

    public function mount(string $position, string $title, string $content)
    {
        $this->position = $position;
        $this->title    = $title;
        $this->content  = $content;
    }

    public function render()
    {
        return view('livewire.widget');
    }
}
