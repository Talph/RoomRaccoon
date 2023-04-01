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
        $ShoppingLists = new ShoppingList();

        return View::make("/shopping-lists/index", ['ShoppingLists' => $ShoppingLists->all()]);
    }

    public function show(int $id): View
    {
        $ShoppingList = new ShoppingList();
        $ShoppingListItems = new ShoppingListItem();

        return View::make('/shopping-lists/edit', [
            'ShoppingList' => $ShoppingList->find($id),
            'ShoppingListItems' => $ShoppingListItems->where('ShoppingList_id', '=', $id),
        ]);
    }

    public function create(): View
    {
        return View::make('/shopping-lists/create');
    }

    public function store(ShoppingListFormRequest $request): Redirect
    {
        $ShoppingList = new ShoppingList();
        $createdShoppingList = $ShoppingList->create([
            'customer_id' => $request->get('customer_id'),
            'description' => $request->get('description'),
            'sub_total' => $request->get('sub_total'),
            'total_amount' => $request->get('total_amount'),
            'vat' => $request->get('tax_amount'),
        ]);

        $ShoppingListItem = new ShoppingListItem();
        for ($i = 0; $i < count($request->get('product')); $i++) {
            $ShoppingListItem->create([
                'ShoppingList_id' => $createdShoppingList['id'],
                'product' => $request->get('product')[$i],
                'description' => $request->get('description'),
                'quantity' => $request->get('item_quantity')[$i],
                'price' => $request->get('item_price')[$i],
                'total' => $request->get('item_total')[$i],
            ]);
        }

        return Redirect::route('/shopping-lists', ['success_messages' => 'Created ShoppingList successfully!']);

    }

    public function update(Request $request): Redirect
    {
        $ShoppingList = new ShoppingList();
        $createdShoppingList = $ShoppingList->update([
            'id' => $request->get('id'),
            ['customer_id' => $request->get('customer_id'),
                'description' => $request->get('description'),
                'sub_total' => $request->get('sub_total'),
                'total_amount' => $request->get('total_amount'),
                'vat' => $request->get('tax_amount')],
        ]);

        $ShoppingListItem = new ShoppingListItem();
        for ($i = 0; $i < count($request->get('product')); $i++) {
            $ShoppingListItem->update([
                'id' => $request->get('item_id'),
                ['ShoppingList_id' => $createdShoppingList['id'],
                    'product' => $request->get('product')[$i],
                    'description' => $request->get('description'),
                    'quantity' => $request->get('item_quantity')[$i],
                    'price' => $request->get('item_price')[$i],
                    'total' => $request->get('item_total')[$i]]
            ]);
        }

        return Redirect::route('/shopping-lists', ['success_messages' => 'Created ShoppingList successfully!']);
    }

    public function delete(int $id)
    {
        $ShoppingList = new ShoppingList();
        $ShoppingList->delete($id);
        return Redirect::route('/shopping-lists');
    }

    public function destroy(int $id)
    {
        $ShoppingList = new ShoppingList();
        $ShoppingList->destroy($id);
        return Redirect::route('/shopping-lists');
    }
}