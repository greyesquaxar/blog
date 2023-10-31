<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Iluminate\Support\Facades\Storage;
use App\Theme;

class BorrarTema implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $tema;

    public function __construct(Theme $tema)
    {
        $this->tema=$tema;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tema=$this->tema;
        $articulos=$tema->articles()->with(['images'])->get(); 
        foreach ($articulos as $articulo){
            foreach($articulo->images as $imagen)
            {
                Storage::disk('public')->delete('/imagenesArticulos'.$imagen->nombre);
            }
        }
        $tema->delete();
    }
}
