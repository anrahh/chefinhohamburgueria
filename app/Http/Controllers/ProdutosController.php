<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produtos;
use App\Models\ProdutosCategorias;
use Faker\Generator as Faker;

class ProdutosController extends Controller
{
    public function index(Faker $faker)
    {
            $produtos = new Produtos();
        
        return $produtos->all();
    }
}
