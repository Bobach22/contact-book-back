<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\Email;
use App\Models\Phone;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query=$request->query('q');
        $contacts=[];
        if($query){
            $contacts=Contact::whereLike(['name','phones.phone','emails.email'],$query);
            return new ContactCollection($contacts->orderBy('created_at', 'DESC')->paginate(50));
        }else{
            return new ContactCollection(Contact::orderBy('created_at', 'DESC')->paginate(50));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $data=$request->validated();

        $contact=Contact::create([
            'name'=>$data['name']
        ]);

        foreach($data['emails'] as $email){
            Email::create([
                'contact_id'=>$contact->id,
                'email'=>$email['email']
            ]);
        }

        foreach($data['phones'] as $phone){
            Phone::create([
                'contact_id'=>$contact->id,
                'phone'=>$phone['phone']
            ]);
        }

        return response()->json(null,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ContactResource(Contact::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactUpdateRequest $request, $id)
    {
        $data=$request->validated();
        $contact=Contact::findOrFail($id);
        $contact->update(['name'=>$data['name']]);
        
        $email_ids=[];
        foreach($data['emails'] as $email){
            if($email['id']){
            array_push($email_ids,$email['id']);
            }
        }

        $db_email_ids=$contact->emails->pluck('id')->toArray();
        foreach($db_email_ids as $id){
            if(!in_array($id,$email_ids)){
                Email::destroy($id);
            }
        }

        $phone_ids=[];
        foreach($data['phones'] as $phone){
            if($phone['id']){
            array_push($phone_ids,$phone['id']);
            }
        }

        $db_phone_ids=$contact->phones->pluck('id')->toArray();
        foreach($db_phone_ids as $id){
            if(!in_array($id,$phone_ids)){
                Phone::destroy($id);
            }
        }

        foreach($data['emails'] as $email){
            if(empty($email['id'])){
                Email::create([
                    'contact_id'=>$contact->id,
                    'email'=>$email['email']
                ]);
            }else{
                Email::find($email['id'])->update([
                    'email'=>$email['email']
                ]);
            }
        }

        foreach($data['phones'] as $phone){
            if(empty($phone['id'])){
                Phone::create([
                    'contact_id'=>$contact->id,
                    'phone'=>$phone['phone']
                ]);
            }else{
                Phone::find($phone['id'])->update([
                    'phone'=>$phone['phone']
                ]);
            }
        }

        return response()->json(null,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return response()->json(null,204);
    }
}
