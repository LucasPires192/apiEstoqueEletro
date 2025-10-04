<?php
namespace App\Http\Controllers;

    use App\Models\estoque;
    use Illuminate\Http\Request;

    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\Validator;

    class EstoqueController extends Controller
    {
        public function index()
        {
            // Buscando os produtos
            $registros = Estoque::all();

            // Contando o número de registros
            $contador = $registros->count();

            // Verificando se há registros
            if($contador > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produtos encontradas com sucesso!',
                    'data' => $registros,
                    'total' => $contador
                ] , 200); //Retorna HTTP 200 (OK) com os dados e a contagem
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Nenhum produto encontrado.',
                ], 404); // Retorna HTTP 404 (Not Found) se não houver registros
            }
        }

        public function store(Request $request)
        {
            // Validação dos dados recebidos
            $validador = Validator::make($request->all(), [
                'nomeprod' => 'required',
                'marcaprod' => 'required',
                'descprod' => 'required',
                'qtdprod' => 'required',
                'dtentradaprod' => 'required',
                'dtsaidaprod' => 'required'
            ]);

            if($validador->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Registro inválidos',
                    'errors' => $validador->errors(),
                ], 400); // Retorna HTTP 400 (Bad Request) se houver erro de validação
            }
        
            //Criando um produto no banco de dados
            $registros = Estoque::create($request->all());

            if($registros){
                return response()->json([
                    'success' => true,
                    'message' => 'Produto cadastrados com sucesso!',
                    'data' => $registros,
                ], 201);
            } else{
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao cadastrar o produto',
                ], 500); // Retorna HTTP 500 (Internal Server Error) se o cadastro falhar
            }
        }

        public function show($id)
        {
            // Buscando um produto pelo ID
            $registros = Estoque::find($id);

            // Verificando se o produto foi encontrado
            if($registros) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produto localizado com sucesso!',
                    'data' => $registros
                ], 200); // Retorna HTTP 200 (OK) com os dados do produto
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Produto não localizado.',
                ], 404); // Returna HTTP 404 (Not Found) se o produto não for encontrado
            }
        }

        public function update(Request $request, string $id)
        {
            $validador = Validator::make($request->all(), [
                'nomeprod' => 'required',
                'marcaprod' => 'required',
                'descprod' => 'required',
                'qtdprod' => 'required',
                'dtentradaprod' => 'required',
                'dtsaidaprod' => 'required'
            ]);

            if($validador->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Registros inválidos',
                    'errors' => $validador->errors()
                ], 400); // Retorna HTTP 400 se houver erro de validação
            }

            // Encontrando um produto no banco
            $registrosBanco = Estoque::find($id);

            if(!$registrosBanco){
                return response()->json([
                    'success' => false,
                    'message' => 'Produto não encontrado'
                ], 404);
            }

            // Atualizando os dados
            $registrosBanco->nomeprod = $request->nomeprod;
            $registrosBanco->marcaprod = $request->marcaprod;
            $registrosBanco->descprod = $request->descprod;
            $registrosBanco->qtdprod = $request->qtdprod;
            $registrosBanco->dtentradaprod = $request->dtentradaprod;
            $registrosBanco->dtsaidaprod = $request->dtsaidaprod;

            // Salvando as alterações
            if($registrosBanco->save()){
                    return response()->json([
                        'success' => true,
                        'message' => 'Produto atualizado com sucesso!',
                        'data' => $registrosBanco
                ], 200);
            } else{
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar o produto'
                ], 500); // Retorna HTTP 500 se houver erro ao salver
            }
        }

        public function destroy($id)
        {
            // Encontrando um produto
            $registros = Estoque::find($id);

            if(!$registros){
                return response()->json([
                    'success' => true,
                    'message' => 'Produto deletado com sucesso'
                ], 200); // Retorna HTTP 200 se a exclusão for bem-sucedida
            }

            // Deletando um produto
            if ($registros->delete()){
                return response()->json([
                    'success' => true,
                    'message' => 'Produto deletada com sucesso'
                ],200); // Retorna HTTP 200 se a exclusão for bem-sucedida
            }

            return response()->json([
                'success' => false,
                'message' => 'Erro ao deletar um produto'
            ], 500); // Retorna HTTP 500 se houver erro na exclusão
        }
    }