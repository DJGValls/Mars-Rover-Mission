# Mars Rover Mission 🚀
A PHP implementation of the Mars Rover Mission kata, demonstrating SOLID principles, clean architecture, and test-driven development.
## 🎯 Project Description
The Mars Rover Mission is a simulation of a robotic rover navigating on a plateau on Mars. The rover receives commands to move and rotate, while avoiding obstacles and staying within the plateau boundaries.
### Key Features
- Grid-based movement system
- Cardinal direction navigation (N, S, E, W)
- Command processing (Move forward, Rotate left/right)
- Obstacle detection and avoidance
## 🛠️ Technologies Used
- PHP 8.2+
- Composer for dependency management
- Laravel framework components
- Vite for front-end development
- Tailwind CSS for styling
- PSR-12 coding standards
## 🚀 Installation
1. Clone the repository: https://github.com/DJGValls/Mars-Rover-Mission.git
2. Enter the project directory: `cd Mars-Rover-Mission/src`
3. Install laravel dependencies: `composer install`
4. Install vite dependencies: `npm install`
5. Make migrations: `php artisan migrate` (Click yes on ask to use SQLLite)
## 📝 Usage without Docker
1. Open a terminal in src: `cd Mars-Rover-Mission/src`
2. Run php service: `php artisan serve`
3. Open other terminal in src: `cd Mars-Rover-Mission/src`
4. Run npm service: `npm run dev`
5. Open your browser and enter this URL: `http://127.0.0.1:8000/`
6. Enjoy the mars rover mission!
## 📝 Usage with Docker
1. Open a terminal: `cd Mars-Rover-Mission`
2. Write to start: `./start_docker.sh`
5. Open your browser and enter this URL: `http://127.0.0.1:8000/` or or `http://localhost:8000/`
6. Enjoy the mars rover mission!

## 📝 Usage with Docker for MAC users
1. Follow the same steps as above, but if you have this issue on your browser when you try to access the app, you have to open other terminal in src: `cd Mars-Rover-Mission/src` and run npm service: `npm run dev`
```
Vite manifest not found at: /var/www/html/public/build/manifest.json
```



