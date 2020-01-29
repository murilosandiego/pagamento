<?php
namespace Murilo\Pagamento;

use Murilo\Pagamento\Contracts\Conta as ContaContract;
use Murilo\Pagamento\Contracts\Pessoa as PessoaContract;

/**
 * Class Conta
 * @package Murilo\Pagamento
 */
class Conta implements ContaContract
{
    /**
     * @var string
     */
    protected $banco;

    /**
     * @var string
     */
    protected $bancoNome;

    /**
     * @var string
     */
    protected $agencia;

    /**
     * @var string
     */
    protected $agenciaDv;

    /**
     * @var string
     */
    protected $conta;

    /**
     * @var string
     */
    protected $contaDv;

    /**
     * @var PessoaContract
     */
    protected $pessoa;

    /**
     * Cria a conta passando os parametros.
     *
     * @param $banco
     * @param $agencia
     * @param $agenciaDv
     * @param $conta
     * @param $contaDv
     * @param $pessoa
     * @return Conta
     */
    public static function create($banco, $agencia, $agenciaDv, $conta, $contaDv, $pessoa)
    {
        return new static([
            'banco' => $banco,
            'agencia' => $agencia,
            'agenciaDv' => $agenciaDv,
            'conta' => $conta,
            'contaDv' => $contaDv,
            'pessoa' => Pessoa::create($pessoa),
        ]);
    }

    /**
     * Construtor
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        Util::fillClass($this, $params);
        $this->setBancoNome(isset(Util::$bancos[$this->banco]) ? Util::$bancos[$this->banco] : null);
    }

    /**
     * @return string
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param string $banco
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
    }

    /**
     * @return string
     */
    public function getBancoNome()
    {
        return $this->bancoNome;
    }

    /**
     * @param string $bancoNome
     */
    public function setBancoNome($bancoNome)
    {
        $this->bancoNome = $bancoNome;
    }

    /**
     * @return string
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param string $agencia
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
    }

    /**
     * @return string
     */
    public function getAgenciaDv()
    {
        return $this->agenciaDv;
    }

    /**
     * @param string $agenciaDv
     */
    public function setAgenciaDv($agenciaDv)
    {
        $this->agenciaDv = $agenciaDv;
    }

    /**
     * @return string
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param string $conta
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
    }

    /**
     * @return string
     */
    public function getContaDv()
    {
        return $this->contaDv;
    }

    /**
     * @param string $contaDv
     */
    public function setContaDv($contaDv)
    {
        $this->contaDv = $contaDv;
    }

    /**
     * @return PessoaContract
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param PessoaContract $pessoa
     */
    public function setPessoa($pessoa)
    {
        $this->pessoa = $pessoa;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'banco' => $this->getBanco(),
            'bancoNome' => $this->getBancoNome(),
            'agencia' => $this->getAgencia(),
            'agenciaDv' => $this->getAgenciaDv(),
            'conta' => $this->getConta(),
            'contaDv' => $this->getContaDv(),
            'pessoa' => is_object($this->getPessoa()) && property_exists($this->getPessoa(), 'toArray') ? $this->getPessoa()->toArray() : $this->getPessoa(),
        ];
    }
}
