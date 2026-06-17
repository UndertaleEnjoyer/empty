<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

// API-контроллер для таблицы teams — возвращает JSON, а не Blade-шаблоны
class TeamControllerApi extends Controller
{
    /**
     * Постраничное получение команд с поиском (фильтрацией) по подстроке.
     * GET-параметры:
     *   page    — номер страницы (начиная с нуля)
     *   perpage — количество элементов на странице
     *   search  — подстрока для отбора по полю name (оператор LIKE)
     */
    public function index(Request $request)
    {
        return response(Team::limit($request->perpage ?? 5)
            ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->get());
    }

    /**
     * Общее количество записей в таблице teams (для пагинации) —
     * с учётом того же условия поиска по подстроке.
     */
    public function total(Request $request)
    {
        return response(Team::where('name', 'LIKE', '%' . $request->search . '%')->count());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Возвращаем одну команду по id; если нет — вернёт null (не 404)
        return response(Team::find($id));
    }

    /**
     * Создание новой команды с загрузкой логотипа в Yandex Object Storage.
     *
     * Поля формы (multipart/form-data):
     *   name    — наименование команды (обязательное)
     *   picture — файл изображения-логотипа (обязательный)
     */
    public function store(Request $request)
    {
        // 1. Валидация значений полей формы на backend
        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'max:255', 'unique:teams,name'],
            'picture' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ], [
            'name.required'    => 'Укажите наименование команды.',
            'name.unique'      => 'Команда с таким наименованием уже существует.',
            'picture.required' => 'Прикрепите файл изображения.',
            'picture.image'    => 'Файл должен быть изображением.',
            'picture.mimes'    => 'Допустимые форматы: jpg, jpeg, png, gif, webp.',
            'picture.max'      => 'Размер изображения не должен превышать 5 МБ.',
        ]);

        if ($validator->fails()) {
            // 422 — ошибка валидации, фронтенд покажет toast с сообщениями
            return response()->json([
                'message' => 'Ошибка валидации данных.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // 2. Загрузка файла в объектное хранилище S3 (Yandex Object Storage)
        try {
            $file = $request->file('picture');
            // Уникальное имя, чтобы файлы не перезаписывали друг друга
            $filename = Str::random(8) . '_' . $file->getClientOriginalName();

            // Кладём файл в папку team_pictures с публичным доступом на чтение
            $path = $file->storeAs('team_pictures', $filename, [
                'disk'       => 's3',
                'visibility' => 'public',
            ]);

            // Публичная ссылка на загруженный объект
            $pictureUrl = Storage::disk('s3')->url($path);
        } catch (\Throwable $e) {
            // 503 — хранилище недоступно (например, S3 не работает)
            return response()->json([
                'message' => 'Не удалось загрузить файл в хранилище. Сервис S3 недоступен.',
                'error'   => $e->getMessage(),
            ], 503);
        }

        // 3. Сохраняем запись в БД
        $team = Team::create([
            'name'        => $request->input('name'),
            'picture_url' => $pictureUrl,
        ]);

        return response()->json([
            'message' => 'Команда успешно добавлена.',
            'team'    => $team,
        ], 201);
    }

    /**
     * Удаление команды.
     * Реализованы:
     *   - проверка полномочий пользователя (Gate 'delete-team' — только админ);
     *   - ограничение целостности (нельзя удалить команду, у которой есть игроки).
     */
    public function destroy(string $id)
    {
        // 1. Проверка прав пользователя на удаление
        if (!Gate::allows('delete-team')) {
            return response()->json([
                'code'    => 1,
                'message' => 'У вас нет прав на удаление команды',
            ], 401);
        }

        // 2. Проверка существования записи
        $team = Team::find($id);
        if ($team === null) {
            return response()->json([
                'code'  => 1,
                'error' => 'Команда не найдена',
            ]);
        }

        // 3. Ограничение целостности: нельзя удалить команду, за которую
        //    закреплены игроки (аналог «непустой категории»).
        if ($team->players()->count() > 0) {
            return response()->json([
                'code'  => 1,
                'error' => 'Нельзя удалить непустую команду (за неё закреплены игроки)',
            ]);
        }

        // 4. Удаление записи
        Team::destroy($id);

        return response()->json([
            'code'    => 0,
            'message' => 'Команда успешно удалена',
        ]);
    }

    /**
     * Редактирование (обновление) существующей команды.
     * Поля формы (multipart/form-data, метод POST):
     *   name    — новое наименование команды (обязательное);
     *   picture — новый файл логотипа (необязательный — если не передан,
     *             старое изображение сохраняется).
     * Реализована проверка прав пользователя (Gate 'update-team').
     */
    public function update(Request $request, string $id)
    {
        // 1. Проверка прав пользователя на редактирование
        if (!Gate::allows('update-team')) {
            return response()->json([
                'code'    => 1,
                'message' => 'У вас нет прав на редактирование команды',
            ], 401);
        }

        // 2. Валидация. Имя должно быть уникальным, кроме текущей записи.
        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'max:255', 'unique:teams,name,' . $id],
            'picture' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ], [
            'name.required' => 'Укажите наименование команды.',
            'name.unique'   => 'Команда с таким наименованием уже существует.',
            'picture.image' => 'Файл должен быть изображением.',
            'picture.mimes' => 'Допустимые форматы: jpg, jpeg, png, gif, webp.',
            'picture.max'   => 'Размер изображения не должен превышать 5 МБ.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => 1,
                'message' => 'Ошибка валидации данных.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $team = Team::findOrFail($id);

            // 3. Если загружено новое изображение — удаляем старое из S3
            //    и кладём новое.
            if ($request->hasFile('picture')) {
                // Удаляем старый объект (ключ извлекаем из публичного URL)
                if ($team->picture_url) {
                    $oldKey = ltrim(parse_url($team->picture_url, PHP_URL_PATH), '/');
                    if ($oldKey) {
                        Storage::disk('s3')->delete($oldKey);
                    }
                }

                $file = $request->file('picture');
                $filename = Str::random(8) . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('team_pictures', $filename, [
                    'disk'       => 's3',
                    'visibility' => 'public',
                ]);
                $team->picture_url = Storage::disk('s3')->url($path);
            }

            // 4. Обновляем наименование и сохраняем
            $team->name = $request->input('name');
            $team->save();

            return response()->json([
                'code'    => 0,
                'message' => 'Команда успешно обновлена',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code'    => 2,
                'message' => 'Ошибка при обновлении: ' . $e->getMessage(),
            ], 500);
        }
    }
}
