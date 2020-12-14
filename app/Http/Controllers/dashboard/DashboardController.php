<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Book;


class DashboardController extends Controller
{
    private $book;
 

function __construct(Book $book)
    {
        $this->book = $book;
        $this->middleware('auth');

        
    }


    public function index() {
        //display list
        
         $books = $this->book->all();
        $archive = $this->book->all();


        return view('dashboard.index', compact('books','archive'));


    }
    public function books() {
        //
            $books = $this->book->paginate(15);
           
            

        return view('dashboard.books',compact('books'));


    }

    public function store(Request $request) {
        //store data

        $request->validate([
            'title' => 'required',
            'isbn' => 'required',
            'description' => 'required',
            'about_author' => 'required',

        ]);

        $this->book->create(
            [
                'title' => $request->title,
                'isbn' => $request->isbn,
                'description' => $request->description,
                'about_author' => $request->about_author,
    
            ]

        );

        return redirect()->back()->with('success','Book added successfully!');

    }
    public function update(Request $request, $id){

        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'description' => 'required',
            'award_amount' => 'required',
            'enrolment_fee' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'voting_type' => 'required',
        ]);

        $this->challenge->find($id)->update(
            [
                'category_id' => $request->category,
                'title' => $request->title,
                'description' => $request->description,
                'award_amount' => $request->award_amount,
                'enrolment_fee' => $request->enrolment_fee,
                'start_time' =>$request->start_time,
                'end_time' => $request->end_time,
                'voting_type' => $request->voting_type
            ]
        );

        return back()->withMessage('Daily challenge updated successfully!');

    }
   
    public function destroy($id){
        
        $this->challenge->find($id)->delete();

        return back()->withMessage('Daily challenge deleted successfully!');
    }
    
    
    public function store_fixed_amount(Request $request) {
        //store data

        $request->validate([
            'fixed_amount' => 'required',
        ]);

        $record = $this->fixed_amount->where('challenge_id', request('challenge_id'))->first();

        if ($record !== null) {
            $record->update(['fixed_amount' => request('fixed_amount')]);
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    
                    'award_type'=>'fixed'
                ]
            );
        } else {
            $record = $this->fixed_amount->create([
            'fixed_amount' => request('fixed_amount'),
            'challenge_id' => request('challenge_id')
            ]);
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    'status'=>'1',
                    'award_type'=>'fixed'
                ]
            );

        }
        return redirect()->back()->withMessage('Fixed amount added successfully!');

    }
    public function store_incremental(Request $request) {
        //store data

        $request->validate([
            'percentage' => 'required',
            'minimum_amount' => 'required',
            'disbursement' => 'required',
        ]);

        $record = $this->incremental->where('challenge_id', request('challenge_id'))->first();

        if ($record !== null) {
            $record->update(
                [
                    'percentage' => request('percentage'),
                    'minimum_amount' => request('minimum_amount'),
                    'disbursement' => request('disbursement')
                    ]
            );
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    
                    'award_type'=>'incremental'
                ]
            );
        } else {
            $record = $this->incremental->create([
                'percentage' => request('percentage'),
                'minimum_amount' => request('minimum_amount'),
                'disbursement' => request('disbursement'),
                'challenge_id' => request('challenge_id'),
            ]);
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    'status'=>'1',
                    'award_type'=>'incremental'
                ]
            );

        }
        return redirect()->back()->withMessage('Incremental amount added successfully!');

    }
    public function store_multiple_winners_yes(Request $request) {
        //store data

        $request->validate([
            'main_winner_disbursement_percentage' => 'required',
            'main_winner_percentage_price' => 'required',
            'first_runner_up_disbursement_percentage' => 'required',
            'first_runner_up_percentage_price' => 'required',
            'second_runner_up_disbursement_percentage' => 'required',
            'second_runner_up_percentage_price' => 'required',
        ]);

        $record = $this->multiple_winner_yes->where('challenge_id', request('challenge_id'))->first();

        if ($record !== null) {
            $sum = $request->main_winner_percentage_price + $request->first_runner_up_percentage_price + $request->second_runner_up_percentage_price;
            if ($sum == 100) {
                $record->update(
                    [
                        'main_winner_disbursement_percentage' => request('main_winner_disbursement_percentage'),
                        'main_winner_percentage_price' => request('main_winner_percentage_price'),
                        'first_runner_up_disbursement_percentage' => request('first_runner_up_disbursement_percentage'),
                        'first_runner_up_percentage_price' => request('first_runner_up_percentage_price'),
                        'second_runner_up_disbursement_percentage' => request('second_runner_up_disbursement_percentage'),
                        'second_runner_up_percentage_price' => request('second_runner_up_percentage_price'),
                        ]
                );
            } else {
                return redirect()->back()->withError('Percentage Prices must sum up to 100')->withAlertClass('alert-danger');

            }
            
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    
                    'award_type'=>'multiple winner yes'
                ]
            );
        } else {
            $sum = $request->main_winner_percentage_price + $request->first_runner_up_percentage_price + $request->second_runner_up_percentage_price;
            if ($sum == 100) {
                $record = $this->multiple_winner_yes->create([
                'main_winner_disbursement_percentage' => request('main_winner_disbursement_percentage'),
                'main_winner_percentage_price' => request('main_winner_percentage_price'),
                'first_runner_up_disbursement_percentage' => request('first_runner_up_disbursement_percentage'),
                'first_runner_up_percentage_price' => request('first_runner_up_percentage_price'),
                'second_runner_up_disbursement_percentage' => request('second_runner_up_disbursement_percentage'),
                'second_runner_up_percentage_price' => request('second_runner_up_percentage_price'),
                'challenge_id' => request('challenge_id')
            ]);
        } else {
            return redirect()->back()->withError('Percentage Prices must sum up to 100')->withAlertClass('alert-danger');

        }
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    'status'=>'1',
                    'award_type'=>'multiple winner yes'
                ]
            );

        }
        return redirect()->back()->withMessage('Amount added successfully!');

    }
    public function store_multiple_winners_no(Request $request) {
        //store data

        $request->validate([
            'disbursement' => 'required',
        ]);

        $record = $this->multiple_winner_no->where('challenge_id', request('challenge_id'))->first();

        if ($record !== null) {
            $record->update(['disbursement' => request('disbursement')]);
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    
                    'award_type'=>'multiple winners no'
                ]
            );
        } else {
            $record = $this->multiple_winner_no->create([
            'disbursement' => request('disbursement'),
            'challenge_id' => request('challenge_id')
            ]);
            $record = $this->challenge->find(request('challenge_id'))->update(
                [
                    'status'=>'1',
                    'award_type'=>'multiple winners no'
                ]
            );

        }
        return redirect()->back()->withMessage('Amount added successfully!');

    }
    
}