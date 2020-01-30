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
            'pessoa' => $pessoa,
        ]);
    }

    /**
     * Construtor
     *
     * @param array $params
     */
    public function __construct($params = [])
    {
        if (isset($params['pessoa']) && !($params['pessoa'] instanceof Pessoa)) {
            $params['pessoa'] = new Pessoa($params['pessoa']);
        }

        Util::fillClass($this, $params);
    }

    /**
     * @return string
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param $banco
     * @return Conta
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
        $this->setBancoNome(isset(Util::$bancos[$this->banco]) ? Util::$bancos[$this->banco] : null);
        return $this;
    }

    /**
     * @return string
     */
    public function getBancoNome()
    {
        return $this->bancoNome;
    }

    /**
     * @param $bancoNome
     * @return Conta
     */
    public function setBancoNome($bancoNome)
    {
        $this->bancoNome = $bancoNome;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param $agencia
     * @return Conta
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgenciaDv()
    {
        return $this->agenciaDv;
    }

    /**
     * @param $agenciaDv
     * @return Conta
     */
    public function setAgenciaDv($agenciaDv)
    {
        $this->agenciaDv = $agenciaDv;
        return $this;
    }

    /**
     * @return string
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param $conta
     * @return Conta
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
        return $this;
    }

    /**
     * @return string
     */
    public function getContaDv()
    {
        return $this->contaDv;
    }

    /**
     * @param $contaDv
     * @return Conta
     */
    public function setContaDv($contaDv)
    {
        $this->contaDv = $contaDv;
        return $this;
    }

    /**
     * @return PessoaContract
     */
    public function getPessoa()
    {
        return $this->pessoa;
    }

    /**
     * @param $pessoa
     * @return Conta
     */
    public function setPessoa($pessoa)
    {
        $this->pessoa = $pessoa;
        return $this;
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
