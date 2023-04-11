<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingListFormRequest;
use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use Core\Http\Controller;
use Core\Http\Request;
use Core\Redirect;
use Core\View;

class ShoppingListController extends Controller
{

    public function index(): View
    {
        $shoppingLists = new ShoppingList();

        return View::make("/shopping-lists/index", ['shoppingLists' => $shoppingLists->all()]);
    }

    public function show(int $id): View
    {
        $shoppingList = new ShoppingList();
        $shoppingListItems = new ShoppingListItem();

        return View::make('/shopping-lists/edit', [
            'ShoppingList' => $shoppingList->find($id),
            'ShoppingListItems' => $shoppingListItems->where('shopping_list_id', '=', $id),
        ]);
    }

    public function create(): View
    {
        return View::make('/shopping-lists/create', ['user' => $_SESSION['id']]);
    }

    public function store(ShoppingListFormRequest $request): Redirect
    {
        $shoppingList = new ShoppingList();
        $createdShoppingList = $shoppingList->create([
            'user_id' => $request->get('user_id'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        if($createdShoppingList) {
            $shoppingListItem = new ShoppingListItem();
            for ($i = 0; $i < count($request->get('item_name')); $i++) {
                $shoppingListItem->create([
                    'shopping_list_id' => $createdShoppingList['id'],
                    'name' => $request->get('item_name')[$i],
                    'quantity' => $request->get('item_quantity')[$i],
                    'price' => $request->get('item_price')[$i],
                ]);
            }
        }

        return Redirect::route('/shopping-lists', ['success_messages' => 'Created shopping list successfully!']);
    }

    public function update(Request $request): Redirect
    {
        $shoppingList = new ShoppingList();
        $createdShoppingList = $shoppingList->update([
            'id' => $request->get('id'),
            [
                'user_id' => $request->get('user_id'),
                'description' => $request->get('description'),
            ],
        ]);

        $shoppingListItem = new ShoppingListItem();
        for ($i = 0; $i < count($request->get('name')); $i++) {
            $shoppingListItem->update([
                'id' => $request->get('item_id'),
                [
                    'shopping_list_id' => $createdShoppingList['id'],
                    'name' => $request->get('item_name')[$i],
                    'quantity' => $request->get('item_quantity')[$i],
                    'is_checked' => $request->get('is_checked')[$i]
                ]
            ]);
        }

        return Redirect::route('/shopping-lists', ['success_messages' => 'Created ShoppingList successfully!']);
    }

    public function delete(int $id): Redirect
    {
        $shoppingList = new ShoppingList();
        $shoppingList->delete($id);

        return Redirect::route('/shopping-lists');
    }

    public function destroy(int $id): Redirect
    {
        $shoppingList = new ShoppingList();
        $shoppingList->destroy($id);

        return Redirect::route('/shopping-lists');
    }
}