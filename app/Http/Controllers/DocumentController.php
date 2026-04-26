<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);
        return view('documents.index', compact('items'));
    }

}