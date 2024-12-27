<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\MyEvent;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Associate;
use App\Models\EventType;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MyEventRepository;
use App\Http\Requests\MyEvent\CreateMyEventRequest;
use App\Http\Requests\MyEvent\UpdateMyEventRequest;

class MyEventController extends Controller
{
    private MyEventRepository $myEventRepository;

    public function __construct(MyEventRepository $myEventRepository)
    {
        $this->myEventRepository = $myEventRepository;
    }

    public function index()
    {
        return view('my_event.my_events');
    }

    public function create()
    {
        $event_types = EventType::query()->pluck('event_type_name', 'id');

        $users = $users = User::query()->get()->mapWithKeys(function($user) {
            return [$user->id => $user->first_name . ' ' . $user->last_name];
        });

        $products = Product::query()->select('products.id', 'product_name', 'product_sku', 'product_type')
            ->leftjoin('product_types', 'products.product_type_id', '=', 'product_types.id')
            ->get();

        $customers = Customer::query()
            ->pluck('customer_name', 'id')
            ->mapWithKeys(function ($customer_name, $id) {
                return ['customer_' . $id => ['party_name_id' => $id, 'name' => $customer_name, 'type' => 'customer']];
            })
            ->toArray();

        $associates = Associate::query()
            ->pluck('associate_name', 'id')
            ->mapWithKeys(function ($associate_name, $id) {
                return ['associate_' . $id => ['party_name_id' => $id, 'name' => $associate_name, 'type' => 'associate']];
            })
            ->toArray();

        $expenditures = Expenditure::query()
            ->pluck('expenditure_name', 'id')
            ->mapWithKeys(function ($expenditure_name, $id) {
                return ['expenditure_' . $id => ['party_name_id' => $id, 'name' => $expenditure_name, 'type' => 'expenditure']];
            })
            ->toArray();

        $suppliers = Supplier::query()
            ->pluck('supplier_name', 'id')
            ->mapWithKeys(function ($supplier_name, $id) {
                return ['supplier_' . $id => ['party_name_id' => $id, 'name' => $supplier_name, 'type' => 'supplier']];
            })
            ->toArray();

// Combine the four arrays
        $parties = array_merge($customers, $associates, $expenditures, $suppliers);

        return view('my_event.create', compact('event_types', 'users', 'parties', 'products'));
    }

    public function store(CreateMyEventRequest $request)
    {
        $input = $request->all();
        $request['entered_by_id'] = auth()->user()->id;
        $follower = $input['follower_id'] ?? '';
        if (!empty($follower)) {
            $request['follower_id'] = implode('~', $follower);
        } else {
            $request['follower_id'] = null;
        }

        $product = $input['product_id'] ?? '';
        if (!empty($product)) {
            $request['product_id'] = implode('~', $product);
        } else {
            $request['product_id'] = null;
        }
        $party_name = $input['party_name'] ?? '';
        if (!empty($party_name)) {
           $party = explode(':', $party_name);
            $request['party_name_id'] = $party[0];
            $request['party_name'] = $party[1];
        } else {
            $request['party_name_id'] = null;
            $request['party_name'] = null;
        }

        try {
            $this->myEventRepository->store($request->only('event_type_id', 'entered_by_id', 'assigned_to_id', 'schedule_date', 'schedule_time', 'event_title', 'party_name', 'party_name_id', 'follower_id', 'description', 'product_id', 'price'));
            return response()->json(['status' => 'success', 'msg' => 'Event saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving event: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the event.']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $my_event = MyEvent::findOrFail($id);
        $event_types = EventType::query()->pluck('event_type_name', 'id');
        $users = $users = User::query()->get()->mapWithKeys(function($user) {
            return [$user->id => $user->first_name . ' ' . $user->last_name];
        });
        $products = Product::query()->select('products.id', 'product_name', 'product_sku', 'product_type')
        ->join('product_types', 'products.product_type_id', '=', 'product_types.id')
        ->get();

    $customers = Customer::query()
        ->pluck('customer_name', 'id')
        ->mapWithKeys(function ($customer_name, $id) {
            return ['customer_' . $id => ['party_name_id' => $id, 'name' => $customer_name, 'type' => 'customer']];
        })
        ->toArray();

    $associates = Associate::query()
        ->pluck('associate_name', 'id')
        ->mapWithKeys(function ($associate_name, $id) {
            return ['associate_' . $id => ['party_name_id' => $id, 'name' => $associate_name, 'type' => 'associate']];
        })
        ->toArray();

    $expenditures = Expenditure::query()
        ->pluck('expenditure_name', 'id')
        ->mapWithKeys(function ($expenditure_name, $id) {
            return ['expenditure_' . $id => ['party_name_id' => $id, 'name' => $expenditure_name, 'type' => 'expenditure']];
        })
        ->toArray();

    $suppliers = Supplier::query()
        ->pluck('supplier_name', 'id')
        ->mapWithKeys(function ($supplier_name, $id) {
            return ['supplier_' . $id => ['party_name_id' => $id, 'name' => $supplier_name, 'type' => 'supplier']];
        })
        ->toArray();

// Combine the four arrays
    $parties = array_merge($customers, $associates, $expenditures, $suppliers);
        return view('my_event.__edit', compact('my_event', 'event_types', 'users', 'parties', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMyEventRequest $request, MyEvent $myEvent)
    {
        $input = $request->all();
        $follower = $input['follower_id'] ?? '';
        if (!empty($follower)) {
            $request['follower_id'] = implode('~', $follower);
        } else {
            $request['follower_id'] = null;
        }

        $product = $input['product_id'] ?? '';
        if (!empty($product)) {
            $request['product_id'] = implode('~', $product);
        } else {
            $request['product_id'] = null;
        }

        $party_name = $input['party_name'] ?? '';
        if (!empty($party_name)) {
           $party = explode(':', $party_name);
            $request['party_name_id'] = $party[0];
            $request['party_name'] = $party[1];
        } else {
            $request['party_name_id'] = null;
            $request['party_name'] = null;
        }

        try {
            $this->myEventRepository->update($request->only('event_type_id', 'assigned_to_id', 'schedule_date', 'schedule_time', 'event_title', 'party_name',  'party_name_id', 'follower_id', 'description', 'product_id', 'price'), $request->event_id);
            return response()->json(['status' => 'success', 'msg' => 'Event saved successfully.']);
        } catch (Exception $e) {
            Log::error('Error saving event: ' . $e->getMessage());
            return response()->json(['status' => 'false', 'msg' => 'An error occurred while saving the event.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $myEvent = $this->myEventRepository->findOrFail($id);
            if ($myEvent) {
                $this->myEventRepository->delete($id);
                return response()->json(['status' => 'success', 'msg' => 'My Event deleted successfully.']);
            } else {
                return response()->json(['status' => 'false', 'msg' => 'My Event not found.']);
            }
        } catch (Exception $e) {
            Log::error('Error deleting my event : ' . $e->getMessage());
            return response()->json(['status' => $data->status, 'msg' => $data->msg], 500);
        }
        return $response;
    }

    public function getMyEventDataTableList(Request $request)
    {
        return $this->myEventRepository->dataTable($request);
    }

    public function setAsComplete($id)
    {
        try {
            $event = $this->myEventRepository->findOrFail($id);
            $newStatus       = $event->mark_as_complete == 1 ? 0 : 1;
            $event->mark_as_complete = $newStatus;
            $event->save();

            return response()->json([
                'status'     => 'success',
                'new_status' => $newStatus,
                'msg'        => 'Set As Completed.',
            ]);
        } catch (Exception $e) {
            Log::error('Error updating status: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'msg'    => 'Failed to update status.',
            ], 500);
        }
    }

    public function show($id)
    {
        $my_event = MyEvent::with(['event_type', 'users'])->findOrFail($id);
        $followerIds = explode('~', $my_event->follower_id);
        // Fetch users whose IDs are in the follower_ids
        $followers = User::whereIn('id', $followerIds)->select('first_name', 'last_name')->get();

        $productIds = explode('~', $my_event->product_id);

        // Fetch product IDs in the products
        $products = Product::whereIn('id', $productIds)->select('product_name')->get();

        return view('my_event.__show', compact('my_event', 'followers', 'products'));
    }
}
