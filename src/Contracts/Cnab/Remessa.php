<?php
namespace Murilo\Pagamento\Contracts\Cnab;

interface Remessa extends Cnab
{
    public function gerar();
}
