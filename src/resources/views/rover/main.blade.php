@extends('layouts.main')
@section('content')

<style>
    .grid-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }
    .virtual-grid {
        border-collapse: collapse;
        background: #f8f9fa;
    }
    .grid-cell {
        width: 40px;
        height: 40px;
        border: 1px solid #dee2e6;
        text-align: center;
        vertical-align: middle;
        position: relative;
    }
    .grid-cell:hover {
        background-color: #e9ecef;
    }
    .rover {
        font-size: 24px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .rover-n { transform: translate(-50%, -50%) rotate(0deg); }
    .rover-e { transform: translate(-50%, -50%) rotate(90deg); }
    .rover-s { transform: translate(-50%, -50%) rotate(180deg); }
    .rover-w { transform: translate(-50%, -50%) rotate(270deg); }
    </style>

<div class="relative min-h-screen bg-black">
    <div class="container mx-auto h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl space-y-4">
            <!-- Grid del planeta 200x200 -->
            <div class="grid-container border border-gray-800 bg-black/50 backdrop-blur-sm rounded-lg overflow-hidden">
                <table class="virtual-grid">
                    @for ($y = 4; $y >= 0; $y--)
                        <tr>
                            @for ($x = 0; $x < 5; $x++)
                                <td class="grid-cell" data-x="{{ $x }}" data-y="{{ $y }}">
                                    @if (isset($rover) && $rover->x === $x && $rover->y === $y)
                                        <div class="rover rover-{{ strtolower($rover->direction) }}">
                                            🤖
                                        </div>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor
                </table>
            </div>
            <!-- Formulario para controlar el rover -->
            <div class="w-full bg-gray-900/80 backdrop-blur-sm rounded-lg p-4">
                <form action="{{ route('rover.store') }}" method="POST" class="flex gap-4 items-end">
                    @csrf
                    <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Posición X</label>
                            <input type="number" name="x" min="0" max="200" class="mt-1 block w-full rounded-md border-gray-700 bg-gray-800 text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Posición Y</label>
                            <input type="number" name="y" min="0" max="200" class="mt-1 block w-full rounded-md border-gray-700 bg-gray-800 text-white" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Dirección</label>
                            <select name="direction" class="mt-1 block w-full rounded-md border-gray-700 bg-gray-800 text-white" required>
                                <option value="N">Norte</option>
                                <option value="E">Este</option>
                                <option value="S">Sur</option>
                                <option value="W">Oeste</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Comandos</label>
                            <input type="text" name="commands" pattern="[FLRflr]+" class="mt-1 block w-full rounded-md border-gray-700 bg-gray-800 text-white" placeholder="FFLR" required>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Mover Rover
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridContainer = document.getElementById('virtual-grid');
        const cellSize = 20; // Tamaño estimado de cada celda en píxeles
        const viewportWidth = gridContainer.clientWidth;
        const viewportHeight = gridContainer.clientHeight;

        const visibleColumns = Math.ceil(viewportWidth / cellSize);
        const visibleRows = Math.ceil(viewportHeight / cellSize);

        let lastScrollTop = 0;
        let lastScrollLeft = 0;

        function createCell(x, y) {
            const cell = document.createElement('div');
            cell.className = 'absolute border border-gray-900/20 hover:bg-gray-800/30 transition-colors';
            cell.dataset.x = x;
            cell.dataset.y = y;
            cell.style.width = cellSize + 'px';
            cell.style.height = cellSize + 'px';
            cell.style.left = (x * cellSize) + 'px';
            cell.style.top = (y * cellSize) + 'px';
            return cell;
        }

        function renderVisibleCells() {
            const scrollTop = gridContainer.scrollTop;
            const scrollLeft = gridContainer.scrollLeft;

            const startX = Math.floor(scrollLeft / cellSize);
            const startY = Math.floor(scrollTop / cellSize);

            // Limpiar celdas fuera de la vista
            gridContainer.querySelectorAll('.cell').forEach(cell => {
                const x = parseInt(cell.dataset.x);
                const y = parseInt(cell.dataset.y);
                if (x < startX || x > startX + visibleColumns ||
                    y < startY || y > startY + visibleRows) {
                    cell.remove();
                }
            });

            // Renderizar nuevas celdas visibles
            for (let y = startY; y < startY + visibleRows && y < 5; y++) {
                for (let x = startX; x < startX + visibleColumns && x < 5; x++) {
                    const cellId = `cell-${x}-${y}`;
                    if (!document.getElementById(cellId)) {
                        const cell = createCell(x, y);
                        cell.id = cellId;
                        gridContainer.appendChild(cell);
                    }
                }
            }
        }

        gridContainer.addEventListener('scroll', renderVisibleCells);
        window.addEventListener('resize', renderVisibleCells);

        // Renderizado inicial
        renderVisibleCells();
    });
</script>

@endsection
