# Pagamento, Remessa e Retorno PHP
Pacote para gerar pagamentos através de arquivos de remessas e leitura de 
retorno. Fork do projeto [yii2-boleto-remessa](http://newerton.github.io/yii2-boleto-remessa/)

## Requerimentos
- [PHP Extensão Intl](http://php.net/manual/pt_BR/book.intl.php)


## Bancos suportados
Atualmente apenas o banco Sicredi é suportado na modalidade TED – Transferência entre Clientes;

## Instalação
Via composer:

```
composer require murilosandiego/pagamento
```

Ou adicione manualmente ao seu composer.json:

```
"murilosandiego/pagamento": "dev-master"
```

## Gerar Pagamento


### Criando a empresa ou favorecido

```php
$empresa = new \Murilo\Pagamento\Pessoa(
    [
        'nome'        => 'ACME',
        'endereco'    => 'Rua UM',
        'numero'      => '123',
        'bairro'      => 'Bairro',
        'cep'         => '99999-999',
        'uf'          => 'UF',
        'cidade'      => 'Cidade',
        'documento'   => '99.999.999/0001-99',
    ]
);

$favorecido = new \Murilo\Pagamento\Pessoa(
    [
        'nome'      => 'Favorecido',
        'endereco'  => 'Rua Um',
        'numero'    => '123',
        'bairro'    => 'Bairro',
        'cep'       => '00000-000',
        'uf'        => 'UF',
        'cidade'    => 'Cidade',
        'documento' => '999.999.999-99',
    ]
);
```

### Criando o pagamento

```php
$pagamento = new Murilo\Pagamento\Pagamento\Banco\Sicredi(
    [
        'data' => new \Carbon\Carbon(),
        'finalidade' => '00011',
        'valor' => 10,
        'numeroDocumento' => 1,
        'banco' => 237,
        'agencia' => 9999,
        'conta' => 999999,
        'contaDv' => 9,
        'favorecido' => $favorecido
    ]
);
```


## Gerar remessa

```php
$remessa = new \Murilo\Pagamento\Cnab\Remessa\Cnab240\Banco\Sicredi(
    [
        'agencia'      => 9999,
        'agenciaDv'    => 9,
        'carteira'     => '1',
        'conta'        => 99999,
        'contaDv'      => 9,
        'idremessa'    => 1,
        'beneficiario' => $empresa,
        'codigoCliente' => '99AA'
    ]
);

// Adicionar um pagamento
$remessa->addPagamento($pagamento);

// Ou para adicionar um array de boletos
$pagamentos = [];
$pagamentos[] = $pagamento1;
$pagamentos[] = $pagamento2;
$pagamentos[] = $pagamento3;
$remessa->addPagamentos($boletos);

//Gerar remessa
echo $remessa->gerar();

//Salvar remessa
echo $remessa->save(__DIR__ . DIRECTORY_SEPARATOR . 'arquivos' . DIRECTORY_SEPARATOR . 'sicredi_pagamento.txt');
```
## Autores

* **Murilo Sandiego** - *Initial work* - [murilosandiego](https://github.com/murilosandiego)

## Licença

Este projeto está licenciado sob a licença MIT - consulte o arquivo [LICENSE.md](LICENSE.md) para obter detalhes
