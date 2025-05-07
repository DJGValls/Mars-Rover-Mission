<?php

namespace App\Http\Controllers;

use App\Enums\Directions;
use Illuminate\Http\Request;

class RoverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('rover.main');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validar los datos de entrada
        $request->validate([
            'x' => 'required|integer|min:0|max:200',
            'y' => 'required|integer|min:0|max:200',
            'direction' => ['required', new \Illuminate\Validation\Rules\Enum(Directions::class)],
            'commands' => 'required|regex:/^[fFlLrR]+$/',
            'obstacles' => 'nullable|array',
        ]);
        // obtenemos las coordenadas del formulario
        $x = (int)$request->input('x');
        $y = (int)$request->input('y');
        $direction = Directions::from(strtoupper($request->input('direction')));
        $commands = strtoupper($request->input('commands'));
        // tamanyo del planeta 200x200
        $maxX = 200;
        $maxY = 200;
        // Definir obstaculos
        $obstacles = $request->input('obstacles', []);

        // verificar si hay obstaculos en la posicion
        $hasObstacle = function($newX, $newY) use ($obstacles) {
            foreach ($obstacles as $obstacle) {
                if ($obstacle['x'] === $newX && $obstacle['y'] === $newY) {
                    return true;
                }
            }
            return false;
        };
        // Definir las posibles direcciones y sus cambios
        $directionsEnum = [
            Directions::Nord,
            Directions::East,
            Directions::South,
            Directions::West,
        ];
        // cambio de direccion
        $rotate = function (Directions $currentDir, string $turn) use ($directionsEnum): Directions {
            $index = array_search($currentDir, $directionsEnum);
            if ($turn === 'L') {
                $index = ($index - 1 + count($directionsEnum)) % count($directionsEnum);
            } elseif ($turn === 'R') {
                $index = ($index + 1) % count($directionsEnum);
            }
            return $directionsEnum[$index];
        };
        $obstacleEncountered = false;
        // Procesar cada comando
        for ($i = 0; $i < strlen($commands); $i++) {
            $command = $commands[$i];

            if ($command === 'F') {
                // Calcular la nueva posicion
                $newX = $x;
                $newY = $y;
                switch ($direction) {
                    case Directions::Nord:
                        $newY = $y + 1;
                        break;
                    case Directions::South:
                        $newY = $y - 1;
                        break;
                    case Directions::East:
                        $newX = $x + 1;
                        break;
                    case Directions::West:
                        $newX = $x - 1;
                        break;
                }
                // limite del planeta
                if ($newX < 0 || $newX > $maxX || $newY < 0 || $newY > $maxY) {
                    continue;
                }
                // checkear obstaculos
                if ($hasObstacle($newX, $newY)) {
                    $obstacleEncountered = true;
                    break;
                }

                $x = $newX;
                $y = $newY;
            } elseif ($command === 'L' || $command === 'R') {
                $direction = $rotate($direction, $command);
            }
        }
        $finalPosition = sprintf('(%d, %d, %s)', $x, $y, $direction->value);
        if ($obstacleEncountered) {
            $finalPosition = 'O:' . $finalPosition;
        }
        return redirect()->back()->with('resultado', $finalPosition);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
