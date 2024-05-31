<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Ramsey\Uuid\Uuid;

class GuestController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('guests.index', [
      'guests' => Guest::with('user')->where('user_id', auth()->id())->latest()->get(),
    ]);
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
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'whatsapp' => 'required|string|max:15',
    ]);

    $validated['qrcode_checkin'] = Uuid::uuid4()->toString();
    $validated['qrcode_checkout'] = Uuid::uuid4()->toString();

    $request->user()->guests()->create($validated);

    return redirect(route('guests.index'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Guest $guest)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Guest $guest)
  {
    Gate::authorize('update', $guest);

    return view('guests.edit', [
      'guest' => $guest,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Guest $guest)
  {
    Gate::authorize('update', $guest);

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'whatsapp' => 'required|string|max:15',
    ]);

    $validated['qrcode_checkin'] = Uuid::uuid4()->toString();
    $validated['qrcode_checkout'] = Uuid::uuid4()->toString();

    $guest->update($validated);

    return redirect(route('guests.index'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Guest $guest)
  {
    Gate::authorize('delete', $guest);

    $guest->delete();

    return redirect(route('guests.index'));
  }

  public function checkinCheckout(Guest $guest)
  {
    $guest->checkin();
    return redirect(route('guests.index'));
  }
}
