<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacts;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    public function getAllContacts()
    {
        $contacts = Contacts::all();

        return response()->json([
            'data' => $contacts,
        ]);
    }

    public function getContactById($id)
    {
        $contact = Contacts::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Contact not found',
            ], 404);
        }

        return response()->json([
            'data' => $contact,
        ]);
    }

    public function createNewContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'j_kelamin' => 'required|in:L,P',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact = new Contacts;
        $contact->name = $request->name;
        $contact->j_kelamin = $request->j_kelamin;
        $contact->no_hp = $request->no_hp;
        $contact->save();

        return response()->json([
            'message' => 'Contact created successfully',
            'data' => $contact,
        ], 201);
    }

    public function updateContact(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'j_kelamin' => 'required|in:L,P',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact = Contacts::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Contact not found',
            ], 404);
        }

        $contact->name = $request->name;
        $contact->j_kelamin = $request->j_kelamin;
        $contact->no_hp = $request->no_hp;
        $contact->save();

        return response()->json([
            'message' => 'Contact updated successfully',
            'data' => $contact,
        ]);
    }

    public function deleteContact($id)
    {
        $contact = Contacts::find($id);

        if (!$contact) {
            return response()->json([
                'message' => 'Contact not found',
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully',
        ]);
    }
}
