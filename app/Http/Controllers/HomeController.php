<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name')->get();

        // Pre-built as a plain array here, since Blade's @json() directive
        // can't reliably parse a nested ->map(fn () => [...]) expression
        // written directly inside it.
        $servicesForJs = $services->map(fn ($s) => [
            'id'    => $s->id,
            'name'  => $s->name,
            'price' => (float) $s->price,
            'unit'  => $s->unit,
            'image' => $s->image
                ? asset('images/services/' . $s->image)
                : 'https://picsum.photos/seed/' . $s->id . '/400/400',
        ])->values()->all();

        return view('frontend.home', compact('services', 'servicesForJs'));
    }
}