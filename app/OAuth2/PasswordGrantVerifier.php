<?php

namespace App\OAuth2;

use Illuminate\Support\Facades\Auth;

class PasswordGrantVerifier
{
  public function verify($username, $password)
  {

      \Storage::append('login.log', 'LOGIN DATA: ' .date("Y-m-d H:i:s"));

      $credentials = [
        'email'    => $username,
        'password' => $password,
      ];

      \Storage::append('login.log', 'DADOS LOGIN E-MAIL: ' .$credentials['email']. ' SENHA: '.$credentials['password']);

      if (Auth::once($credentials)) {
          \Storage::append('login.log', 'LOGIN SUCESSO');
          \Storage::append('login.log', 'LOGIN FIM');
          return Auth::user()->id;
      }

      \Storage::append('login.log', 'LOGIN FALHOU: ' .$credentials['email']);
      \Storage::append('login.log', 'LOGIN FIM');

      return false;
  }
}