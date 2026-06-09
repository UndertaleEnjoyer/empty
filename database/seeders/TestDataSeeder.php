<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;
use App\Models\MatchModel;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        Team::create(['name' => 'Спартак']);
        Team::create(['name' => 'ЦСКА']);
        Team::create(['name' => 'Зенит']);

        Player::create(['team_id' => 1, 'full_name' => 'Иванов Иван', 'position' => 'Нападающий']);
        Player::create(['team_id' => 1, 'full_name' => 'Петров Пётр', 'position' => 'Защитник']);
        Player::create(['team_id' => 2, 'full_name' => 'Сидоров Сидор', 'position' => 'Вратарь']);
        Player::create(['team_id' => 3, 'full_name' => 'Козлов Алексей', 'position' => 'Полузащитник']);

        MatchModel::create(['team1_id' => 1, 'team2_id' => 2, 'date' => '2026-05-01 18:00:00', 'venue' => 'Лужники']);
        MatchModel::create(['team1_id' => 2, 'team2_id' => 3, 'date' => '2026-05-08 20:00:00', 'venue' => 'Газпром Арена']);
        MatchModel::create(['team1_id' => 1, 'team2_id' => 3, 'date' => '2026-05-15 17:00:00', 'venue' => 'Открытие Банк Арена']);
    }
}
