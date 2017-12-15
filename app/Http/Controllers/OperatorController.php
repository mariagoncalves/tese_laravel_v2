<?php

namespace App\Http\Controllers;

//Bibliotecas para usar o validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

use Illuminate\Http\Request;

use App\Operator;

class OperatorController extends Controller
{
    public function index() {

    	return view('operator');
    }

    public function getAll(Request $request, $id = null) {

    	$data  = $request->all();
        $count = 5;
        // É de acordo com a váriavel 'count' que será apresentado o número de 'rel_types'.
        // Caso seja o 'count' 5, então será apresentado 5 'rel_types' na tabela.
        if (isset($data['count']) && $data['count'] != "") {
            $count = $data['count'];
        }

        // As váriaveis 'colSorting' e 'typeSorting' são utilizadas para ordenar os dados.
        // Por defeito, é ordenado pelo o 'created_at' e por ordem 'desc'.
        $colSorting  = 'created_at';
        $typeSorting = 'desc';
        if (isset($data['colSorting']) && $data['colSorting'] != "" && isset($data['typeSorting']) && $data['typeSorting'] != "") {
            $colSorting  = $data['colSorting'];
            $typeSorting = $data['typeSorting'];
        }

        \Log::debug("CHEGANDO");

        $dataOperator = Operator::select([
                                    'operator.*', 
                                ])
                                //->searchOperatorTypes($id, $data)
                                // Isto apenas é para ordenar os dados
                                ->orderBy($colSorting, $typeSorting)
                                ->paginate($count)
                                ->toArray();

        \Log::debug("Dados do operador");
        \Log::debug($dataOperator);

        return response()->json($dataOperator);
    }

    public function insertOperator(Request $request) {

    	try {
            $data = $request->all();
            //$data = $request->input('operator');

            \Log::debug("Dados para inserir");
            \Log::debug($data);
            //\Log::debug("Data operator");
            //\Log::debug($data['operator']);

            /*$rules = [
                'operator' => ['required'],
            ];

            $err = Validator::make($data, $rules);
            // Verificar se existe algum erro.
            if ($err->fails()) {
                // Se existir, então retorna os erros
                $result = $err->errors()->messages();
                return response()->json(['error' => $result], 400);
            }*/

            //Dados para inserir na tabela operator
            $data1 = array(
                'operator_type' => $data['operator'],
            );

            Operator::create($data1);

            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Try later.'], 500);
        }
    }
}
