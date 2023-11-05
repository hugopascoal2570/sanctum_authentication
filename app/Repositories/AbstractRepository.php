<?php
namespace App\Repositories;

abstract class AbstractRepository{

    protected $model; 

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    public function find($id)
    {
        $model = $this->model->find($id);
    
        if ($model) {
            return $model;
        } else {
            return response()->json(['message' => 'Item não encontrado'], 404);
        }
    }

    public function all()
    {
        $models = $this->model->all();
    
        if ($models->isEmpty()) {
            return response()->json(['message' => 'Nenhum item encontrado'], 404);
        }
    
        return response()->json(['message' => 'Itens encontrados com sucesso', 'data' => $models], 200);
    }
    

    public function create(array $data)
    {
        $model = $this->model->create($data);
    
        if ($model) {
            return response()->json(['message' => 'Item criado com sucesso', 'data' => $model], 201);
        } else {
            return response()->json(['message' => 'Falha ao criar o item'], 500);
        }
    }

    public function show($id)
    {
        $model = $this->model->where('id', $id)->first();
    
        if ($model) {
            return $model;
        } else {
            return response()->json(['message' => 'Item não encontrado'], 404);
        }
    }

public function update($data, $id)
{
    $model = $this->model->find($id);

    if (!$model) {
        return response()->json(['message' => 'Não foi possível encontrar o item'], 404);
    }

    try {
        $model->update($data);
        return $model;
    } catch (\Exception $e) {
        return response()->json(['message' => 'Houve um erro ao atualizar os itens, confira os dados informados'], 500);
    }
}

public function performDelete($id, $forceDelete = false)
{
    $model = $this->model->find($id);
    
    if (!$model) {
        return response()->json(['message' => 'Item não encontrado'], 404);
    }

    try {
        if ($forceDelete) {
            $model->forceDelete();
            return response()->json(['message' => 'Item excluído permanentemente com sucesso'], 200);
        } else {
            $model->delete();
            return response()->json(['message' => 'Item excluído com sucesso'], 200);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro ao excluir o item'], 500);
    }
}

public function delete($id)
{
    $model = $this->model->find($id);

    try {
        return $model->delete();
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro ao excluir o item'], 500);
    }
}

public function forceDelete($id)
{
    $model = $this->model->find($id);

    try {
        return $model->forceDelete();
    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro ao excluir permanentemente o item'], 500);
    }
}


    protected function resolveModel(){
        return app($this->model);
    }
    
}