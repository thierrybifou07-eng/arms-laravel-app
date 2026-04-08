<?php

namespace Database\Seeders;

use App\Models\Residence;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\ResidenceStatus;
use App\Models\BuildingStatus;
use App\Models\FloorStatus;
use App\Models\RoomStatus;
use Illuminate\Database\Seeder;

class ResidenceInfrastructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $residenceStatusId = ResidenceStatus::where('code', ResidenceStatus::ACTIVE)->first()?->id ?? 1;
        $buildingStatusId = BuildingStatus::where('code', BuildingStatus::ACTIVE)->first()?->id ?? 1;
        $floorStatusId = FloorStatus::where('code', FloorStatus::ACTIVE)->first()?->id ?? 1;
        $roomStatusId = RoomStatus::where('code', RoomStatus::AVAILABLE)->first()?->id ?? 1;

        $residences = [
            ['name' => 'Résidence Prestige', 'city' => 'Yaoundé', 'address' => 'Boulevard de la Liberté'],
            ['name' => 'Résidence Excellence', 'city' => 'Douala', 'address' => 'Rue du Commerce'],
            ['name' => 'Résidence Horizon', 'city' => 'Limbe', 'address' => 'Boulevard côtier'],
            ['name' => 'Résidence Confort', 'city' => 'Buea', 'address' => 'Rue de l\'Université'],
            ['name' => 'Résidence Royal', 'city' => 'Bafoussam', 'address' => 'Centre-ville'],
            ['name' => 'Résidence Elite', 'city' => 'Bamenda', 'address' => 'Avenue Principale'],
            ['name' => 'Résidence Vert', 'city' => 'Libreville', 'address' => 'Quartier Nouveau'],
            ['name' => 'Résidence Paix', 'city' => 'N\'Djamena', 'address' => 'Centre administratif'],
            ['name' => 'Résidence Oasis', 'city' => 'Bangui', 'address' => 'Quartier Saint-Paul'],
            ['name' => 'Résidence Soleil', 'city' => 'Brazzaville', 'address' => 'Plateau des 15 ans'],
        ];

        $totalRoomsCreated = 0;
        $totalFloorsCreated = 0;
        $totalBuildingsCreated = 0;

        foreach ($residences as $residenceData) {
            $residence = Residence::create([
                'name' => $residenceData['name'],
                'city' => $residenceData['city'],
                'address' => $residenceData['address'],
                'capacity' => fake()->numberBetween(150, 500),
                'residence_status_id' => $residenceStatusId,
            ]);

            // Create 3-5 buildings per residence
            $buildingCount = fake()->numberBetween(3, 5);
            for ($b = 1; $b <= $buildingCount; $b++) {
                $building = Building::create([
                    'residence_id' => $residence->id,
                    'building_status_id' => $buildingStatusId,
                    'name' => "Building {$b}",
                    'address' => "{$residenceData['address']} - Bloc {$b}",
                    'capacity' => fake()->numberBetween(50, 200),
                ]);
                $totalBuildingsCreated++;

                // Create 10-15 floors per building
                $floorCount = fake()->numberBetween(10, 15);
                for ($f = 1; $f <= $floorCount; $f++) {
                    $floor = Floor::create([
                        'building_id' => $building->id,
                        'floor_status_id' => $floorStatusId,
                        'number' => $f,
                        'capacity' => fake()->numberBetween(20, 50),
                    ]);
                    $totalFloorsCreated++;

                    // Create 20-25 rooms per floor
                    $roomCount = fake()->numberBetween(20, 25);
                    for ($r = 1; $r <= $roomCount; $r++) {
                        Room::create([
                            'floor_id' => $floor->id,
                            'room_status_id' => $roomStatusId,
                            'number' => $r,
                            'rent' => fake()->randomFloat(2, 50000, 200000),
                            'capacity' => fake()->numberBetween(1, 4),
                        ]);
                        $totalRoomsCreated++;
                    }
                }
            }
        }

        $this->command->info("✓ 10 residences created");
        $this->command->info("✓ $totalBuildingsCreated buildings created");
        $this->command->info("✓ $totalFloorsCreated floors created");
        $this->command->info("✓ $totalRoomsCreated rooms created");
    }
}
