<?php
namespace Murilo\Pagamento\Cnab\Retorno\Cnab240\Banco;

use Exception;
use Murilo\Pagamento\Cnab\Retorno\Cnab240\AbstractRetorno;
use Murilo\Pagamento\Cnab\Retorno\Cnab240\Detalhe;
use Murilo\Pagamento\Contracts\Boleto\Boleto as BoletoContract;
use Murilo\Pagamento\Contracts\Cnab\RetornoCnab240;
use Murilo\Pagamento\Util;

/**
 * Class Sicredi
 * @package Murilo\Pagamento\Cnab\Retorno\Cnab240\Banco
 */
class Sicredi extends AbstractRetorno implements RetornoCnab240
{
    /**
     * Código do banco
     *
     * @var string
     */
    protected $codigoBanco = BoletoContract::COD_BANCO_SICREDI;

    /**
     * Array com as ocorrencias do banco;
     *
     * @var array
     */
    private $ocorrencias = [
        '00' => 'Crédito ou débito efetivado à indica que o pagamento foi confirmado',
        '01' => 'Insuficiência de fundos - débito não efetuado',
        '02' => 'Crédito ou débito cancelado pelo pagador/credor',
        '03' => 'Débito autorizado pela agência - efetuado',
        'AA' => 'Controle inválido',
        'AB' => 'Tipo de operação inválido',
        'AC' => 'Tipo de serviço inválido',
        'AD' => 'Forma de lançamento inválida',
        'AE' => 'Tipo/número de inscrição inválido',
        'AF' => 'Código de convênio inválido',
        'AG' => 'Agência/conta corrente/dv inválido',
        'AH' => 'No sequencial do registro no lote inválido',
        'AI' => 'Código de segmento de detalhe inválido',
        'AJ' => 'Tipo de movimento inválido',
        'AK' => 'Código da câmara de compensação do banco favorecido/depositário inválido',
        'AL' => 'Código do banco favorecido ou depositário inválido',
        'AM' => 'Agência mantenedora da conta corrente do favorecido inválida',
        'AN' => 'Conta corrente/dv do favorecido inválido',
        'AO' => 'Nome do favorecido não informado',
        'AP' => 'Data lançamento inválido',
        'AQ' => 'Tipo/quantidade da moeda inválido',
        'AR' => 'Valor do lançamento inválido',
        'AS' => 'Aviso ao favorecido - identificação inválida',
        'AT' => 'Tipo/número de inscrição do favorecido inválido',
        'AU' => 'Logradouro do favorecido não informado',
        'AV' => 'No do local do favorecido não informado',
        'AW' => 'Cidade do favorecido não informada',
        'AX' => 'Cep/complemento do favorecido inválido',
        'AY' => 'Sigla do estado do favorecido inválida',
        'AZ' => 'Código/nome do banco depositário inválido',
        'BA' => 'Código/nome da agência depositária não informado',
        'BB' => 'Seu número inválido',
        'BC' => 'Nosso número inválido',
        'BD' => 'Inclusão efetuada com sucesso',
        'BE' => 'Alteração efetuada com sucesso',
        'BF' => 'Exclusão efetuada com sucesso',
        'BG' => 'Agência/conta impedida legalmente',
        'BH' => 'Empresa não pagou salário',
        'BI' => 'Falecimento do mutuário',
        'BJ' => 'Empresa não enviou remessa do mutuário',
        'BK' => 'Empresa não enviou remessa no vencimento',
        'BL' => 'Valor da parcela inválida',
        'BM' => 'Identificação do contrato inválida',
        'BN' => 'Operação de consignação incluída com sucesso',
        'BO' => 'Operação de consignação alterada com sucesso',
        'BP' => 'Operação de consignação excluída com sucesso',
        'BQ' => 'Operação de consignação liquidada com sucesso',
        'CA' => 'Código de barras - código do banco inválido',
        'CB' => 'Código de barras - código da moeda inválido',
        'CC' => 'Código de barras - dígito verificador geral inválido',
        'CD' => 'Código de barras - valor do título inválido',
        'CE' => 'Código de barras - campo livre inválido',
        'CF' => 'Valor do documento inválido',
        'CG' => 'Valor do abatimento inválido',
        'CH' => 'Valor do desconto inválido',
        'CI' => 'Valor de mora inválido',
        'CJ' => 'Valor da multa inválido',
        'CK' => 'Valor do ir inválido',
        'CL' => 'Valor do iss inválido',
        'CM' => 'Valor do iof inválido',
        'CN' => 'Valor de outras deduções inválido',
        'CO' => 'Valor de outros acréscimos inválido',
        'CP' => 'Valor do inss inválido',
        'HA' => 'Lote não aceito',
        'HB' => 'Inscrição da empresa inválida para o contrato',
        'HC' => 'Convênio com a empresa inexistente/inválido para o contrato',
        'HD' => 'Agência/conta corrente da empresa inexistente/inválido para o contrato',
        'HE' => 'Tipo de serviço inválido para o contrato',
        'HF' => 'Conta corrente da empresa com saldo insuficiente',
        'HG' => 'Lote de serviço fora de sequência',
        'HH' => 'Lote de serviço inválido',
        'HI' => 'Arquivo não aceito',
        'HJ' => 'Tipo de registro inválido',
        'HK' => 'Código remessa / retorno inválido',
        'HL' => 'Versão de leiaute inválida',
        'HM' => 'Mutuário não identificado',
        'HN' => 'Tipo do benefício não permite empréstimo',
        'HO' => 'Benefício cessado/suspenso',
        'HP' => 'Benefício possui representante legal',
        'HQ' => 'Benefício é do tipo pa (pensão alimentícia)',
        'HR' => 'Quantidade de contratos permitida excedida',
        'HS' => 'Benefício não pertence ao banco informado',
        'HT' => 'Início do desconto informado já ultrapassado',
        'HU' => 'Número da parcela inválida',
        'HV' => 'Quantidade de parcela inválida',
        'HW' => 'Margem consignável excedida para o mutuário dentro do prazo do contrato',
        'HX' => 'Empréstimo já cadastrado',
        'HY' => 'Empréstimo inexistente',
        'HZ' => 'Empréstimo já encerrado',
        'H1' => 'Arquivo sem trailer',
        'H2' => 'Mutuário sem crédito na competência',
        'H3' => 'Não descontado – outros motivos',
        'H4' => 'Retorno de crédito não pago',
        'H5' => 'Cancelamento de empréstimo retroativo',
        'H6' => 'Outros motivos de glosa',
        'H7' => 'Margem consignável excedida para o mutuário acima do prazo do contrato',
        'H8' => 'Mutuário desligado do empregador',
        'H9' => 'Mutuário afastado por licença',
        'TA' => 'Lote não aceito - totais do lote com diferença',
        'YA' => 'Título não encontrado',
        'YB' => 'Identificador registro opcional inválido',
        'YC' => 'Código padrão inválido',
        'YD' => 'Código de ocorrência inválido',
        'YE' => 'Complemento de ocorrência inválido',
        'YF' => 'Alegação já informada',
        'ZA' => 'Agência / conta do favorecido substituída',
        'ZB' => 'Divergência entre o primeiro e último nome do beneficiário versus primeiro e último nome na receita federal',
        'ZC' => 'Confirmação de antecipação de valor',
        'ZD' => 'Antecipação parcial de valor',
        'ZE' => 'Título bloqueado na base',
        'ZF' => 'Sistema em contingência - título valor maior que referência',
        'ZG' => 'Sistema em contingência - título vencido',
        'ZH' => 'Sistema em contingência - título indexado',
        'ZI' => 'Beneficiário divergente',
        'ZK' => 'Boleto já liquidado',
        'ZJ' => 'Limite de pagamento parciais excedido',
    ];

    /**
     * Roda antes dos metodos de processar
     */
    protected function init()
    {
        $this->totais = [
            'liquidados' => 0,
            'entradas' => 0,
            'baixados' => 0,
            'protestados' => 0,
            'erros' => 0,
            'alterados' => 0,
            'excluidos' => 0,
        ];
    }

    /**
     * @param array $header
     * @return bool
     * @throws Exception
     */
    protected function processarHeader(array $header)
    {
        $this->getHeader()
            ->setCodBanco($this->rem(1, 3, $header))
            ->setLoteServico($this->rem(4, 7, $header))
            ->setTipoRegistro($this->rem(8, 8, $header))
            ->setTipoInscricao($this->rem(18, 18, $header))
            ->setNumeroInscricao($this->rem(19, 32, $header))
            ->setConvenio($this->rem(33, 52, $header))
            ->setCodigoCedente($this->rem(33, 52, $header))
            ->setAgencia($this->rem(53, 57, $header))
            ->setAgenciaDv($this->rem(58, 58, $header))
            ->setConta($this->rem(59, 70, $header))
            ->setContaDv($this->rem(71, 71, $header))
            ->setNomeEmpresa($this->rem(73, 102, $header))
            ->setDocumentoEmpresa($this->rem(19, 32, $header))
            ->setNomeBanco($this->rem(103, 132, $header))
            ->setCodigoRemessaRetorno($this->rem(143, 143, $header))
            ->setData($this->rem(144, 151, $header))
            ->setNumeroSequencialArquivo($this->rem(158, 163, $header))
            ->setVersaoLayoutArquivo($this->rem(164, 166, $header));

        if (empty($this->getHeader()->getNomeBanco())) {
            $this->getHeader()->setNomeBanco(Util::$bancos[$this->rem(1, 3, $header)]);
        }

        return true;
    }

    /**
     * @param array $headerLote
     *
     * @return bool
     * @throws Exception
     */
    protected function processarHeaderLote(array $headerLote)
    {
        $this->getHeaderLote()
            ->setCodBanco($this->rem(1, 3, $headerLote))
            ->setNumeroLoteRetorno($this->rem(4, 7, $headerLote))
            ->setTipoRegistro($this->rem(8, 8, $headerLote))
            ->setTipoOperacao($this->rem(9, 9, $headerLote))
            ->setTipoServico($this->rem(10, 11, $headerLote))
            ->setVersaoLayoutLote($this->rem(14, 16, $headerLote))
            ->setTipoInscricao($this->rem(18, 18, $headerLote))
            ->setNumeroInscricao($this->rem(19, 32, $headerLote))
            ->setConvenio($this->rem(33, 52, $headerLote))
            ->setAgencia($this->rem(53, 57, $headerLote))
            ->setAgenciaDv($this->rem(58, 58, $headerLote))
            ->setConta($this->rem(59, 70, $headerLote))
            ->setContaDv($this->rem(71, 71, $headerLote))
            ->setNomeEmpresa($this->rem(73, 102, $headerLote));

        return true;
    }

    /**
     * @param array $detalhe
     * @return bool
     * @throws Exception
     */
    protected function processarDetalhe(array $detalhe)
    {
        /** @var Detalhe $d */
        $d = $this->detalheAtual();

        $favorecido = [];
        $contaFavorecido = [];

        if ($this->getSegmentType($detalhe) == 'A') {
            $d->setOcorrencia($this->rem(231, 240, $detalhe))
                ->setOcorrenciaDescricao(array_get($this->ocorrencias, $this->detalheAtual()->getOcorrencia(), 'Desconhecida'))
                ->setNossoNumero($this->rem(135, 154, $detalhe))
                ->setNumeroDocumento($this->rem(74, 93, $detalhe))
                ->setDataCredito($this->rem(94, 101, $detalhe))
                ->setValor(Util::nFloat($this->rem(120, 134, $detalhe)/100, 2, false));

            $favorecido['nome'] = $this->rem(44, 73, $detalhe);
            $contaFavorecido['banco'] = $this->rem(21, 23, $detalhe);
            $contaFavorecido['agencia'] = $this->rem(24, 28, $detalhe);
            $contaFavorecido['agenciaDv'] = $this->rem(29, 29, $detalhe);
            $contaFavorecido['conta'] = $this->rem(30, 41, $detalhe);
            $contaFavorecido['contaDv'] = $this->rem(42, 42, $detalhe);

            /**
             * ocorrencias
             */
            if ($d->hasOcorrencia('00', '03', 'BQ', 'ZK')) {
                $this->totais['liquidados']++;
                $d->setOcorrenciaTipo($d::OCORRENCIA_LIQUIDADA);
            } elseif ($d->hasOcorrencia('BD', 'BN')) {
                $this->totais['entradas']++;
                $d->setOcorrenciaTipo($d::OCORRENCIA_ENTRADA);
            } elseif ($d->hasOcorrencia('14', '40', 'K2')) {
                $this->totais['protestados']++;
                $d->setOcorrenciaTipo($d::OCORRENCIA_PROTESTADA);
            } elseif ($d->hasOcorrencia('BE', 'BO')) {
                $this->totais['alterados']++;
                $d->setOcorrenciaTipo($d::OCORRENCIA_ALTERACAO);
            } elseif ($d->hasOcorrencia('BF', 'BP')) {
                $this->totais['excluidos']++;
                $d->setOcorrenciaTipo($d::OCORRENCIA_BAIXADA);
            } else {
                if (isset($this->ocorrencias[$d->getOcorrencia()])) {
                    $d->setError($this->ocorrencias[$d->getOcorrencia()]);
                }

                $d->setOcorrenciaTipo($d::OCORRENCIA_OUTROS);
            }
        }

        if ($this->getSegmentType($detalhe) == 'B') {
            $d->setDataVencimento($this->rem(128, 135, $detalhe))
                ->setValorAbatimento(Util::nFloat($this->rem(151, 165, $detalhe)/100, 2, false))
                ->setValorDesconto(Util::nFloat($this->rem(166, 180, $detalhe)/100, 2, false))
                ->setValorMora(Util::nFloat($this->rem(181, 195, $detalhe)/100, 2, false))
                ->setValorMulta(Util::nFloat($this->rem(196, 210, $detalhe)/100, 2, false));

            $documento = $this->rem(19, 32, $detalhe);

            if ($this->rem(18, 18, $detalhe) == 1) {
                $documento = substr($documento, 3);
            }

            $favorecido['documento'] = $documento;
        }

        if ($d->getContaFavorecido() === null && !empty($favorecido)) {
            $contaFavorecido['pessoa'] = $favorecido;
            $d->setContaFavorecido($contaFavorecido);
        }

        if ($d->getContaPagador() === null) {
            $d->setContaPagador([
                'banco' => $this->getHeader()->getCodBanco(),
                'agencia' => $this->getHeader()->getAgencia(),
                'agenciaDv' => $this->getHeader()->getAgenciaDv(),
                'conta' => $this->getHeader()->getConta(),
                'contaDv' => $this->getHeader()->getContaDv(),
                'pessoa' => [
                    'nome' => $this->getHeader()->getNomeEmpresa(),
                    'documento' => $this->getHeader()->getDocumentoEmpresa(),
                ],
            ]);
        }

        if ($this->getSegmentType($detalhe) == 'U') {
            $d->setValorDesconto(Util::nFloat($this->rem(33, 47, $detalhe)/100, 2, false))
                ->setValorAbatimento(Util::nFloat($this->rem(48, 62, $detalhe)/100, 2, false))
                ->setValorIOF(Util::nFloat($this->rem(63, 77, $detalhe)/100, 2, false))
                ->setValorRecebido(Util::nFloat($this->rem(93, 107, $detalhe)/100, 2, false))
                ->setDataOcorrencia($this->rem(138, 145, $detalhe))
                ->setDataCredito($this->rem(146, 153, $detalhe));
        }

        return true;
    }

    /**
     * @param array $trailer
     *
     * @return bool
     * @throws Exception
     */
    protected function processarTrailerLote(array $trailer)
    {
        $this->getTrailerLote()
            ->setLoteServico($this->rem(4, 7, $trailer))
            ->setTipoRegistro($this->rem(8, 8, $trailer))
            ->setQtdRegistroLote((int) $this->rem(18, 23, $trailer))
            ->setValorTotalTitulos(Util::nFloat($this->rem(24, 41, $trailer)/100, 2, false));

        return true;
    }

    /**
     * @param array $trailer
     * @return bool
     * @throws Exception
     */
    protected function processarTrailer(array $trailer)
    {
        $this->getTrailer()
            ->setNumeroLote($this->rem(4, 7, $trailer))
            ->setTipoRegistro($this->rem(8, 8, $trailer))
            ->setQtdLotesArquivo((int) $this->rem(18, 23, $trailer))
            ->setQtdRegistroArquivo((int) $this->rem(24, 29, $trailer));

        return true;
    }
}
