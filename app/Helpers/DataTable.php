<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class DataTable {
    public static function paginate(string $builder, Request $request, array $columns)
    {
        $search = $request->search;
        $order = $request->order;
        $length = $request->length;
        $start = $request->start;

        // $class = "App\\Models\\Permission";
        $query = $builder::query();

        // search
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search['value'] . '%')
                ->orWhere('guard_name', 'like', '%' . $search['value'] . '%');
        }

        // order
        if (!empty($order)) {
            $query->orderBy($columns[$order[0]['column']], $order[0]['dir']);
        }

        return [
            'recordsTotal' => $query->count(),
            'recordsFiltered' => $query->count(),
            'data' => $query
                ->offset($start)
                ->limit($length)
                ->get(),
            'draw' => $request->draw,
        ];
    }
}
