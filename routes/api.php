<?php

    use App\Http\Controllers\EstoqueController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    //Rotas para visualizar os registros
    Route::get('/',function (){return response()->json(['Sucesso'=>true]);});
    Route::get('/estoque',[EstoqueController::class,'index']);
    Route::get('/estoque/{id}',[EstoqueController::class,'show']);

    //Rota para inserir os registros
    Route::post('/estoque',[EstoqueController::class,'store']);

    //Rota para alterar os registros
    Route::put('/estoque/{id}',[EstoqueController::class,'update']);

    //Rota para excluir o registro por id/codigo
    Route::delete('/estoque/{id}',[EstoqueController::class,'destroy']);