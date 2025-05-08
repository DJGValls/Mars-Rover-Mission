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
        $position = null;
        $obstacles = [];
        if (session()->has('rover_position')) {
            $position = session('rover_position');
            $obstacles = session('obstacles', []);
        }
        if (!$position) {
            // Generate random initial position if not exists
            $x = rand(1, 4);
            $y = rand(1, 4);
            $directions = ['N', 'E', 'S', 'W'];
            $direction = $directions[array_rand($directions)];

            $position = [
                'x' => $x,
                'y' => $y,
                'direction' => $direction
            ];
            // Generate random obstacles
            $numObstacles = rand(0, 10);
            for ($i = 0; $i < $numObstacles; $i++) {
                $obstacleX = rand(0, 5);
                $obstacleY = rand(0, 5);
                // Check rover position
                if ($obstacleX !== $position['x'] || $obstacleY !== $position['y']) {
                    $obstacles[] = ['x' => $obstacleX, 'y' => $obstacleY];
                }
            }
            // Store position and obstacles in session
            session(['rover_position' => $position]);
            session(['obstacles' => $obstacles]);
        }
        return view('rover.main', [
            'rover' => (object)[
                'x' => $position['x'],
                'y' => $position['y'],
                'direction' => $position['direction']
            ],
            'obstacles' => $obstacles
        ]);
    }

    public function clearSession()
    {
        session()->forget(['rover_position', 'obstacles']);
        return redirect()->route('rover.index')->with('status', 'Session cleared successfully');
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

    $position = session('rover_position');
    if (!$position) {
        return redirect()->route('rover.index');
    }


    $x = $position['x'];
    $y = $position['y'];
    $direction = Directions::from($position['direction']);

    // Get obstacles from session or set default
    $obstacles = session('obstacles', []);

    // Process commands
    $commands = strtoupper($request->input('commands'));
    $obstacleEncountered = false;

    // Define possible directions in clockwise order
    $directionsEnum = [
        Directions::Nord,
        Directions::East,
        Directions::South,
        Directions::West,
    ];

    // Rotation handler
    $rotate = function (Directions $currentDir, string $turn) use ($directionsEnum): Directions {
        $index = array_search($currentDir, $directionsEnum);
        if ($turn === 'L') {
            $index = ($index - 1 + count($directionsEnum)) % count($directionsEnum);
        } elseif ($turn === 'R') {
            $index = ($index + 1) % count($directionsEnum);
        }
        return $directionsEnum[$index];
    };
    // Check for obstacles in next position
    $hasObstacle = function($newX, $newY) use ($obstacles) {
        foreach ($obstacles as $obstacle) {
            if ($obstacle['x'] === $newX && $obstacle['y'] === $newY) {
                return true;
            }
        }
        return false;
    };
    $tryMoveForward = function() use (&$x, &$y, &$direction, $hasObstacle, &$obstacleEncountered) {
        $newX = $x;
        $newY = $y;
        switch ($direction->value) {
            case Directions::Nord->value:
                $newY = min($y + 1, 4); // Limit to grid size (5x5)
                break;
            case Directions::South->value:
                $newY = max($y - 1, 0);
                break;
            case Directions::East->value:
                $newX = min($x + 1, 4);
                break;
            case Directions::West->value:
                $newX = max($x - 1, 0);
                break;
        }
        // Check if new position has obstacle
        if ($hasObstacle($newX, $newY)) {
            $obstacleEncountered = true;
            return;
        }
        // Update position if no obstacle
        $x = $newX;
        $y = $newY;
    };
    // Process each command
    foreach (str_split($commands) as $command) {
        if ($command === 'F') {
            $tryMoveForward();
        } elseif ($command === 'L' || $command === 'R') {
            $direction = $rotate($direction, $command);
        }
    }
    // Store final position in session
    session(['rover_position' => [
        'x' => $x,
        'y' => $y,
        'direction' => $direction->value
    ]]);
    return view('rover.main', [
        'rover' => (object)[
            'x' => $x,
            'y' => $y,
            'direction' => $direction->value
        ],
        'obstacles' => $obstacles,
        'obstacleEncountered' => $obstacleEncountered
    ]);
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
