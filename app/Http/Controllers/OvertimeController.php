<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use Illuminate\Http\Request;

class OvertimeController extends Controller {
    public function index() {
        // require login
        if ( !session( 'user_id' ) ) {
            return redirect( '/login' );
        }
        $entries = Overtime::orderBy( 'id', 'asc' )->get();
        return view( 'overtime', ['storedEntries' => $entries, 'currentUser' => ['id' => session( 'user_id' ), 'role' => session( 'user_role' ), 'name' => session( 'user_name' )]] );
    }

    /**
     * Store single or multiple overtime entries.
     */
    public function store( Request $request ) {
        $data = $request->validate( [
            'entries'               => 'required|array',
            'entries.*.name'        => 'required|string',
            'entries.*.dept'        => 'nullable|string',
            'entries.*.description' => 'nullable|string',
            'entries.*.date'        => 'required|date',
            'entries.*.salary'      => 'required|numeric',
            'entries.*.in'          => 'required',
            'entries.*.out'         => 'required',
            'entries.*.hrs'         => 'required|numeric',
            'entries.*.amount'      => 'required|numeric',
        ] );

        // only admin or super_admin can create
        $role = session( 'user_role' );
        if ( !$role || !in_array( $role, ['admin', 'super_admin'] ) ) {
            return response()->json( ['message' => 'Unauthorized'], 403 );
        }

        $saved = [];
        foreach ( $data['entries'] as $entry ) {
            $o = Overtime::create( [
                'name'        => $entry['name'],
                'dept'        => $entry['dept'] ?? null,
                'description' => $entry['description'] ?? null,
                'ot_date'     => $entry['date'],
                'salary'      => $entry['salary'],
                'in_time'     => $entry['in'],
                'out_time'    => $entry['out'],
                'hrs'         => $entry['hrs'],
                'amount'      => $entry['amount'],
            ] );
            $saved[] = $o->fresh();
        }

        return response()->json( ['saved' => $saved], 201 );
    }

    /**
     * Return JSON list of entries, optionally filtered by date range.
     */
    public function list( Request $request ) {
        // only super_admin can view listing
        $role = session( 'user_role' );
        if ( !$role || $role !== 'super_admin' ) {
            return response()->json( ['message' => 'Unauthorized'], 403 );
        }
        $start = $request->query( 'start' );
        $end   = $request->query( 'end' );

        $query = Overtime::query();
        if ( $start && $end ) {
            $query->whereBetween( 'ot_date', [$start, $end] );
        } elseif ( $start ) {
            $query->where( 'ot_date', '>=', $start );
        } elseif ( $end ) {
            $query->where( 'ot_date', '<=', $end );
        }

        $items = $query->orderBy( 'id', 'asc' )->get();
        return response()->json( ['data' => $items] );
    }

    /**
     * Delete a single overtime entry.
     */
    public function destroy( Request $request, $id ) {
        $role = session( 'user_role' );
        if ( !$role || !in_array( $role, ['admin', 'super_admin'] ) ) {
            return response()->json( ['message' => 'Unauthorized'], 403 );
        }

        $entry = Overtime::find( $id );
        if ( !$entry ) {
            return response()->json( ['message' => 'Not found'], 404 );
        }

        $entry->delete();
        return response()->json( ['deleted' => true] );
    }

    /**
     * Delete all overtime entries (super_admin only).
     */
    public function destroyAll( Request $request ) {
        $role = session( 'user_role' );
        if ( !$role || $role !== 'super_admin' ) {
            return response()->json( ['message' => 'Unauthorized'], 403 );
        }

        Overtime::query()->delete();
        return response()->json( ['deleted' => true] );
    }
}
