<?php
namespace Murilo\Pagamento\Cnab\Retorno;

use Exception;
use Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240\Detalhe as Detalhe240Contract;
use Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240\Header as Header240Contract;
use Murilo\Pagamento\Contracts\Cnab\Retorno\Cnab240\Trailer as Trailer240Contract;
use Murilo\Pagamento\Support\Collection;
use Murilo\Pagamento\Util;
use OutOfBoundsException;

/**
 * Class AbstractRetorno
 * @package Murilo\Pagamento\Cnab\Retorno
 */
abstract class AbstractRetorno implements \Countable, \SeekableIterator
{
    /**
     * Se Cnab ja foi processado
     *
     * @var bool
     */
    protected $processado = false;

    /**
     * Código do banco
     *
     * @var string
     */
    protected $codigoBanco;

    /**
     * Incremeto de detalhes
     *
     * @var int
     */
    protected $increment = 0;

    /**
     * Arquivo transformado em array por linha.
     *
     * @var array
     */
    protected $file;

    /**
     * @var Header240Contract
     */
    protected $header;

    /**
     * @var Trailer240Contract
     */
    protected $trailer;

    /**
     * @var Detalhe240Contract[]
     */
    protected $detalhe = [];

    /**
     * Helper de totais.
     *
     * @var array
     */
    protected $totais = [];

    /**
     * @var int
     */
    private $_position = 1;

    /**
     *
     * @param String $file
     * @throws Exception
     */
    public function __construct($file)
    {
        $this->_position = 1;

        if (!$this->file = Util::file2array($file)) {
            throw new Exception('Arquivo: não existe');
        }

        $r = new \ReflectionClass('\Murilo\Pagamento\Contracts\Boleto\Boleto');
        $constantNames = $r->getConstants();
        $bancosDisponiveis = [];
        foreach ($constantNames as $constantName => $codigoBanco) {
            if (preg_match('/^COD_BANCO.*/', $constantName)) {
                $bancosDisponiveis[] = $codigoBanco;
            }
        }

        if (!Util::isHeaderRetorno($this->file[0])) {
            throw new Exception(sprintf('Arquivo de retorno inválido'));
        }

        $banco = Util::isCnab400($this->file[0]) ? substr($this->file[0], 76, 3) : substr($this->file[0], 0, 3);
        if (!in_array($banco, $bancosDisponiveis)) {
            throw new Exception(sprintf('Banco: %s, inválido', $banco));
        }
    }

    /**
     * Retorna o código do banco
     *
     * @return string
     */
    public function getCodigoBanco()
    {
        return $this->codigoBanco;
    }

    /**
     * @return mixed
     */
    public function getBancoNome()
    {
        return Util::$bancos[$this->codigoBanco];
    }

    /**
     * @return Collection
     */
    public function getDetalhes()
    {
        return new Collection($this->detalhe);
    }

    /**
     * @param $i
     *
     * @return Detalhe240Contract[]
     */
    public function getDetalhe($i)
    {
        return array_key_exists($i, $this->detalhe) ? $this->detalhe[$i] : null;
    }

    /**
     * @return Header240Contract
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return Trailer240Contract
     */
    public function getTrailer()
    {
        return $this->trailer;
    }

    /**
     * Retorna o detalhe atual.
     *
     * @return Detalhe240Contract
     */
    protected function detalheAtual()
    {
        return $this->detalhe[$this->increment];
    }

    /**
     * Se esta processado
     *
     * @return bool
     */
    protected function isProcessado()
    {
        return $this->processado;
    }

    /**
     * Seta cnab como processado
     *
     * @return $this
     */
    protected function setProcessado()
    {
        $this->processado = true;
        return $this;
    }

    /**
     * Incrementa o detalhe.
     */
    abstract protected function incrementDetalhe();

    /**
     * Processa o arquivo
     *
     * @return $this
     */
    abstract protected function processar();

    /**
     * Retorna o array.
     *
     * @return array
     */
    abstract protected function toArray();

    /**
     * Remove trecho do array.
     *
     * @param $i
     * @param $f
     * @param $array
     *
     * @return string
     * @throws Exception
     */
    protected function rem($i, $f, &$array)
    {
        return Util::remove($i, $f, $array);
    }


    /**
     * @return mixed|Detalhe240Contract
     */
    public function current()
    {
        return $this->detalhe[$this->_position];
    }

    /**
     *
     */
    public function next()
    {
        ++$this->_position;
    }

    /**
     * @return bool|float|int|string|null
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->detalhe[$this->_position]);
    }

    /**
     *
     */
    public function rewind()
    {
        $this->_position = 1;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->detalhe);
    }

    /**
     * @param int $position
     */
    public function seek($position)
    {
        $this->_position = $position;
        if (!$this->valid()) {
            throw new OutOfBoundsException('"Posição inválida "$position"');
        }
    }
}
