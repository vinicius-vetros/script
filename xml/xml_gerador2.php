<?php 

    /**
    *
    * 26/01/2022
    *
    * Gerador de XML através de um array na "unha", sem usar nenhuma classe ou biblioteca
    * 
    * @author VINICIUS BARSOTELI <vinicius@vetros.com.br>
    *
    */

    //
    $array = array (

        'cliente' => array (
            'nome' => $pedido['nome'],
            'tipoPessoa' => ($pedido['cpf'] ? 'F' : 'J'),
            'endereco' => $pedido['endereco'],
            'cpf_cnpj' => ($pedido['cpf'] ? $pedido['cpf'] : $pedido['cnpj']),
            'ie' => $pedido['nome'],
            'numero' => $pedido['numero'],
            'complemento' => $pedido['complemento'],
            'bairro' => $pedido['bairro'],
            'cep' => $pedido['cep'],
            'cidade' => $pedido['cidade'],
            'uf' => $pedido['uf'],
            'fone' => ($pedido['celular'] ?: $pedido['telefone']),
            'email' => $pedido['email']
        ),     
        'empdept' => 'account',
        'transporte' => array (
            'transportadora' => $pedido['frete_tipo'],
            'tipo_frete' => 'T', //
            'servico_correios' => $pedido['frete_tipo'],
            'dados_etiqueta' => array (
                'nome' => $pedido['nome'],
                'endereco' => $pedido['endereco'],
                'numero' => $pedido['numero'],
                'complemento' => $pedido['complemento'],
                'municipio' => $pedido['municipio'],
                'uf' => $pedido['uf'],
                'cep' => $pedido['cep'],
                'bairro' => $pedido['bairro'],
            ),
            'volumes' => array (
                'volume' => array (
                    'servico' => $pedido['frete_tipo'],
                    'codigoRastreamento' => $pedido['frete_rastreio'],
                ),                  
            ),
        ),
        'itens' => array('item' => $array_produtos['item']),
        'parcelas' => array(
            'parcela' => array(
                'data' => '',
                'vlr' => '',
                'obs' => '',
            ),
        ),
        'vlr_frete' => $pedido['vl_frete'],
        'vlr_desconto' => $pedido['vl_desconto'],
        'obs' => '...',
        'obs_internas' => '...',
    );

    //
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<pedido>';

    //
    foreach($array as $n1_campo => $n1_valor) {

        //
        if (is_array($n1_valor)) {

            //
            echo '<'.$n1_campo.'>';

                //
                foreach($n1_valor as $n2_campo => $n2_valor) {

                    //
                    if (in_array($n2_campo, array('item'))) {

                        //
                        for ($i=0; $i<sizeof($n2_valor); $i++) {

                            //
                            echo '<'.$n2_campo.'>';

                            //
                            foreach($n2_valor[$i] as $n3_campo => $n3_valor) {

                                //
                                echo '<'.$n3_campo.'>';
                                echo $n3_valor;
                                echo '</'.$n3_campo.'>';

                            }

                            //
                            echo '</'.$n2_campo.'>';

                        }

                    } else {
                            
                        //
                        echo '<'.$n2_campo.'>';

                        //
                        if (is_array($n2_valor)) {

                            //
                            foreach($n2_valor as $n3_campo => $n3_valor) {
    
                                //
                                echo '<'.$n3_campo.'>';

                                //
                                if (is_array($n3_valor)) {
    
                                    //
                                    foreach($n3_valor as $n4_campo => $n4_valor) {

                                        //
                                        echo '<'.$n4_campo.'>';

                                        //
                                        if (is_array($n4_valor)) {
    
                                            //
                                            foreach($n4_valor as $n5_campo => $n5_valor) {
                                                        
                                                //
                                                echo '<'.$n5_campo.'>';
                                                echo $n5_valor;
                                                echo '</'.$n5_campo.'>';

                                            }
                                            
                                        } else
                                            echo $n4_valor;

                                        //
                                        echo '</'.$n4_campo.'>';

                                    }

                                } else
                                    echo $n3_valor;

                                //
                                echo '</'.$n3_campo.'>';

                            }

                        } else
                            echo $n2_valor;

                        //
                        echo '</'.$n2_campo.'>';

                    }

                }

            echo '</'.$n1_campo.'>';

        } else
            echo '<'.$n1_campo.'>'.$n1_valor.'</'.$n1_campo.'>';


    }

    //
    echo '</pedido>';

    //
    exit;