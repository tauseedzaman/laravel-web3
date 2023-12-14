<?php

namespace App\Livewire;

use App\Models\TokenTransaction;
use App\Models\UserToken;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log as FacadesLog;
use Livewire\Component;
use Log;

class TokenSale extends Component
{

    public $user;
    public $walletAddress;
    public $buyAmount;
    public $tokenPrice = 0.001; // Price of 1 token in ETH

    // walletConnected event listener
    protected $listeners = ['wallet-connected' => 'ConnectedWallet'];

    protected $rules = [
        'buyAmount' => 'required|numeric|min:0.01', // Adjust validation rules as needed
    ];

    public function mount()
    {
        // You may load user data or perform other initialization here
        $this->user = auth()->user();
        $this->walletAddress = $this->user->wallet_address;
    }

    public function connectWallet()
    {
        $this->dispatch('show-connect-wallet-modal');
    }


    public function buyTokens()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            // Update user token balance in the database
            $transaction = TokenTransaction::Create(
                [
                    'user_id' => auth()->id(),
                    'balance' => $this->buyAmount,
                    'token_address' => $this->walletAddress
                ]
            );

            // Send tokens to the user using Ethereum contract interaction
            $this->sendTokensToUser($this->buyAmount, $transaction->id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        // Clear form fields
        $this->buyAmount = '';
    }

    protected function sendTokensToUser($amount, $trx_id)
    {
        // Make an HTTP POST request to the Node.js route
        $response = Http::post('http://localhost:3000/api/send-tokens', [
            'to_address' => auth()->user()->wallet_address,
            'amount' => $amount,
        ])->throw();

        $responseData = $response->json();
        // Update transaction hash and status
        $transaction = TokenTransaction::findOrFail($trx_id);
        $transaction->transaction_hash = $responseData['trxhash']; // Adjust the key based on the actual response structure
        $transaction->status = "completed";
        $transaction->save();

        FacadesLog::info('Node.js response:', $responseData);
    }


    public function ConnectedWallet($account)
    {
        $this->walletAddress = $account;
        $user = auth()->user();
        $user->wallet_address = $account;
        $user->save();
    }

    public function render()
    {
        return view('livewire.token-sale', [
            'userTokens' => TokenTransaction::where('user_id', $this->user->id)->latest()->get()
        ]);
    }
}
