<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class CrudController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $model;

    public $route;

    public $viewsDirectory;

    public array $createValidationFields;
    public array $updateValidationFields;

    public string $routeItemName;

    /**
     * Таблица
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index() {
        return view("dashboard.{$this->viewsDirectory}.index", [
            'items' => $this->model::orderBy('id', 'DESC')->paginate(15),
            'route' => $this->route,
        ]);
    }

    /**
     * Страница создания
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create() {
        return view("dashboard.{$this->viewsDirectory}.create", [
            'route' => $this->route
        ]);
    }

    /**
     * Метод добавления элемента в таблицу
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        $validation = Validator::make($request->all(), $this->createValidationFields);

        if($validation->fails()) {
            return redirect()->route("{$this->route}.create")
                ->withErrors($validation);
        }

        $item = new $this->model();

        $item->fill($request->all());

        if($item->save()) {
            return redirect()
                ->route("{$this->route}.edit", ["{$this->routeItemName}" => $item->id])
                ->with('successMessage', 'Элемент успешно добавлен.');
        } else {
            return redirect()
                ->route("{$this->route}.create")
                ->withInput($request->input())
                ->with('errorMessage', 'При добавлении элемента произошла ошибка. Повторите попытку позже.');
        }
    }

    /**
     * Страница редактирования
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(int $id) {
        $item = $this->model::find($id);

        if(!$item) {
            abort(404);
        }

        return view("dashboard.{$this->route}.edit", [
            'item' => $item,
            'route' => $this->route
        ]);
    }

    /**
     * Метод редактирования элемента в таблице
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $validation = Validator::make($request->all(), $this->updateValidationFields);

        if ($validation->fails()) {
            return redirect()->route("{$this->route}.edit", ["{$this->routeItemName}" => $id])
                ->withErrors($validation);
        }

        $item = $this->model::find($id);

        $item->fill($request->all());

        if ($item->save()) {
            return redirect()->route("{$this->route}.edit", ["{$this->routeItemName}" => $id])
                ->with('successMessage', 'Элемент успешно обновлён!');
        } else {
            return redirect()->route("{$this->route}.edit", ["{$this->routeItemName}" => $id])
                ->with('errorMessage', 'При обновлении произошла ошибка. Повторите попытку позже');
        }
    }

    /**
     * Метод удаления элемента из таблицы
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id) {
        $item = $this->model::find($id);

        if(!$item) {
            abort(404);
        }

        if($item->delete()) {
            return redirect()->route("{$this->route}.index")
                ->with('successMessage', 'Элемент успешно удалён!');
        } else {
            return redirect()->route("{$this->route}.index")
                ->with('errorMessage', 'При удалении элемента произошла ошибка. Повторите попытку позже.');
        }
    }
}
