<?php

return [
    'fail:array'    => 'o campo ":field" deve ser um array',
    'fail:notArray' => 'o campo ":field" não deve conter um array',
    
    'fail:boolean'    => 'o campo ":field" deve ser um booleano',
    'fail:notBoolean' => 'o campo ":field" não deve conter um booleano',
    
    'fail:cep'    => 'o campo ":field" deve ser um CEP válido',
    'fail:notCep' => 'o campo ":field" não deve conter um CEP',
    
    'fail:cnpj'    => 'o campo ":field" deve ser um CNPJ válido',
    'fail:notCnpj' => 'o campo ":field" não deve conter um CNPJ',
    
    'fail:cpf'    => 'o campo ":field" deve ser um CPF válido',
    'fail:notCpf' => 'o campo ":field" não deve conter um CPF',
    
    'fail:date'    => 'o campo ":field" deve ser uma data válida',
    'fail:notDate' => 'o campo ":field" não deve conter uma data',
    
    'fail:email'    => 'o campo ":field" deve ser um e-mail válido',
    'fail:notEmail' => 'o campo ":field" não deve conter um e-mail',
    
    'fail:empty'    => 'o campo ":field" deve estar vazio',
    'fail:notEmpty' => 'o campo ":field" não deve estar vazio',
    
    'fail:equals' => 'o campo ":field" não possui o valor esperado',
    
    'fail:integer'    => 'o campo ":field" deve ser um número inteiro',
    'fail:notInteger' => 'o campo ":field" não deve ser um número inteiro',
    
    'fail:mask'    => 'o campo ":field" deve ser definido no formato especificado',
    'fail:notMask' => 'o campo ":field" não pode ser definido no formato especificado',
    
    'fail:maxLength' =>
        '{1} o campo ":field" deve possuir no máximo um caractere|' .
        'o campo ":field" deve possuir no máximo :length caracteres',
    
    'fail:minLength' =>
        '{1} o campo ":field" deve possuir no mínimo um caractere|' .
        'o campo ":field" deve possuir no mínimo :length caracteres',
    
    'fail:required' => 'o campo ":field" é obrigatório',
    
    'fail:positive'    => 'o campo ":field" deve ser um número positivo',
    'fail:notPositive' => 'o campo ":field" não deve ser um número positivo',
    
    'fail:sameLength' =>
        '{1} o campo ":field" deve possuir exatamente um caractere|' .
        'o campo ":field" deve possuir exatamente :length caracteres',
    
    'fail:string'    => 'o campo ":field" deve ser uma string',
    'fail:notString' => 'o campo ":field" não deve ser uma string',
];
