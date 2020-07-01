<?php

namespace App\Listeners;

use App\Events\ProjectSaved;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class OptimizeProjectImage implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ProjectSaved $event
     * @return void
     */
    public function handle(ProjectSaved $event)
    {
        # Simulando un error
        //throw new \Exception("Error optimizando la imagen",1);

        $image = Image::make(Storage::get($event->project->image))
            ->widen(800)
            ->limitColors(255)
            ->encode();

        Storage::put($event->project->image, (string)$image);
    }
}
