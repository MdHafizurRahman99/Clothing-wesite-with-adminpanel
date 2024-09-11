<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


                return view('admin.orders.list', [
                    'orders' => Order::latest()->get(),
                ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $adminOrder)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $adminOrder)
    {
        return view('admin.orders.details', [
            'order' => $adminOrder,
            'order_details' => OrderDetail::where('order_id', $adminOrder->id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $adminOrder)
    {
        //
    }

    public function updateOrderStatus(Request $request, $orderId)
{
    // Validate the incoming request
    $request->validate([
        'order_status' => 'required|string'
    ]);

    // Find the order
    $order = Order::find($orderId);

    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    // Update the order status
    $order->order_status = $request->order_status;
    $order->save();

    // Return success response
    return response()->json(['success' => 'Order status updated successfully']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $adminOrder)
    {
        //
    }
}
