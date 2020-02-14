<?php

namespace Murilo\Pagamento\Cnab\Remessa;

use Murilo\Pagamento\Contracts\Boleto\Boleto as BoletoContract;
use Murilo\Pagamento\Contracts\Pessoa as PessoaContract;
use Murilo\Pagamento\Contracts\Pagamento\Pagamento as PagamentoContract;
use Murilo\Pagamento\Support\Collection;
use Murilo\Pagamento\Util;

/**
 * Class AbstractRemessa
 * @package Murilo\Pagamento\Cnab\Remessa
 */
abstract class AbstractRemessa
{

    const HEADER = 'header';
    const HEADER_LOTE = 'header_lote';
    const DETALHE = 'detalhe';
    const TRAILER_LOTE = 'trailer_lote';
    const TRAILER = 'trailer';

    protected $tamanho_linha = false;

    /**
     * Campos que são necessários para a remessa
     *
     * @var array
     */
    private $camposObrigatorios = [
        'carteira',
        'agencia',
        'conta',
        'contaDv',
        'beneficiario',
    ];

    const ISPB = [
        '001' => '00000000',
        '070' => '00000208',
        '272' => '00250699',
        '136' => '00315557',
        '104' => '00360305',
        '077' => '00416968',
        '741' => '00517645',
        '330' => '00556603',
        '739' => '00558456',
        '743' => '00795423',
        '100' => '00806535',
        '096' => '00997185',
        '747' => '01023570',
        '322' => '01073966',
        '748' => '01181521',
        '752' => '01522368',
        '091' => '01634601',
        '399' => '01701201',
        '108' => '01800019',
        '756' => '02038232',
        '757' => '02318507',
        '102' => '02332886',
        '084' => '02398976',
        '180' => '02685483',
        '066' => '02801938',
        '015' => '02819125',
        '143' => '02992317',
        '062' => '03012230',
        '074' => '03017677',
        '099' => '03046391',
        '326' => '03311443',
        '025' => '03323840',
        '315' => '03502968',
        '075' => '03532415',
        '040' => '03609817',
        '307' => '03751794',
        '190' => '03973814',
        '296' => '04062902',
        '063' => '04184779',
        '191' => '04257795',
        '064' => '04332281',
        '097' => '04632856',
        '016' => '04715685',
        '299' => '04814563',
        '012' => '04866275',
        '003' => '04902979',
        '060' => '04913129',
        '037' => '04913711',
        '159' => '05442029',
        '085' => '05463212',
        '114' => '05790149',
        '036' => '06271464',
        '394' => '07207996',
        '004' => '07237373',
        '320' => '07450604',
        '189' => '07512441',
        '105' => '07652226',
        '076' => '07656500',
        '082' => '07679404',
        '286' => '07853842',
        '093' => '07945233',
        '273' => '08253539',
        '290' => '08561701',
        '157' => '09105360',
        '183' => '09210106',
        '014' => '09274232',
        '130' => '09313766',
        '127' => '09512542',
        '079' => '09516419',
        '340' => '09554480',
        '081' => '10264663',
        '133' => '10398952',
        '323' => '10573521',
        '121' => '10664513',
        '083' => '10690848',
        '138' => '10853017',
        '024' => '10866788',
        '319' => '11495073',
        '274' => '11581339',
        '095' => '11703662',
        '094' => '11758741',
        '118' => '11932017',
        '276' => '11970623',
        '092' => '12865507',
        '047' => '13009717',
        '144' => '13059145',
        '332' => '13140088',
        '126' => '13220493',
        '325' => '13293225',
        '301' => '13370835',
        '173' => '13486793',
        '331' => '13673855',
        '119' => '13720915',
        '309' => '14190547',
        '254' => '14388334',
        '268' => '14511781',
        '107' >> '15114366',
        '412' => '15173776',
        '124' => '15357060',
        '149' => '15581638',
        '197' => '16501555',
        '142' => '16944141',
        '389' => '17184037',
        '184' => '17298092',
        '634' => '17351180',
        '545' => '17352220',
        '132' => '17453575',
        '298' => '17772370',
        '321' => '18188384',
        '260' => '18236120',
        '129' => '18520834',
        '128' => '19307785',
        '194' => '20155248',
        '310' => '22610500',
        '163' => '23522214',
        '280' => '23862762',
        '146' => '24074692',
        '343' => '24537861',
        '279' => '26563270',
        '335' => '27098060',
        '349' => '27214112',
        '182' => '27406222',
        '278' => '27652684',
        '271' => '27842177',
        '021' => '28127603',
        '246' => '28195667',
        '292' => '28650236',
        '751' => '29030467',
        '352' => '29162769',
        '208' => '30306294',
        '746' => '30723886',
        '241' => '31597552',
        '336' => '31872495',
        '612' => '31880826',
        '604' => '31895683',
        '505' => '32062580',
        '329' => '32402502',
        '196' => '32648370',
        '342' => '32997490',
        '300' => '33042151',
        '477' => '33042953',
        '266' => '33132044',
        '122' => '33147315',
        '376' => '33172537',
        '348' => '33264668',
        '473' => '33466988',
        '745' => '33479023',
        '120' => '33603457',
        '265' => '33644196',
        '007' => '33657248',
        '188' => '33775974',
        '134' => '33862244',
        '029' => '33885724',
        '243' => '33923798',
        '078' => '34111187',
        '355' => '34335592',
        '111' => '36113876',
        '306' => '40303299',
        '017' => '42272526',
        '174' => '43180355',
        '495' => '44189447',
        '125' => '45246410',
        '488' => '46518205',
        '065' => '48795256',
        '492' => '49336860',
        '145' => '50579044',
        '250' => '50585090',
        '354' => '52904364',
        '253' => '52937216',
        '269' => '53518684',
        '213' => '54403563',
        '139' => '55230916',
        '018' => '57839805',
        '422' => '58160789',
        '630' => '58497702',
        '224' => '58616418',
        '600' => '59118133',
        '623' => '59285411',
        '655' => '59588111',
        '479' => '60394079',
        '456' => '60498557',
        '464' => '60518222',
        '341' => '60701190',
        '237' => '60746948',
        '613' => '60850229',
        '652' => '60872504',
        '637' => '60889128',
        '653' => '61024352',
        '069' => '61033106',
        '370' => '61088183',
        '249' => '61182408',
        '318' => '61186680',
        '626' => '61348538',
        '270' => '61444949',
        '366' => '61533584',
        '113' => '61723847',
        '131' => '61747085',
        '011' => '61809182',
        '611' => '61820817',
        '755' => '62073200',
        '089' => '62109566',
        '643' => '62144175',
        '140' => '62169875',
        '707' => '62232889',
        '288' => '62237649',
        '101' => '62287735',
        '487' => '62331228',
        '233' => '62421979',
        '177' => '65913436',
        '633' => '68900810',
        '218' => '71027866',
        '169' => '71371686',
        '293' => '71590442',
        '285' => '71677850',
        '080' => '73622748',
        '753' => '74828799',
        '222' => '75647891',
        '281' => '76461557',
        '754' => '76543115',
        '098' => '78157146',
        '610' => '78626983',
        '712' => '78632767',
        '010' => '81723108',
        '283' => '89960090',
        '033' => '90400888',
        '217' => '91884981',
        '041' => '92702067',
        '117' => '92856905',
        '654' => '92874270',
        '212' => '92894922',
        '289' => '94968518',
    ];

    /**
     * Código do banco
     *
     * @var string
     */
    protected $codigoBanco;

    /**
     * Contagem dos registros Detalhes
     *
     * @var int
     */
    protected $iRegistros = 0;

    /**
     * Array contendo o cnab.
     *
     * @var array
     */
    protected $aRegistros = [
        self::HEADER => [],
        self::DETALHE => [],
        self::TRAILER => [],
    ];

    /**
     * Variavel com ponteiro para linha que esta sendo editada.
     *
     * @var
     */
    protected $atual;

    /**
     * Caracter de fim de linha
     *
     * @var string
     */
    protected $fimLinha = "\n";

    /**
     * Caracter de fim de arquivo
     *
     * @var null
     */
    protected $fimArquivo = null;

    /**
     * ID do arquivo remessa, sequencial.
     *
     * @var
     */
    protected $idremessa;

    /**
     * Agência
     *
     * @var int
     */
    protected $agencia;

    /**
     * Conta
     *
     * @var int
     */
    protected $conta;

    /**
     * Dígito da conta
     *
     * @var int
     */
    protected $contaDv;

    /**
     * Carteira de cobrança.
     *
     * @var
     */
    protected $carteira;

    /**
     * Define as carteiras disponíveis para cada banco
     *
     * @var array
     */
    protected $carteiras = [];

    /**
     * Entidade beneficiario (quem esta gerando a remessa)
     *
     * @var PessoaContract
     */
    protected $beneficiario;

    /**
     * Construtor
     *
     * @param array $params Parâmetros iniciais para construção do objeto
     */
    public function __construct($params = [])
    {
        Util::fillClass($this, $params);
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
    public function getIdremessa()
    {
        return $this->idremessa;
    }

    /**
     * @param mixed $idremessa
     *
     * @return AbstractRemessa
     */
    public function setIdremessa($idremessa)
    {
        $this->idremessa = $idremessa;

        return $this;
    }

    /**
     * @return PessoaContract
     */
    public function getBeneficiario()
    {
        return $this->beneficiario;
    }

    /**
     * @param $beneficiario
     *
     * @return AbstractRemessa
     * @throws \Exception
     */
    public function setBeneficiario($beneficiario)
    {
        Util::addPessoa($this->beneficiario, $beneficiario);

        return $this;
    }

    /**
     * Define a agência
     *
     * @param $agencia
     * @return $this
     */
    public function setAgencia($agencia)
    {
        $this->agencia = (string)$agencia;

        return $this;
    }

    /**
     * Retorna a agência
     *
     * @return int
     */
    public function getAgencia()
    {
        return $this->agencia;
    }

    /**
     * Define o número da conta
     *
     * @param $conta
     * @return $this
     */
    public function setConta($conta)
    {
        $this->conta = (string)$conta;

        return $this;
    }

    /**
     * Retorna o número da conta
     *
     * @return int
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * Define o dígito verificador da conta
     *
     * @param $contaDv
     * @return $this
     */
    public function setContaDv($contaDv)
    {
        $this->contaDv = substr($contaDv, -1);

        return $this;
    }

    /**
     * Retorna o dígito verificador da conta
     *
     * @return int
     */
    public function getContaDv()
    {
        return $this->contaDv;
    }

    /**
     * Define o código da carteira (Com ou sem registro)
     *
     * @param $carteira
     * @return $this
     * @throws \Exception
     */
    public function setCarteira($carteira)
    {
        if (!in_array($carteira, $this->getCarteiras())) {
            throw new \Exception("Carteira não disponível!");
        }
        $this->carteira = $carteira;

        return $this;
    }

    /**
     * Retorna o código da carteira (Com ou sem registro)
     *
     * @return string
     */
    public function getCarteira()
    {
        return $this->carteira;
    }

    /**
     * Retorna o código da carteira (Com ou sem registro)
     *
     * @return string
     */
    public function getCarteiraNumero()
    {
        return $this->carteira;
    }

    /**
     * Retorna as carteiras disponíveis para este banco
     *
     * @return array
     */
    public function getCarteiras()
    {
        return $this->carteiras;
    }

    /**
     * Método que valida se o banco tem todos os campos obrigadotorios preenchidos
     *
     * @return boolean
     */
    public function isValid()
    {
        foreach ($this->camposObrigatorios as $campo) {
            if (call_user_func([$this, 'get' . ucwords($campo)]) == '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Função para gerar o cabeçalho do arquivo.
     *
     * @return mixed
     */
    abstract protected function header();

    /**
     * Função para adicionar detalhe ao arquivo.
     *
     * @param BoletoContract $detalhe
     * @return mixed
     */
    abstract public function addBoleto(BoletoContract $detalhe);

    /**
     * Função para adicionar detalhe ao arquivo.
     *
     * @param BoletoContract $detalhe
     * @return mixed
     */
    abstract public function addPagamento(PagamentoContract $detalhe);

    /**
     * Função que gera o trailer (footer) do arquivo.
     *
     * @return mixed
     */
    abstract protected function trailer();

    /**
     * Função que mostra a quantidade de linhas do arquivo.
     *
     * @return int
     */
    protected function getCount()
    {
        return count($this->aRegistros[self::DETALHE]) + 2;
    }

    /**
     * Função para adicionar multiplos boletos.
     *
     * @param array $boletos
     * @return $this
     */
    public function addBoletos(array $boletos)
    {
        foreach ($boletos as $boleto) {
            $this->addBoleto($boleto);
        }

        return $this;
    }

    /**
     * Função para adicionar multiplos pagamentos.
     *
     * @param array $pagamentos
     * @return $this
     */
    public function addPagamentos(array $pagamentos)
    {
        foreach ($pagamentos as $pagamento) {
            $this->addPagamento($pagamento);
        }

        return $this;
    }

    /**
     * Função para add valor a linha nas posições informadas.
     *
     * @param $i
     * @param $f
     * @param $value
     * @return array
     */
    protected function add($i, $f, $value)
    {
        return Util::adiciona($this->atual, $i, $f, $value);
    }

    /**
     * Retorna o header do arquivo.
     *
     * @return mixed
     */
    protected function getHeader()
    {
        return $this->aRegistros[self::HEADER];
    }

    /**
     * Retorna os detalhes do arquivo
     *
     * @return Collection
     */
    protected function getDetalhes()
    {
        return new Collection($this->aRegistros[self::DETALHE]);
    }

    /**
     * Retorna o trailer do arquivo.
     *
     * @return mixed
     */
    protected function getTrailer()
    {
        return $this->aRegistros[self::TRAILER];
    }

    /**
     * Valida se a linha esta correta.
     *
     * @param array $a
     * @return string
     * @throws \Exception
     */
    protected function valida(array $a)
    {
        if ($this->tamanho_linha === false) {
            throw new \Exception('Classe remessa deve informar o tamanho da linha');
        }

        $a = array_filter($a, 'strlen');
        if (count($a) != $this->tamanho_linha) {
            throw new \Exception(sprintf('$a não possui %s posições, possui: %s', $this->tamanho_linha, count($a)));
        }

        return implode('', $a);
    }

    /**
     * Gera o arquivo, retorna a string.
     *
     * @throws \Exception
     */
    public function gerar()
    {
        throw new \Exception('Método não implementado');
    }

    /**
     * Salva o arquivo no path informado
     *
     * @param $path
     * @return mixed
     * @throws \Exception
     */
    public function save($path)
    {
        $folder = dirname($path);
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        if (!is_writable(dirname($path))) {
            throw new \Exception('Path ' . $folder . ' não possui permissao de escrita');
        }

        $string = $this->gerar();
        file_put_contents($path, $string);

        return $path;
    }

    /**
     * Realiza o download da string retornada do metodo gerar
     *
     * @param null $filename
     */
    public function download($filename = null)
    {
        if ($filename === null) {
            $filename = 'remessa.txt';
        }
        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $this->gerar();
    }
}