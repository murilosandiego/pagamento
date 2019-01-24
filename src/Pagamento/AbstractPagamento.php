<?php

namespace Murilo\Pagamento\Pagamento;

use Carbon\Carbon;
use Murilo\Pagamento\Contracts\Pessoa as PessoaContract;
use Murilo\Pagamento\Contracts\Pagamento\Pagamento as PagamentoContract;
use Murilo\Pagamento\Util;


abstract class AbstractPagamento implements PagamentoContract
{
    /**
     * Campos que são necessários para o pagamento
     *
     * @var array
     */
    private $camposObrigatorios = [
        'bancoFavorecido',
        'agenciaFavorecido',
        'contaFavorecido',
        'contaDvFavorecido',
    ];

    protected $protectedFields = [
        'nossoNumero',
    ];

    protected $tipoMovimento = PagamentoContract::TIPO_MOVIMENTO_INCLUSAO;

    protected $instrucaoMovimento;

    protected $banco;

    protected $numeroDocumento;

    protected $data;

    protected $tipoMoeda = 'BRL';

    protected $finalidade;

    /**
     * Finalidades TED
     *
     * @var array
     */
    protected $finalidadesTED = [
        '00001',
        '00002',
        '00003',
        '00004',
        '00005',
        '00006',
        '00007',
        '00008',
        '00009',
        '00010',
        '00011',
        '00101',
    ];

    /**
     * Valor total do pagamento
     *
     * @var float
     */
    protected $valor;

    /**
     * Agência
     *
     * @var string
     */
    protected $agencia;

    /**
     * Dígito da agência
     *
     * @var string
     */
    protected $agenciaDv;

    /**
     * Conta
     *
     * @var string
     */
    protected $conta;

    /**
     * Dígito da conta
     *
     * @var string
     */
    protected $contaDv;


    /**
     * Entidade favorecida
     *
     * @var PessoaContract
     */
    protected $favorecido;


    /**
     * Construtor
     *
     * @param array $params Parâmetros iniciais para construção do objeto
     */
    public function __construct($params = [])
    {
        Util::fillClass($this, $params);
        // Marca a data de pagamento para hoje, caso não especificada
        if (!$this->getData()) {
            $this->setData(new Carbon());
        }
    }

    /**
     * @return mixed
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @param mixed $banco
     * @return AbstractPagamento
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * @param mixed $agencia
     * @return AbstractPagamento
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
        return $this;
    }

    /**
     * @return array
     */
    public function getProtectedFields()
    {
        return $this->protectedFields;
    }

    /**
     * Seta os campos obrigatórios
     *
     * @return $this
     */
    protected function setCamposObrigatorios()
    {
        $args = func_get_args();
        $this->camposObrigatorios = [];
        foreach ($args as $arg) {
            $this->addCampoObrigatorio($arg);
        }
        return $this;
    }

    /**
     * Adiciona os campos obrigatórios
     *
     * @return $this
     */
    protected function addCampoObrigatorio()
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            !is_array($arg) || call_user_func_array([$this, __FUNCTION__], $arg);
            !is_string($arg) || array_push($this->camposObrigatorios, $arg);
        }
        return $this;
    }

    /**
     * Define o dígito da agência
     *
     * @param  string $agenciaDv
     *
     * @return AbstractPagamento
     */
    public function setAgenciaDv($agenciaDv)
    {
        $this->agenciaDv = $agenciaDv;

        return $this;
    }

    /**
     * Retorna o dígito da agência
     *
     * @return string
     */
    public function getAgenciaDv()
    {
        return $this->agenciaDv;
    }

    /**
     * @return int
     */
    public function getTipoMovimento()
    {
        return $this->tipoMovimento;
    }

    /**
     * @param int $tipoMovimento
     * @return AbstractPagamento
     */
    public function setTipoMovimento($tipoMovimento)
    {
        $this->tipoMovimento = $tipoMovimento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInstrucaoMovimento()
    {
        return $this->instrucaoMovimento;
    }

    /**
     * @param mixed $instrucaoMovimento
     * @return AbstractPagamento
     */
    public function setInstrucaoMovimento($instrucaoMovimento)
    {
        $this->instrucaoMovimento = $instrucaoMovimento;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoMoeda()
    {
        return $this->tipoMoeda;
    }

    /**
     * @param string $tipoMoeda
     * @return AbstractPagamento
     */
    public function setTipoMoeda($tipoMoeda)
    {
        $this->tipoMoeda = $tipoMoeda;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFinalidade()
    {
        return $this->finalidade;
    }

    /**
     * @param $finalidade
     * @return $this
     * @throws \Exception
     */
    public function setFinalidade($finalidade)
    {
        if (!in_array($finalidade, $this->getFinalidadesTED()))
            throw new \Exception('Finalidade não encontrada');

        $this->finalidade = $finalidade;
        return $this;
    }

    /**
     * @return array
     */
    public function getFinalidadesTED()
    {
        return $this->finalidadesTED;
    }

    /**
     * @param array $finalidadesTED
     * @return AbstractPagamento
     */
    public function setFinalidadesTED($finalidadesTED)
    {
        $this->finalidadesTED = $finalidadesTED;
        return $this;
    }


    /**
     * Define a entidade favorecido
     *
     * @param $favorecido
     *
     * @return AbstractPagamento
     * @throws \Exception
     */
    public function setFavorecido($favorecido)
    {
        Util::addPessoa($this->favorecido, $favorecido);
        return $this;
    }

    /**
     * Retorna a entidade beneficiario
     *
     * @return PessoaContract
     */
    public function getFavorecido()
    {
        return $this->favorecido;
    }

    /**
     * Define o número da conta
     *
     * @param  string $conta
     *
     * @return AbstractPagamento
     */
    public function setConta($conta)
    {
        $this->conta = (string)$conta;

        return $this;
    }

    /**
     * Retorna o número da conta
     *
     * @return string
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * Define o dígito verificador da conta
     *
     * @param  string $contaDv
     *
     * @return AbstractPagamento
     */
    public function setContaDv($contaDv)
    {
        $this->contaDv = $contaDv;

        return $this;
    }

    /**
     * Retorna o dígito verificador da conta
     *
     * @return string
     */
    public function getContaDv()
    {
        return $this->contaDv;
    }

    /**
     * Define o campo Número do documento
     *
     * @param  int $numeroDocumento
     *
     * @return AbstractPagamento
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;

        return $this;
    }

    /**
     * Retorna o campo Número do documento
     *
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * Define a data de pagamento
     *
     * @param  \Carbon\Carbon $data
     *
     * @return AbstractPagamento
     */
    public function setData(Carbon $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Retorna a data do pagamento
     *
     * @return \Carbon\Carbon
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Define o valor
     *
     * @param  string $valor
     *
     * @return AbstractPagamento
     */
    public function setValor($valor)
    {
        $this->valor = Util::nFloat($valor, 2, false);

        return $this;
    }

    /**
     * Retorna o valor total do boleto (incluindo taxas)
     *
     * @return string
     */
    public function getValor()
    {
        return Util::nFloat($this->valor, 2, false);
    }

    /**
     * Mostra exception ao erroneamente tentar setar o nosso número
     *
     * @throws \Exception
     */
    final public function setNossoNumero()
    {
        throw new \Exception('Não é possível definir o nosso número diretamente. Utilize o método setNumero.');
    }

    /**
     * Método que valida se o banco tem todos os campos obrigadotorios preenchidos
     *
     * @return boolean
     */
    public function isValid(&$messages)
    {
        foreach ($this->camposObrigatorios as $campo) {
            if (call_user_func([$this, 'get' . ucwords($campo)]) == '') {
                $messages .= "Campo $campo está em branco";
                return false;
            }
        }
        return true;
    }



}
