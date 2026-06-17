<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

// API-контроллер для таблицы teams — возвращает JSON, а не Blade-шаблоны
class TeamControllerApi extends Controller
{
    /**
     * Постраничное получение команд.
     * GET-параметры:
     *   page    — номер страницы (начиная с нуля)
     *   perpage — количество элементов на странице
     */
    public function index(Request $request)
    {
        return response(Team::limit($request->perpage ?? 5)
            ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
            ->get());
    }

    /**
     * Общее количество записей в таблице teams (для пагинации).
     */
    public function total()
    {
        return response(Team::all()->count());
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
}
