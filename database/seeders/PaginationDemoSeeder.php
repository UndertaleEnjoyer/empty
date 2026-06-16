<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Player;

/**
 * Наполняет таблицы teams и players достаточным числом записей,
 * чтобы продемонстрировать постраничный вывод (несколько страниц).
 * Идемпотентен: повторный запуск не создаёт дубликаты.
 */
class PaginationDemoSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            'Спартак', 'ЦСКА', 'Зенит', 'Локомотив', 'Динамо',
            'Краснодар', 'Ростов', 'Рубин', 'Ахмат', 'Сочи',
            'Крылья Советов', 'Урал', 'Оренбург', 'Факел', 'Пари НН',
        ];

        foreach ($teams as $name) {
            Team::firstOrCreate(['name' => $name]);
        }

        $positions = ['Вратарь', 'Защитник', 'Полузащитник', 'Нападающий'];
        $first = ['Иван', 'Пётр', 'Алексей', 'Сергей', 'Дмитрий', 'Николай', 'Андрей', 'Михаил'];
        $last = ['Иванов', 'Петров', 'Сидоров', 'Козлов', 'Смирнов', 'Кузнецов',
                 'Попов', 'Соколов', 'Морозов', 'Волков', 'Зайцев', 'Павлов',
                 'Семёнов', 'Голубев', 'Виноградов', 'Богданов', 'Воробьёв', 'Фёдоров',
                 'Михайлов', 'Беляев'];

        $teamIds = Team::pluck('id')->all();

        foreach ($last as $i => $surname) {
            $fullName = $surname . ' ' . $first[$i % count($first)];
            Player::firstOrCreate(
                ['full_name' => $fullName],
                [
                    'team_id'  => $teamIds[$i % count($teamIds)],
                    'position' => $positions[$i % count($positions)],
                ]
            );
        }
    }
}
